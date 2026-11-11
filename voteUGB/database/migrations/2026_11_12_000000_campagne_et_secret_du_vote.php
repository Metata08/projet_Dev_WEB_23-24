<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Secret du vote : on sépare « qui a voté » (émargement) de « pour qui » (bulletin).
         * Un bulletin ne porte ni identifiant d'étudiant, ni date, ni numéro d'ordre :
         * sa clé est un UUID aléatoire, il est donc impossible de le relier à un émargement.
         */
        Schema::create('emargements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id');
            $table->unsignedBigInteger('vote_id');
            $table->timestamp('voted_at')->useCurrent();
            $table->foreign('etudiant_id')->references('id_etudiant')->on('etudiants')->onDelete('cascade');
            $table->foreign('vote_id')->references('id_vote')->on('votes')->onDelete('cascade');
            $table->unique(['etudiant_id', 'vote_id'], 'emargement_unique_par_etudiant');
        });

        Schema::create('bulletins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('vote_id');
            $table->unsignedBigInteger('list_id');
            // Empreinte SHA-256 du reçu remis à l'électeur (le reçu lui-même n'est jamais stocké).
            $table->string('recu_hash', 64)->nullable()->unique();
            $table->foreign('vote_id')->references('id_vote')->on('votes')->onDelete('cascade');
            $table->foreign('list_id')->references('id_list')->on('listes')->onDelete('cascade');
        });

        // Reprise des votes existants, dans un ordre mélangé, puis suppression de l'ancienne table nominative.
        if (Schema::hasTable('vote_etudiants')) {
            $anciens = DB::table('vote_etudiants')->get();

            foreach ($anciens as $vote) {
                DB::table('emargements')->insert([
                    'etudiant_id' => $vote->etudiant_id,
                    'vote_id' => $vote->vote_id,
                    'voted_at' => $vote->voted_at,
                ]);
            }

            foreach ($anciens->shuffle() as $vote) {
                DB::table('bulletins')->insert([
                    'id' => (string) Str::uuid(),
                    'vote_id' => $vote->vote_id,
                    'list_id' => $vote->list_id,
                ]);
            }

            Schema::drop('vote_etudiants');
        }

        Schema::table('votes', function (Blueprint $table) {
            $table->boolean('resultats_en_direct')->default(true);
        });

        Schema::table('listes', function (Blueprint $table) {
            $table->string('slogan', 160)->nullable();
            $table->string('logo')->nullable();
            // Les contenus déjà en ligne restent visibles ; toute modification par un candidat repasse en validation.
            $table->boolean('campagne_validee')->default(true);
        });

        Schema::table('membres_listes', function (Blueprint $table) {
            $table->string('role', 80)->nullable();
        });

        Schema::create('propositions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('list_id');
            $table->string('theme', 30);
            $table->string('texte', 400);
            $table->timestamps();
            $table->foreign('list_id')->references('id_list')->on('listes')->onDelete('cascade');
        });

        Schema::create('realisations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('list_id');
            $table->string('annee', 9)->nullable();
            $table->string('titre', 150);
            $table->string('description', 600)->nullable();
            $table->timestamps();
            $table->foreign('list_id')->references('id_list')->on('listes')->onDelete('cascade');
        });

        Schema::create('journal_admins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('admin_nom')->nullable();
            $table->string('action', 80);
            $table->string('details', 500)->nullable();
            $table->string('ip', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_admins');
        Schema::dropIfExists('realisations');
        Schema::dropIfExists('propositions');
        Schema::table('membres_listes', fn (Blueprint $table) => $table->dropColumn('role'));
        Schema::table('listes', fn (Blueprint $table) => $table->dropColumn(['slogan', 'logo', 'campagne_validee']));
        Schema::table('votes', fn (Blueprint $table) => $table->dropColumn('resultats_en_direct'));

        // Le lien étudiant ↔ bulletin n'existe plus : l'ancienne table est recréée vide.
        Schema::create('vote_etudiants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etudiant_id');
            $table->unsignedBigInteger('vote_id');
            $table->unsignedBigInteger('list_id');
            $table->timestamp('voted_at')->useCurrent();
            $table->timestamps();
            $table->unique(['etudiant_id', 'vote_id'], 'vote_unique_par_etudiant');
        });

        Schema::dropIfExists('bulletins');
        Schema::dropIfExists('emargements');
    }
};
