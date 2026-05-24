<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {

            if (
                Schema::hasColumn(
                    'jadwal',
                    'id_mata_pelajaran'
                )
            ) {
                $table->dropForeign([
                    'id_mata_pelajaran'
                ]);

                $table->dropColumn(
                    'id_mata_pelajaran'
                );
            }
        });
    }

    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {

            $table->unsignedBigInteger(
                'id_mata_pelajaran'
            )->nullable();

        });
    }
};