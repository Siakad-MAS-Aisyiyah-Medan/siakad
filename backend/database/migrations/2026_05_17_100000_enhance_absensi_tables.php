<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->foreignId('id_mapel')->nullable()->after('id_kelas')->constrained('mata_pelajaran', 'id_mapel')->cascadeOnDelete();
            $table->foreignId('id_jadwal')->nullable()->after('id_mapel')->constrained('jadwal_pelajaran', 'id_jadwal')->nullOnDelete();
            $table->time('jam_mulai')->nullable()->after('tanggal');
            $table->time('jam_selesai')->nullable()->after('jam_mulai');
            $table->foreignId('id_guru_pencatat')->nullable()->after('status')->constrained('users', 'id_user')->nullOnDelete();
            $table->string('tahun_ajaran', 20)->nullable()->after('id_guru_pencatat');
            $table->enum('semester', ['Ganjil', 'Genap'])->nullable()->after('tahun_ajaran');
            $table->text('keterangan')->nullable()->after('semester');
        });

        Schema::table('absensi', function (Blueprint $table) {
            $table->unique(
                ['id_user_siswa', 'id_mapel', 'tanggal', 'jam_mulai'],
                'absensi_siswa_unique'
            );
        });

        Schema::create('absensi_guru', function (Blueprint $table) {
            $table->id('id_absensi_guru');
            $table->foreignId('id_user_guru')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->enum('status', ['H', 'A', 'I', 'S', 'T'])->default('H');
            $table->text('keterangan')->nullable();
            $table->string('tahun_ajaran', 20)->nullable();
            $table->enum('semester', ['Ganjil', 'Genap'])->nullable();
            $table->timestamps();

            $table->unique(['id_user_guru', 'tanggal'], 'absensi_guru_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi_guru');

        Schema::table('absensi', function (Blueprint $table) {
            $table->dropUnique('absensi_siswa_unique');
            $table->dropConstrainedForeignId('id_mapel');
            $table->dropConstrainedForeignId('id_jadwal');
            $table->dropConstrainedForeignId('id_guru_pencatat');
            $table->dropColumn(['jam_mulai', 'jam_selesai', 'tahun_ajaran', 'semester', 'keterangan']);
        });
    }
};
