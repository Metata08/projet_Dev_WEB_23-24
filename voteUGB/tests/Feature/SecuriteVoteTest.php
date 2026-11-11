<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Etudiant;
use App\Models\Listes;
use App\Models\UFR;
use App\Models\Bulletin;
use App\Models\Emargement;
use App\Models\Votes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Règles de sécurité et de fiabilité du scrutin.
 */
class SecuriteVoteTest extends TestCase
{
    use RefreshDatabase;

    private UFR $sat;

    private UFR $sjp;

    private Listes $listeSat;

    private Listes $autreListeSat;

    private Listes $listeSjp;

    private Etudiant $etudiant;

    protected function setUp(): void
    {
        parent::setUp();

        $ouvert = Votes::create(['date_debut' => now()->subDay(), 'date_fin' => now()->addDay()]);

        $this->sat = UFR::create(['nom' => 'sat', 'vote_id' => $ouvert->id_vote]);
        $this->sjp = UFR::create(['nom' => 'sjp', 'vote_id' => $ouvert->id_vote]);

        $this->listeSat = Listes::create(['name_list' => 'Liste A', 'programme' => 'Programme A', 'ufr_id' => $this->sat->id_ufr]);
        $this->autreListeSat = Listes::create(['name_list' => 'Liste B', 'programme' => 'Programme B', 'ufr_id' => $this->sat->id_ufr]);
        $this->listeSjp = Listes::create(['name_list' => 'Liste C', 'programme' => 'Programme C', 'ufr_id' => $this->sjp->id_ufr]);

        DB::table('etudiant_officiels')->insert([['code' => 'p31 0001'], ['code' => 'p31 0002']]);

        $this->etudiant = Etudiant::create([
            'prenom' => 'awa', 'nom' => 'ndiaye', 'code_etudiant' => 'p31 0001',
            'email' => 'awa@ugb.edu.sn', 'ufr_id' => $this->sat->id_ufr, 'mdp' => Hash::make('Campus2026'),
        ]);
    }

    public function test_les_pages_publiques_s_affichent_avec_les_en_tetes_de_securite(): void
    {
        foreach (['/', '/login', '/inscription', '/admin'] as $url) {
            $reponse = $this->get($url)->assertOk();
            $reponse->assertHeader('X-Frame-Options', 'DENY');
            $reponse->assertHeader('X-Content-Type-Options', 'nosniff');
            $this->assertStringContainsString("script-src 'self'", $reponse->headers->get('Content-Security-Policy'));
        }
    }

    public function test_l_espace_etudiant_exige_une_connexion(): void
    {
        foreach (['/election', '/resultat', '/resultats/json', '/detailListe/1', '/systemevote/1'] as $url) {
            $this->get($url)->assertRedirect(route('login'));
        }
        $this->post('/systemevote/1')->assertRedirect(route('login'));
    }

    public function test_l_espace_admin_est_inaccessible_sans_session_admin(): void
    {
        foreach (['/admin/tableau-de-bord', '/admin/electeurs', '/admin/listes', '/admin/scrutins', '/admin/stats.json'] as $url) {
            $this->get($url)->assertRedirect(route('admin'));
            // Un étudiant connecté n'est pas un administrateur.
            $this->actingAs($this->etudiant, 'web')->get($url)->assertRedirect(route('admin'));
        }

        $this->delete('/admin/electeurs/'.$this->etudiant->id_etudiant)->assertRedirect(route('admin'));
        $this->assertDatabaseHas('etudiants', ['email' => 'awa@ugb.edu.sn']);
    }

    public function test_connexion_admin_avec_mot_de_passe_hache(): void
    {
        Admin::create(['name' => 'Admin', 'email' => 'admin@ugb.sn', 'password' => 'secret-admin']);

        $this->assertNotSame('secret-admin', Admin::first()->password);

        $this->post('/admin/login', ['email' => 'admin@ugb.sn', 'password' => 'mauvais'])->assertSessionHasErrors('email');
        $this->assertGuest('admin');

        $this->post('/admin/login', ['email' => 'admin@ugb.sn', 'password' => 'secret-admin'])->assertRedirect(route('dashboardAdmin'));
        $this->assertAuthenticated('admin');
        $this->get('/admin/tableau-de-bord')->assertOk();

        $this->post('/admin/logout')->assertRedirect(route('admin'));
        $this->assertGuest('admin');
    }

