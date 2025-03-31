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
        Schema::table('listes', function (Blueprint $table) {
            $table->string('titre')->nullable()->after('programme');
        });
    }

    public function down()
    {
        Schema::table('listes', function (Blueprint $table) {
            $table->dropColumn('titre');
        });
    }
};
