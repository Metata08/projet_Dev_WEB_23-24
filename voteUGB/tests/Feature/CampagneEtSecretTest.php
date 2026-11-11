<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Bulletin;
use App\Models\Emargement;
use App\Models\Etudiant;
use App\Models\JournalAdmin;
use App\Models\Listes;
use App\Models\MembresListe;
use App\Models\UFR;
use App\Models\Votes;
use App\Notifications\RappelVote;
use App\Notifications\ReinitialiserMotDePasse;
use App\Notifications\VoteEnregistre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Secret du vote, reçu, résultats masqués, campagne, mot de passe oublié, administration.
 */
class CampagneEtSecretTest extends TestCase
{
    use RefreshDatabase;

    private UFR $sat;

    private UFR $sjp;

    private Votes $scrutin;

    private Listes $liste;

    private Etudiant $tete;

    private Etudiant $electeur;

    private Etudiant $etranger;

    protected function setUp(): void
    {
        parent::setUp();

        $this->scrutin = Votes::create(['date_debut' => now()->subDay(), 'date_fin' => now()->addDay()]);
        $this->sat = UFR::create(['nom' => 'sat', 'vote_id' => $this->scrutin->id_vote]);
        $this->sjp = UFR::create(['nom' => 'sjp', 'vote_id' => $this->scrutin->id_vote]);
        $this->liste = Listes::create(['name_list' => 'Liste A', 'programme' => 'Programme A', 'ufr_id' => $this->sat->id_ufr]);

        DB::table('etudiant_officiels')->insert([['code' => 'c1'], ['code' => 'c2'], ['code' => 'c3']]);

        $this->tete = $this->etudiant('c1', 'tete@ugb.edu.sn', $this->sat);
        $this->electeur = $this->etudiant('c2', 'electeur@ugb.edu.sn', $this->sat);
        $this->etranger = $this->etudiant('c3', 'etranger@ugb.edu.sn', $this->sjp);

        MembresListe::create(['list_id' => $this->liste->id_list, 'id_membre' => $this->tete->id_etudiant, 'tete_liste' => true]);
    }

    private function etudiant(string $code, string $email, UFR $ufr): Etudiant
    {
        return Etudiant::create([
            'prenom' => 'awa', 'nom' => 'ndiaye', 'code_etudiant' => $code,
            'email' => $email, 'ufr_id' => $ufr->id_ufr, 'mdp' => Hash::make('Campus2026'),
        ]);
    }

    private function admin(): Admin
    {
        return Admin::create(['name' => 'Admin', 'email' => 'admin@ugb.sn', 'password' => 'secret-admin']);
    }

    public function test_le_bulletin_est_anonyme_et_le_recu_verifiable(): void
    {
        Notification::fake();

        $reponse = $this->actingAs($this->electeur, 'web')
            ->post('/systemevote/'.$this->liste->id_list, ['confirmation' => '1'])
            ->assertSessionHas('recu');

        $recu = $reponse->getSession()->get('recu');
        $this->assertMatchesRegularExpression('/^UGB-[A-Z2-9]{4}-[A-Z2-9]{4}-[A-Z2-9]{4}$/', $recu);

        // Aucune colonne ne relie un bulletin à un étudiant ou à un instant.
        $this->assertFalse(Schema::hasTable('vote_etudiants'));
        $this->assertEqualsCanonicalizing(['id', 'vote_id', 'list_id', 'recu_hash'], Schema::getColumnListing('bulletins'));
        $this->assertNotContains('list_id', Schema::getColumnListing('emargements'));

        // Le reçu n'est pas stocké en clair.
        $bulletin = Bulletin::firstOrFail();
        $this->assertNotSame($recu, $bulletin->recu_hash);
        $this->assertSame(Bulletin::empreinte($recu), $bulletin->recu_hash);

        // La vérification confirme la présence, sans jamais nommer la liste.
        $this->post('/recu', ['recu' => strtolower($recu)])->assertOk()->assertSee('Bulletin trouvé')->assertDontSee('Liste A');
        $this->post('/recu', ['recu' => 'UGB-AAAA-BBBB-CCCC'])->assertOk()->assertSee('Aucun bulletin ne correspond');

        // L'e-mail de confirmation est envoyé.
        Notification::assertSentTo($this->electeur, VoteEnregistre::class);
    }