    public function test_un_etudiant_peut_voter_une_seule_fois(): void
    {
        $this->actingAs($this->etudiant, 'web');

        $this->post('/systemevote/'.$this->listeSat->id_list, ['confirmation' => '1'])
            ->assertRedirect(route('election'))->assertSessionHas('vote_ok');

        // Second vote, même pour une autre liste : refusé.
        $this->post('/systemevote/'.$this->autreListeSat->id_list, ['confirmation' => '1'])
            ->assertRedirect(route('election'))->assertSessionHas('error');

        $this->assertSame(1, Emargement::where('etudiant_id', $this->etudiant->id_etudiant)->count());
        $this->assertSame(1, Bulletin::count());
    }

    public function test_la_base_de_donnees_interdit_le_double_vote(): void
    {
        $ligne = ['etudiant_id' => $this->etudiant->id_etudiant, 'vote_id' => $this->sat->vote_id, 'voted_at' => now()];
        Emargement::create($ligne);

        $this->expectException(\Illuminate\Database\UniqueConstraintViolationException::class);
        Emargement::create($ligne);
    }

    public function test_le_vote_exige_une_confirmation_explicite(): void
    {
        $this->actingAs($this->etudiant, 'web')
            ->post('/systemevote/'.$this->listeSat->id_list)
            ->assertSessionHasErrors('confirmation');

        $this->assertSame(0, Bulletin::count() + Emargement::count());
    }

    public function test_impossible_de_voter_pour_une_liste_d_une_autre_ufr(): void
    {
        $this->actingAs($this->etudiant, 'web');

        $this->get('/detailListe/'.$this->listeSjp->id_list)->assertNotFound();
        $this->get('/systemevote/'.$this->listeSjp->id_list)->assertNotFound();
        $this->post('/systemevote/'.$this->listeSjp->id_list, ['confirmation' => '1'])->assertNotFound();

        $this->assertSame(0, Bulletin::count() + Emargement::count());
    }

    public function test_impossible_de_voter_hors_de_la_periode_du_scrutin(): void
    {
        $this->sat->scrutin->update(['date_debut' => now()->subDays(10), 'date_fin' => now()->subDays(2)]);

        $this->actingAs($this->etudiant, 'web')
            ->post('/systemevote/'.$this->listeSat->id_list, ['confirmation' => '1'])
            ->assertRedirect(route('election'))->assertSessionHas('error');

        $this->sat->scrutin->update(['date_debut' => now()->addDays(2), 'date_fin' => now()->addDays(5)]);

        $this->post('/systemevote/'.$this->listeSat->id_list, ['confirmation' => '1'])->assertSessionHas('error');

        $this->assertSame(0, Bulletin::count() + Emargement::count());
    }

    public function test_l_identifiant_de_scrutin_envoye_par_le_navigateur_est_ignore(): void
    {
        $autre = Votes::create(['date_debut' => now()->subDay(), 'date_fin' => now()->addDay()]);

        $this->actingAs($this->etudiant, 'web')
            ->post('/systemevote/'.$this->listeSat->id_list, ['confirmation' => '1', 'vote_id' => $autre->id_vote]);

        $this->assertDatabaseHas('emargements', ['etudiant_id' => $this->etudiant->id_etudiant, 'vote_id' => $this->sat->vote_id]);
        $this->assertDatabaseMissing('emargements', ['vote_id' => $autre->id_vote]);
        $this->assertDatabaseMissing('bulletins', ['vote_id' => $autre->id_vote]);
    }

