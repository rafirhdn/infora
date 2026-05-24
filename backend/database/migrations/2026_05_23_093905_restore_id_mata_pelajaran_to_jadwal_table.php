<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {

            $table->unsignedBigInteger('id_mata_pelajaran')
                ->nullable()
                ->after('id_guru');

            $table->foreign('id_mata_pelajaran')
                ->references('id_mata_pelajaran')
                ->on('mata_pelajaran')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {

            $table->dropForeign(['id_mata_pelajaran']);

            $table->dropColumn('id_mata_pelajaran');
        });
    }
};