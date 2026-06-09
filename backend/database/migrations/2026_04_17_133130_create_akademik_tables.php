<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel Kelas
        Schema::create('kelas', function (Blueprint $table) {
            $table->id('id_kelas');
            $table->string('nama_kelas'); // Contoh: VII-A
            $table->foreignId('id_wali_kelas')->nullable()->constrained('users', 'id_user')->onDelete('set null');
            $table->timestamps();
        });

        // 2. Tambahkan kolom id_kelas ke profil Siswa
        Schema::table('siswa', function (Blueprint $table) {
            $table->foreignId('id_kelas')->after('id_siswa')->nullable()->constrained('kelas', 'id_kelas')->onDelete('set null');
        });

        // 3. Tabel Mata Pelajaran
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->id('id_mapel');
            $table->string('nama_mapel');
            $table->foreignId('id_guru')->constrained('users', 'id_user')->onDelete('cascade');
            $table->timestamps();
        });

        // 4. Tabel Absensi (Harian)
        Schema::create('absensi', function (Blueprint $table) {
            $table->id('id_absensi');
            $table->foreignId('id_user_siswa')->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('id_kelas')->constrained('kelas', 'id_kelas')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['H', 'A', 'I', 'S', 'T']); // Hadir, Alpa, Izin, Sakit, Terlambat
            $table->timestamps();
        });

        // 5. Tabel Nilai
        Schema::create('nilai', function (Blueprint $table) {
            $table->id('id_nilai');
            $table->foreignId('id_user_siswa')->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('id_mapel')->constrained('mata_pelajaran', 'id_mapel')->onDelete('cascade');
            $table->integer('nilai_angka');
            $table->string('semester'); // Ganjil / Genap
            $table->string('tahun_ajaran'); // Contoh: 2026/2027
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
        Schema::dropIfExists('absensi');
        Schema::dropIfExists('mata_pelajaran');
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropForeign(['id_kelas']);
            $table->dropColumn('id_kelas');
        });
        Schema::dropIfExists('kelas');
    }
};