    public function test_l_inscription_exige_un_code_etudiant_officiel_et_un_mot_de_passe_robuste(): void
    {
        $donnees = [
            'prenom' => 'Moussa', 'nom' => 'Fall', 'code' => 'p31 9999', 'email' => 'Moussa@UGB.edu.sn',
            'ufr' => $this->sat->id_ufr, 'password' => 'Campus2026', 'password_confirmation' => 'Campus2026',
        ];

        // Code inconnu de l'université.
        $this->post('/inscription', $donnees)->assertSessionHasErrors('code');
        // Code déjà utilisé par un autre compte.
        $this->post('/inscription', ['code' => 'p31 0001'] + $donnees)->assertSessionHasErrors('code');
        // Mot de passe trop faible.
        $this->post('/inscription', ['code' => 'p31 0002', 'password' => 'abc', 'password_confirmation' => 'abc'] + $donnees)
            ->assertSessionHasErrors('password');

        $this->post('/inscription', ['code' => 'p31 0002'] + $donnees)->assertRedirect(route('login'));

        $cree = Etudiant::where('email', 'moussa@ugb.edu.sn')->firstOrFail();
        $this->assertTrue(Hash::check('Campus2026', $cree->mdp));

        $this->post('/login', ['email' => 'moussa@ugb.edu.sn', 'password' => 'Campus2026'])->assertRedirect(route('election'));
        $this->assertAuthenticatedAs($cree, 'web');
    }

    public function test_la_connexion_est_limitee_contre_la_force_brute(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => 'awa@ugb.edu.sn', 'password' => 'faux'])->assertSessionHasErrors('email');
        }

        $this->post('/login', ['email' => 'awa@ugb.edu.sn', 'password' => 'faux'])->assertStatus(429);
    }

    public function test_les_resultats_sont_limites_a_l_ufr_de_l_etudiant(): void
    {
        $this->actingAs($this->etudiant, 'web')->post('/systemevote/'.$this->listeSat->id_list, ['confirmation' => '1']);

        $json = $this->actingAs($this->etudiant, 'web')->get('/resultats/json')->assertOk()->json();

        $this->assertSame('SAT', $json['ufr']);
        $this->assertSame(1, $json['total_votes']);
        $this->assertEqualsCanonicalizing(['Liste A', 'Liste B'], array_column($json['resultats'], 'liste'));
        $this->assertEquals(100, $json['resultats'][0]['pourcentage']);
    }

    public function test_les_pages_de_l_espace_etudiant_s_affichent(): void
    {
        $this->actingAs($this->etudiant, 'web');

        $this->get('/election')->assertOk()->assertSee('Liste A')->assertDontSee('Liste C');
        $this->get('/detailListe/'.$this->listeSat->id_list)->assertOk()->assertSee('Programme A');
        $this->get('/systemevote/'.$this->listeSat->id_list)->assertOk()->assertSee('Confirmer mon vote');
        $this->get('/resultat')->assertOk();
    }

    public function test_l_admin_gere_listes_electeurs_et_scrutins(): void
    {
        $admin = Admin::create(['name' => 'Admin', 'email' => 'admin@ugb.sn', 'password' => 'secret-admin']);
        $this->actingAs($admin, 'admin');

        foreach (['/admin/tableau-de-bord', '/admin/electeurs', '/admin/listes', '/admin/scrutins', '/admin/stats.json'] as $url) {
            $this->get($url)->assertOk();
        }

        $this->post('/admin/listes', ['nom' => 'Liste D', 'programme' => 'Programme D', 'ufr' => $this->sjp->id_ufr])
            ->assertRedirect(route('listeCandidats'));
        $this->assertDatabaseHas('listes', ['name_list' => 'Liste D', 'ufr_id' => $this->sjp->id_ufr]);

        $this->delete('/admin/listes/'.$this->listeSjp->id_list)->assertRedirect(route('listeCandidats'));
        $this->assertDatabaseMissing('listes', ['name_list' => 'Liste C']);

        $this->put('/admin/scrutins/'.$this->sat->id_ufr, ['date_debut' => '2030-01-10', 'date_fin' => '2030-01-05'])
            ->assertSessionHasErrors('date_fin');
        $this->put('/admin/scrutins/'.$this->sat->id_ufr, ['date_debut' => '2030-01-10', 'date_fin' => '2030-01-20'])
            ->assertRedirect(route('listePostes'));
        $this->assertSame('2030-01-20', $this->sat->scrutin->fresh()->date_fin->toDateString());

        $this->delete('/admin/electeurs/'.$this->etudiant->id_etudiant)->assertRedirect(route('listeElecteurs'));
        $this->assertDatabaseMissing('etudiants', ['email' => 'awa@ugb.edu.sn']);
    }
}
