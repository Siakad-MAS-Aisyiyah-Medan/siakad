<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->integer('nilai_angka')->nullable()->change();
            $table->foreignId('id_guru_input')->nullable()->after('id_mapel')
                ->constrained('users', 'id_user')->nullOnDelete();
            $table->foreignId('id_wali_validator')->nullable()->after('validated_by_wali')
                ->constrained('users', 'id_user')->nullOnDelete();
            $table->timestamp('validated_at')->nullable()->after('id_wali_validator');
        });

        Schema::table('nilai', function (Blueprint $table) {
            $table->unique(
                ['id_user_siswa', 'id_mapel', 'semester', 'tahun_ajaran'],
                'nilai_siswa_mapel_semester_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->dropUnique('nilai_siswa_mapel_semester_unique');
        });

        Schema::table('nilai', function (Blueprint $table) {
            $table->dropForeign(['id_guru_input']);
            $table->dropForeign(['id_wali_validator']);
            $table->dropColumn(['id_guru_input', 'id_wali_validator', 'validated_at']);
        });
    }
};
