<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * La colonne vote_id (FK -> votes.id_vote) est ajoutée plus tard par
     * 2025_04_02_013118_add_vote_id_to_ufrs_table, une fois la table votes créée.
     */
    public function up(): void
    {
        Schema::create('u_f_r_s', function (Blueprint $table) {
            $table->id('id_ufr');
            $table->string('nom');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('u_f_r_s');
    }
};
