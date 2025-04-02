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
        Schema::create('listes', function (Blueprint $table) {
            $table->id('id_list');
            $table->string('programme');
            $table->string('name_list');
            $table->unsignedBigInteger('ufr_id');
            // Précisez que la colonne référencée dans u_f_r_s est id_ufr
            $table->foreign('ufr_id')->references('id_ufr')->on('ufrs')->onDelete('cascade');
            
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listes');
    }
};