    public function test_les_resultats_peuvent_etre_masques_jusqu_a_la_cloture(): void
    {
        Emargement::create(['etudiant_id' => $this->electeur->id_etudiant, 'vote_id' => $this->scrutin->id_vote, 'voted_at' => now()]);
        Bulletin::create(['vote_id' => $this->scrutin->id_vote, 'list_id' => $this->liste->id_list]);
        $this->scrutin->update(['resultats_en_direct' => false]);

        $this->actingAs($this->electeur, 'web');

        $json = $this->get('/resultats/json')->assertOk()->json();
        $this->assertFalse($json['visible']);
        $this->assertSame([], $json['resultats']);
        $this->assertSame(1, $json['votants']);
        $this->get('/resultat')->assertOk()->assertSee('dévoilé à la clôture')->assertDontSee('Classement des listes');

        // À la clôture, le détail devient public.
        $this->scrutin->update(['date_debut' => now()->subDays(5), 'date_fin' => now()->subDay()]);
        // (on recharge l'étudiant : en test, l'instance connectée garde ses relations en mémoire)
        $json = $this->actingAs($this->electeur->fresh(), 'web')->get('/resultats/json')->json();
        $this->assertTrue($json['visible']);
        $this->assertSame(1, $json['resultats'][0]['votes']);
    }

    public function test_seule_la_tete_de_liste_gere_sa_page_de_campagne(): void
    {
        $this->actingAs($this->electeur, 'web')->get('/ma-liste')->assertForbidden();
        $this->post('/ma-liste/propositions', ['theme' => 'social', 'texte' => 'Intrusion'])->assertForbidden();

        $this->actingAs($this->tete, 'web');
        $this->get('/ma-liste')->assertOk()->assertSee('Liste A');

        $this->put('/ma-liste', ['slogan' => 'Nouveau slogan', 'programme' => 'Nouvelle présentation'])->assertSessionHas('success');
        $this->post('/ma-liste/propositions', ['theme' => 'inconnu', 'texte' => 'x'])->assertSessionHasErrors('theme');
        $this->post('/ma-liste/propositions', ['theme' => 'social', 'texte' => 'Un fonds de solidarité'])->assertSessionHas('success');
        $this->post('/ma-liste/realisations', ['annee' => '2025-2026', 'titre' => 'Collecte de manuels'])->assertSessionHas('success');

        $this->assertFalse($this->liste->fresh()->campagne_validee);

        // Tant que l'administration n'a pas validé : le candidat voit sa version, pas les autres étudiants.
        $this->get('/detailListe/'.$this->liste->id_list)->assertSee('Un fonds de solidarité');
        $this->actingAs($this->electeur, 'web')->get('/detailListe/'.$this->liste->id_list)
            ->assertOk()->assertDontSee('Un fonds de solidarité')->assertSee('en cours de validation');
        $this->get('/comparer')->assertOk()->assertDontSee('Un fonds de solidarité');

        // Validation par l'administrateur → publication.
        $this->actingAs($this->admin(), 'admin')->post('/admin/listes/'.$this->liste->id_list.'/valider')->assertSessionHas('success');

        $this->actingAs($this->electeur, 'web');
        $this->get('/detailListe/'.$this->liste->id_list)->assertSee('Un fonds de solidarité')->assertSee('Collecte de manuels')->assertSee('Nouveau slogan');
        $this->get('/comparer')->assertSee('Un fonds de solidarité');
    }

    public function test_le_logo_n_accepte_que_des_images_et_reste_reserve_a_l_ufr(): void
    {
        Storage::fake('local');
        $this->actingAs($this->tete, 'web');

        $this->put('/ma-liste', ['programme' => 'P', 'logo' => UploadedFile::fake()->create('script.php', 10, 'application/x-php')])
            ->assertSessionHasErrors('logo');
        $this->put('/ma-liste', ['programme' => 'P', 'logo' => UploadedFile::fake()->create('logo.svg', 10, 'image/svg+xml')])
            ->assertSessionHasErrors('logo');

        $this->put('/ma-liste', ['programme' => 'P', 'logo' => UploadedFile::fake()->image('logo.png', 200, 200)])
            ->assertSessionHasNoErrors();

        $chemin = $this->liste->fresh()->logo;
        $this->assertStringStartsWith('logos/', $chemin);
        Storage::disk('local')->assertExists($chemin);

        $this->get('/listes/'.$this->liste->id_list.'/logo')->assertOk();
        $this->actingAs($this->etranger, 'web')->get('/listes/'.$this->liste->id_list.'/logo')->assertNotFound();
    }

