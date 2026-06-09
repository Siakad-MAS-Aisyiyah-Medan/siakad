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
        // Table Admin
        Schema::create('admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->string('nip')->unique();
            $table->string('nama_admin');
            $table->string('no_hp');
            $table->timestamps();
        });

        // Table Kepala Sekolah
        Schema::create('kepala_sekolah', function (Blueprint $table) {
            $table->id('id_kepsek');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->string('nip')->unique();
            $table->string('nama_kepsek');
            $table->string('no_hp');
            $table->timestamps();
        });

        // Table Guru
        Schema::create('guru', function (Blueprint $table) {
            $table->id('id_guru');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->string('nip_nuptk')->unique();
            $table->string('nama_guru');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('agama');
            $table->text('alamat');
            $table->string('no_hp');
            $table->timestamps();
        });

        // Table Siswa
        Schema::create('siswa', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->string('nisn')->unique();
            $table->string('nis')->unique();
            $table->string('nama_siswa');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('agama');
            $table->text('alamat');
            $table->string('nama_wali');
            $table->string('no_hp_wali');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
        Schema::dropIfExists('guru');
        Schema::dropIfExists('kepala_sekolah');
        Schema::dropIfExists('admin');
    }
};
