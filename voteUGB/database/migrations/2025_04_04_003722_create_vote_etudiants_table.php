<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoteEtudiantsTable extends Migration
{
    public function up()
    {
        Schema::create('vote_etudiants', function (Blueprint $table) {
            $table->id(); // ID auto-incrémenté
            $table->unsignedBigInteger('etudiant_id');
            $table->unsignedBigInteger('vote_id');
            $table->timestamp('voted_at')->useCurrent(); // Date et heure du vote
            $table->timestamps();

            // Clés étrangères
            $table->foreign('etudiant_id')->references('id_etudiant')->on('etudiants')->onDelete('cascade');
            $table->foreign('vote_id')->references('id_vote')->on('votes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vote_etudiants');
    }
}
