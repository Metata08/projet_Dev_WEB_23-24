<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Les mots de passe administrateur encore stockés en clair sont hachés (bcrypt).
        foreach (DB::table('admins')->get() as $admin) {
            if (! str_starts_with((string) $admin->password, '$2y$')) {
                DB::table('admins')->where('id', $admin->id)
                    ->update(['password' => Hash::make($admin->password)]);
            }
        }

        // 2) Un seul bulletin par étudiant et par scrutin : on ne garde que le premier
        //    bulletin d'éventuels doublons, puis la base interdit tout double vote.
        $premiers = DB::table('vote_etudiants')
            ->selectRaw('MIN(id) as id')
            ->groupBy('etudiant_id', 'vote_id')
            ->pluck('id');

        if ($premiers->isNotEmpty()) {
            DB::table('vote_etudiants')->whereNotIn('id', $premiers)->delete();
        }

        Schema::table('vote_etudiants', function (Blueprint $table) {
            $table->unique(['etudiant_id', 'vote_id'], 'vote_unique_par_etudiant');
        });
    }

    public function down(): void
    {
        Schema::table('vote_etudiants', function (Blueprint $table) {
            $table->dropUnique('vote_unique_par_etudiant');
        });
    }
};
