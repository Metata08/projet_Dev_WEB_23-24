<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UgbvoteSeeder extends Seeder
{
    public function run()
    {
        // 1. Insertion des UFR
        DB::table('u_f_r_s')->insert([
            [
                'id_ufr'    => 1,
                'nom'       => 'sat',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'id_ufr'    => 2,
                'nom'       => 'sjp',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);

        // 2. Insertion des EtudiantOfficiels (les codes officiels)
        DB::table('etudiant_officiels')->insert([
            [
                'code'      => 'p31 2127',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'code'      => 'p31 2227',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'code'      => 'p31 2327',
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
                'mail'          => 'ameth@gmail.com',
                'mdp'           => 'ameth31',
                'ufr_id'        => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id_etudiant'   => 2,
                'nom'           => 'diop',
                'prenom'        => 'anta',
                'code_etudiant' => 'p31 2227',
                'mail'          => 'anta@gmail.com',
                'mdp'           => 'anta31',
                'ufr_id'        => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id_etudiant'   => 3,
                'nom'           => 'fickou',
                'prenom'        => 'daouda',
                'code_etudiant' => 'p31 2327',
                'mail'          => 'daouda@gmail.com',
                'mdp'           => 'daouda31',
                'ufr_id'        => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);

        // 4. Insertion des Listes
        // D'après le fichier, la ligne "1 programme d-election de la liste convergence 1"
        // On déduit : id_list = 1, programme = "programme d-election de la liste",
        // name_list = "convergence", ufr_id = 1
        DB::table('listes')->insert([
            [
                'id_list'   => 1,
                'programme' => "programme d-election de la liste",
                'name_list' => "convergence",
                'ufr_id'    => 1,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);

        // 5. Insertion des MembresListe
        // D'après le fichier : deux enregistrements
        DB::table('membres_listes')->insert([
            [
                'id'         => 1,
                'id_membre'  => 2, // correspond à l'étudiant diop
                'list_id'    => 1,
                'tete_liste' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 2,
                'id_membre'  => 3, // correspond à l'étudiant fickou
                'list_id'    => 1,
                'tete_liste' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 6. Insertion des Votes
        DB::table('votes')->insert([
            [
                'id_vote'   => 1,
                'date_debut'=> '2025-03-29',
                'date_fin'  => '2025-04-05',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'id_vote'   => 2,
                'date_debut'=> '2025-04-06',
                'date_fin'  => '2025-04-15',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
    }
}

