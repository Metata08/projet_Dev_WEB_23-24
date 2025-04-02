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
            $table->string('email')->unique();
            $table->string('mdp');
            $table->unsignedBigInteger('ufr_id');
            $table->foreign('ufr_id')->references('id_ufr')->on('ufrs')->onDelete('cascade');
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
