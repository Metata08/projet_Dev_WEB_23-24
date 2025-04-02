<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('u_f_r_s', function (Blueprint $table) {
            $table->unsignedBigInteger('vote_id')->nullable()->after('id_ufr');
            $table->foreign('vote_id')->references('id_vote')->on('votes')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('u_f_r_s', function (Blueprint $table) {
            $table->dropForeign(['vote_id']);
            $table->dropColumn('vote_id');
        });
    }
};
