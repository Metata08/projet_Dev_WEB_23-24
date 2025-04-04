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
        Schema::create('membres_listes', function (Blueprint $table) {
            $table->id();
            $table->boolean('tete_liste')->default(false);
            $table->unsignedBigInteger('list_id');
            $table->foreign('list_id')->references('id_list')->on('listes')->onDelete('cascade');

            $table->unsignedBigInteger('id_membre');
            $table->foreign('id_membre')->references('id_etudiant')->on('etudiants')->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membres_listes');
    }
};
