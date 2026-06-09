<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->unsignedTinyInteger('nilai_tugas')->nullable()->after('id_mapel');
            $table->unsignedTinyInteger('nilai_uts')->nullable()->after('nilai_tugas');
            $table->unsignedTinyInteger('nilai_uas')->nullable()->after('nilai_uts');
            $table->unsignedTinyInteger('nilai_praktik')->nullable()->after('nilai_uas');
            $table->unsignedTinyInteger('nilai_sikap')->nullable()->after('nilai_praktik');
            $table->unsignedTinyInteger('nilai_akhir')->nullable()->after('nilai_sikap');
            $table->string('predikat', 2)->nullable()->after('nilai_akhir');
            $table->boolean('validated_by_wali')->default(false)->after('predikat');
        });
    }

    public function down(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->dropColumn([
                'nilai_tugas',
                'nilai_uts',
                'nilai_uas',
                'nilai_praktik',
                'nilai_sikap',
                'nilai_akhir',
                'predikat',
                'validated_by_wali',
            ]);
        });
    }
};