    public function test_mot_de_passe_oublie(): void
    {
        Notification::fake();

        // Même réponse que le compte existe ou non.
        $this->post('/mot-de-passe-oublie', ['email' => 'inconnu@ugb.edu.sn'])->assertSessionHas('success');
        Notification::assertNothingSent();

        $this->post('/mot-de-passe-oublie', ['email' => 'Electeur@UGB.edu.sn'])->assertSessionHas('success');

        $jeton = null;
        Notification::assertSentTo($this->electeur, ReinitialiserMotDePasse::class, function ($notification) use (&$jeton) {
            $jeton = (fn () => $this->token)->call($notification);

            return true;
        });

        $nouveau = ['email' => 'electeur@ugb.edu.sn', 'password' => 'Nouveau2026', 'password_confirmation' => 'Nouveau2026'];

        $this->post('/reinitialiser', ['token' => 'faux-jeton'] + $nouveau)->assertSessionHasErrors('email');
        $this->post('/reinitialiser', ['token' => $jeton, 'password' => 'abc', 'password_confirmation' => 'abc'] + $nouveau)->assertSessionHasErrors('password');
        $this->post('/reinitialiser', ['token' => $jeton] + $nouveau)->assertRedirect(route('login'));

        $this->assertTrue(Hash::check('Nouveau2026', $this->electeur->fresh()->mdp));
        // Le lien ne sert qu'une fois.
        $this->post('/reinitialiser', ['token' => $jeton] + $nouveau)->assertSessionHasErrors('email');
    }

    public function test_l_admin_importe_des_codes_gere_les_membres_et_tout_est_journalise(): void
    {
        $this->actingAs($this->admin(), 'admin');

        $csv = UploadedFile::fake()->createWithContent('codes.csv', "code\np31 5001\np31 5002;c1\n<script>alert(1)</script>\n\n");
        $this->post('/admin/codes', ['fichier' => $csv])->assertSessionHas('success');

        $this->assertDatabaseHas('etudiant_officiels', ['code' => 'p31 5001']);
        $this->assertDatabaseHas('etudiant_officiels', ['code' => 'p31 5002']);
        $this->assertSame(5, DB::table('etudiant_officiels')->count()); // 3 existants + 2 nouveaux, sans doublon ni ligne invalide

        $this->post('/admin/codes', ['fichier' => UploadedFile::fake()->create('codes.exe', 5)])->assertSessionHasErrors('fichier');

        // Un code utilisé par un compte ne peut pas être supprimé.
        $idUtilise = DB::table('etudiant_officiels')->where('code', 'c1')->value('id');
        $this->delete('/admin/codes/'.$idUtilise)->assertSessionHas('error');
        $this->assertDatabaseHas('etudiant_officiels', ['code' => 'c1']);

        // Membres : même UFR obligatoire, une seule tête de liste.
        $this->post('/admin/listes/'.$this->liste->id_list.'/membres', ['etudiant' => $this->etranger->id_etudiant])->assertSessionHasErrors('etudiant');
        $this->post('/admin/listes/'.$this->liste->id_list.'/membres', ['etudiant' => $this->electeur->id_etudiant, 'role' => 'Trésorier', 'tete_liste' => '1'])
            ->assertSessionHas('success');

        $this->assertSame(1, $this->liste->membres()->where('tete_liste', true)->count());
        $this->assertSame($this->liste->id_list, $this->electeur->listeDirigee()->id_list);
        $this->assertNull($this->tete->listeDirigee());

        $this->put('/admin/scrutins/'.$this->sat->id_ufr, ['date_debut' => '2030-01-10', 'date_fin' => '2030-01-20'])->assertSessionHas('success');
        $this->assertFalse($this->scrutin->fresh()->resultats_en_direct);

        foreach (['/admin/listes/'.$this->liste->id_list, '/admin/codes', '/admin/journal', '/admin/scrutins/'.$this->sat->id_ufr.'/proces-verbal'] as $url) {
            $this->get($url)->assertOk();
        }

        $actions = JournalAdmin::pluck('action')->all();
        foreach (['Codes étudiants importés', 'Membre ajouté', 'Scrutin modifié', 'Procès-verbal consulté'] as $attendue) {
            $this->assertContains($attendue, $actions);
        }
    }

    public function test_les_nouvelles_pages_admin_exigent_une_session_admin(): void
    {
        foreach (['/admin/codes', '/admin/journal', '/admin/listes/'.$this->liste->id_list, '/admin/scrutins/'.$this->sat->id_ufr.'/proces-verbal'] as $url) {
            $this->actingAs($this->tete, 'web')->get($url)->assertRedirect(route('admin'));
        }
        $this->post('/admin/listes/'.$this->liste->id_list.'/valider')->assertRedirect(route('admin'));
    }

    public function test_le_rappel_n_est_envoye_qu_aux_non_votants_le_dernier_jour(): void
    {
        Notification::fake();
        $this->scrutin->update(['date_debut' => now()->subDays(3), 'date_fin' => now()]);
        Emargement::create(['etudiant_id' => $this->electeur->id_etudiant, 'vote_id' => $this->scrutin->id_vote, 'voted_at' => now()]);

        $this->artisan('ugbvote:notifier')->assertSuccessful();

        Notification::assertSentTo($this->tete, RappelVote::class);
        Notification::assertSentTo($this->etranger, RappelVote::class);
        Notification::assertNotSentTo($this->electeur, RappelVote::class);
    }
}
