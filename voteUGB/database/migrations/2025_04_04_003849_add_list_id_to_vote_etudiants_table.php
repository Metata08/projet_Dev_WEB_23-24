<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddListIdToVoteEtudiantsTable extends Migration
{
    public function up()
    {
        Schema::table('vote_etudiants', function (Blueprint $table) {
            // Ajout de la colonne list_id
            $table->unsignedBigInteger('list_id')->after('vote_id');

            // Optionnel : ajout de la clé étrangère
            $table->foreign('list_id')
                  ->references('id_list')
                  ->on('listes')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('vote_etudiants', function (Blueprint $table) {
            // Supprimer la contrainte de clé étrangère et la colonne
            $table->dropForeign(['list_id']);
            $table->dropColumn('list_id');
        });
    }
}
