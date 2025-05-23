<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id('id_etudiant');
            $table->string('nom');
            $table->string('prenom');
            $table->string('code_etudiant')->unique();
            $table->string('email')->unique();
            $table->string('mdp');
            $table->unsignedBigInteger('ufr_id');
            $table->foreign('ufr_id')->references('id_ufr')->on('u_f_r_s')->onDelete('cascade');
            $table->foreign('code_etudiant')->references('code')->on('etudiant_officiels')->onDelete('cascade');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
