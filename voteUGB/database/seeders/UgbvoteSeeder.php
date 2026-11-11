<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UgbvoteSeeder extends Seeder
{
    public function run()
    {
        
        // 6. Insertion des Votes
        DB::table('votes')->insert([
            [
                'id_vote'   => 1,
                'date_debut'=> now()->subDays(3)->toDateString(),
                'date_fin'  => now()->addDays(12)->toDateString(),
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'id_vote'   => 2,
                'date_debut'=> now()->addDays(5)->toDateString(),
                'date_fin'  => now()->addDays(14)->toDateString(),
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
        // 1. Insertion des UFR
        DB::table('u_f_r_s')->insert([
            [
                'id_ufr'    => 1,
                'nom'       => 'sat',
                'vote_id'   => 1,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'id_ufr'    => 2,
                'nom'       => 'sjp',
                'vote_id'   => 2,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'id_ufr'    => 3,
                'nom'       => 'lsh',
                'vote_id'   => 2,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'id_ufr'    => 4,
                'nom'       => 's2ata',
                'vote_id'   => 2,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);

        // 2. Insertion des EtudiantOfficiels (les codes officiels)
        DB::table('etudiant_officiels')->insert([
            [
                'id'        => 1,
                'code'      => 'p31 2127',
                'created_at'=> '2025-03-29 18:05:03',
                'updated_at'=> '2025-03-29 18:05:03',
            ],
            [
                'id'        => 2,
                'code'      => 'p31 2227',
                'created_at'=> '2025-03-29 18:05:03',
                'updated_at'=> '2025-03-29 18:05:03',
            ],
            [
                'id'        => 3,
                'code'      => 'p31 2327',
                'created_at'=> '2025-03-29 18:05:03',
                'updated_at'=> '2025-03-29 18:05:03',
            ],
            [
                'id'        => 4,
                'code'      => 'p312121',
                'created_at'=> '2025-04-02 01:47:52',
                'updated_at'=> '2025-04-02 01:47:55',
            ],
            [
                'id'        => 5,
                'code'      => 'p312277',
                'created_at'=> '2025-04-02 17:17:21',
                'updated_at'=> '2025-04-02 17:17:25',
            ],
            [
                'id'        => 6,
                'code'      => 'p310000',
                'created_at'=> '2025-04-02 17:37:55',
                'updated_at'=> '2025-04-02 17:37:57',
            ],
            [
                'id'        => 7,
                'code'      => 'p312278',
                'created_at'=> '2025-04-02 17:37:55',
                'updated_at'=> '2025-04-02 17:37:57',
            ],
            [
                'id'        => 8,
                'code'      => 'p310001',
                'created_at'=> '2025-04-02 17:37:55',
                'updated_at'=> '2025-04-02 17:37:57',
            ],
            [
                'id'        => 9,
                'code'      => 'p31 3001', // code libre : permet de tester l'inscription
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'id'        => 10,
                'code'      => 'p31 3002', // code libre : permet de tester l'inscription
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'id'        => 11,
                'code'      => 'p31 3003', // code libre : permet de tester l'inscription
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
        

        // 3. Insertion des Étudiants
        DB::table('etudiants')->insert([
            [
                'id_etudiant'   => 1,
                'nom'           => 'gueye',
                'prenom'        => 'amteh',
                'code_etudiant' => 'p31 2127',
                'email'          => 'ameth@gmail.com',
                'mdp'           => Hash::make('ameth31'),
                'ufr_id'        => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id_etudiant'   => 2,
                'nom'           => 'diop',
                'prenom'        => 'anta',
                'code_etudiant' => 'p31 2327',
                'email'          => 'anta@gmail.com',
                'mdp'           => Hash::make('anta31'),
                'ufr_id'        => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id_etudiant'   => 3,
                'nom'           => 'fickou',
                'prenom'        => 'daouda',
                'code_etudiant' => 'p31 2227',
                'email'          => 'daouda@gmail.com',
                'mdp'           => Hash::make('daouda31'),
                'ufr_id'        => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id_etudiant'   => 4,
                'nom'           => 'test1',
                'prenom'        => 'test1',
                'code_etudiant' => 'p312121',
                'email'         => 'test1@gmail.com',
                'mdp'           => '$2y$12$jjM9UrzPFU9t9zJjLUzR/OP26KtMWwDoU4lWfBtGD1L0QQCx0U/JS', // Ton mot de passe déjà hashé
                'ufr_id'        => 1,
                'created_at'    => '2025-03-31 20:35:16',
                'updated_at'    => '2025-03-31 20:35:16',
            ],
            [
                'id_etudiant'   => 5,
                'nom'           => 'gueye',
                'prenom'        => 'Mouhamdou',
                'code_etudiant' => 'p312277',
                'email'         => 'gueye.mouhamadou7@ugb.edu.sn',
                'mdp'           => '$2y$12$hGNPXW8VyTNB.30624vx6OoRIQ/fvI87m18yNZErjst..4LRIlsVa', // Ton mot de passe déjà hashé
                'ufr_id'        => 1,
                'created_at'    => '2025-04-02 01:11:42',
                'updated_at'    => '2025-04-02 01:11:42',
            ],
            [
                'id_etudiant'   => 6,
                'nom'           => 'gueye',
                'prenom'        => 'Mouhamdou2',
                'code_etudiant' => 'p310000',
                'email'         => '2gueye.mouhamadou7@ugb.edu.sn',
                'mdp'           => '$2y$12$SfzCN3bWv9GG6sQBa11V/.DuORS/PXpvoVo0AwAqxQMUmaCzSV6Cq', // Ton mot de passe déjà hashé
                'ufr_id'        => 1,
                'created_at'    => '2025-04-02 01:48:33',
                'updated_at'    => '2025-04-02 01:48:33',
            ],
            [
                'id_etudiant'   => 7,
                'nom'           => 'Nom',
                'prenom'        => 'Prenom',
                'code_etudiant' => 'p312278',
                'email'         => 'prenom@gmaill.com',
                'mdp'           => '$2y$12$WrwAV5hPfKoq8Kc7KcyQXOnSsVaQiCscne7RMe.UU6T2rGUnHkfXO', // Ton mot de passe déjà hashé
                'ufr_id'        => 1,
                'created_at'    => '2025-04-02 17:20:27',
                'updated_at'    => '2025-04-02 17:20:27',
            ],
            [
                'id_etudiant'   => 8,
                'nom'           => 'Nom',
                'prenom'        => 'Prenom',
                'code_etudiant' => 'p310001',
                'email'         => 'exemple@gmail.com',
                'mdp'           => '$2y$12$cichfOIiJN0pKMZAlRClru3/ZhyHkaDzB2M14mz/Rlf6ySuVxHYHW', // Ton mot de passe déjà hashé
                'ufr_id'        => 1,
                'created_at'    => '2025-04-02 18:34:18',
                'updated_at'    => '2025-04-02 18:34:18',
            ],
        ]);

        // 4. Insertion des Listes
        DB::table('listes')->insert([
            [
                'id_list'   => 1,
                'programme' => "Un campus connecté : Wi-Fi fiable dans toutes les salles et résidences.\nDes salles d'étude ouvertes plus tard en période d'examens.\nUn guichet unique pour les démarches de bourse et d'inscription.\nDes ateliers CV, stages et insertion professionnelle chaque semestre.",
                'name_list' => 'Convergeons vers un avenir meilleur',
                'ufr_id'    => 1,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'id_list'   => 2,
                'programme' => "Des hackathons et clubs tech ouverts à toutes les filières.\nUne restauration de qualité à prix étudiant.\nPlus de transparence : un compte rendu public après chaque conseil d'UFR.\nUn fonds de solidarité pour les étudiants en difficulté.",
                'name_list' => 'craquer pour crack',
                'ufr_id'    => 1,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'id_list'   => 3,
                'programme' => 'Et est dolor enim elit ad labore sint ex aute. Nostrud ipsum cillum voluptate nisi labore laborum nisi. Labore aliqua exercitation eiusmod voluptate culpa aliquip voluptate minim incididunt eu eiusmod. Aliquip officia minim fugiat proident dolor nulla est aute in dolor sit laboris occaecat. Ut pariatur nisi mollit commodo. Est aute veniam exercitation excepteur mollit. Tempor sit proident do nisi sunt incididunt Lorem dolore. Velit ut cillum incididunt id mollit dolore est ea. Labore labore pariatur commodo consectetur nisi amet qui nisi commodo. Dolore tempor anim Lorem reprehenderit voluptate labore excepteur sit sint magna. Ut incididunt sit consectetur non velit minim veniam quis cupidatat nostrud nostrud. Excepteur in do sint cupidatat cillum nostrud aliqua reprehenderit nulla in labore Lorem magna. Voluptate ea adipisicing Lorem non cupidatat pariatur commodo eiusmod mollit pariatur velit ex et aute. Consequat laborum in irure veniam non dolore et quis esse eu cillum proident nisi non. Aliqua officia laborum proident non veniam id reprehenderit sunt. Labore excepteur laborum quis ea fugiat ullamco excepteur eu ipsum. Minim ad ut cupidatat mollit ea eu. Ea duis duis eu magna reprehenderit elit voluptate tempor est do. Labore reprehenderit consequat duis elit do amet commodo est minim. Voluptate adipisicing id tempor sint eiusmod aliquip ipsum incididunt laboris ut. Exercitation eu irure consequat deserunt culpa do. Excepteur mollit dolor do est tempor. Ea dolor amet non amet Lorem cillum nulla sit est. Dolor velit labore ea dolore fugiat reprehenderit. Consequat dolor eu id labore excepteur elit. Irure ea cupidatat irure elit nulla minim velit eu mollit dolor tempor anim ipsum pariatur. Culpa consequat commodo Lorem anim ullamco qui non qui ad cupidatat ad culpa voluptate. Ad eu occaecat proident ullamco ad elit ipsum est dolor. Ea exercitation culpa dolor irure adipisicing. Magna pariatur laboris voluptate Lorem nisi consequat occaecat nulla excepteur dolor proident deserunt commodo duis. Anim laboris labore aliqua aliqua deserunt duis labore Lorem qui tempor dolore. Esse et proident sunt sit nostrud sint. Ad aliqua adipisicing qui proident in aliqua do reprehenderit duis. Ex dolore exercitation aute veniam ut aliqua adipisicing adipisicing laborum nulla ea anim eu. Officia nostrud dolore magna amet. Magna pariatur fugiat pariatur velit tempor culpa occaecat ullamco id. Id pariatur nulla anim tempor aute amet. Deserunt velit laborum ea incididunt enim in amet cupidatat deserunt laborum et ullamco sunt do. Aliquip aliqua consectetur consequat sit enim est est id anim pariatur elit voluptate. Quis cillum irure labore commodo excepteur. Et commodo in laborum quis esse in quis. Dolor amet ut consectetur cupidatat minim esse.',
                'name_list' => 'TitreDuProgramme',
                'ufr_id'    => 1,
                'created_at'=> now(),
                'updated_at'=> now(),
            ]
        ]);
        

        // 5. Insertion des MembresListe
        DB::table('membres_listes')->insert([
            [
                'id'         => 1,
                'id_membre'  => 2, // correspond à l'étudiant Diop
                'list_id'    => 1,
                'tete_liste' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 2,
                'id_membre'  => 3, // correspond à l'étudiant Fickou
                'list_id'    => 1,
                'tete_liste' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 3,
                'id_membre'  => 1, // correspond à l'étudiant Gueye
                'list_id'    => 2,
                'tete_liste' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 4,
                'id_membre'  => 3, // correspond à l'étudiant Fickou
                'list_id'    => 2,
                'tete_liste' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 5,
                'id_membre'  => 1, // correspond à l'étudiant Gueye
                'list_id'    => 3,
                'tete_liste' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 6,
                'id_membre'  => 2, // correspond à l'étudiant Diop
                'list_id'    => 3,
                'tete_liste' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 7,
                'id_membre'  => 3, // correspond à l'étudiant Fickou
                'list_id'    => 3,
                'tete_liste' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        


        // Émargements (qui a voté) et bulletins anonymes (pour qui) : deux tables sans lien entre elles.
        foreach ([1 => 2, 2 => 2, 3 => 1, 4 => 1, 5 => 0] as $etudiant => $ilYaJours) {
            DB::table('emargements')->insert([
                'etudiant_id' => $etudiant,
                'vote_id'     => 1,
                'voted_at'    => now()->subDays($ilYaJours)->subHours(3),
            ]);
        }

        foreach ([1, 2, 1, 2, 3] as $liste) {
            DB::table('bulletins')->insert([
                'id'      => (string) \Illuminate\Support\Str::uuid(),
                'vote_id' => 1,
                'list_id' => $liste,
            ]);
        }

        // Pages de campagne de démonstration.
        DB::table('listes')->where('id_list', 1)->update(['slogan' => 'Ensemble, faisons converger nos ambitions.', 'titre' => 'Notre vision pour la SAT']);
        DB::table('listes')->where('id_list', 2)->update(['slogan' => 'Du code, des idées, des actes.', 'titre' => 'Une UFR qui ose']);

        DB::table('membres_listes')->where('id', 1)->update(['role' => 'Présidente']);
        DB::table('membres_listes')->where('id', 2)->update(['role' => 'Secrétaire général']);
        DB::table('membres_listes')->where('id', 3)->update(['role' => 'Président']);
        DB::table('membres_listes')->where('id', 4)->update(['role' => 'Trésorier']);

        $propositions = [
            [1, 'pedagogie', "Salles d'étude ouvertes jusqu'à 23 h en période d'examens."],
            [1, 'pedagogie', 'Tutorat entre étudiants de master et de licence, chaque semaine.'],
            [1, 'numerique', 'Wi-Fi fiable dans toutes les salles et les résidences.'],
            [1, 'social', 'Guichet unique pour les démarches de bourse et d\'inscription.'],
            [1, 'insertion', 'Ateliers CV et forum des stages chaque semestre.'],
            [1, 'sport', 'Tournoi inter-UFR et semaine culturelle annuelle.'],
            [2, 'numerique', 'Hackathons et clubs tech ouverts à toutes les filières.'],
            [2, 'numerique', 'Prêt d\'ordinateurs portables pour les étudiants boursiers.'],
            [2, 'restauration', 'Une restauration de qualité à prix étudiant, avec menu affiché en ligne.'],
            [2, 'social', 'Fonds de solidarité pour les étudiants en difficulté.'],
            [2, 'pedagogie', 'Compte rendu public après chaque conseil d\'UFR.'],
            [2, 'insertion', 'Partenariats de stage avec les entreprises de Saint-Louis et de Dakar.'],
        ];

        foreach ($propositions as [$liste, $theme, $texte]) {
            DB::table('propositions')->insert(['list_id' => $liste, 'theme' => $theme, 'texte' => $texte, 'created_at' => now(), 'updated_at' => now()]);
        }

        $realisations = [
            [1, '2025-2026', 'Extension des horaires de la bibliothèque', 'Obtenue après concertation avec la direction : ouverture le samedi matin.'],
            [1, '2024-2025', 'Collecte de manuels', 'Plus de 300 ouvrages redistribués aux étudiants de première année.'],
            [2, '2025-2026', 'Premier hackathon de la SAT', '48 heures, 12 équipes, trois projets accompagnés par des entreprises partenaires.'],
            [2, '2024-2025', 'Club de programmation', 'Séances hebdomadaires gratuites, ouvertes aux débutants.'],
        ];

        foreach ($realisations as [$liste, $annee, $titre, $description]) {
            DB::table('realisations')->insert(['list_id' => $liste, 'annee' => $annee, 'titre' => $titre, 'description' => $description, 'created_at' => now(), 'updated_at' => now()]);
        }

        DB::table('admins')->insert([
            'id'   => 1,
            'name' => 'Admin principal',
            'email'=> 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);
    }
}

