<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_pelajaran', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->foreignId('id_kelas')->constrained('kelas', 'id_kelas')->cascadeOnDelete();
            $table->foreignId('id_mapel')->constrained('mata_pelajaran', 'id_mapel')->cascadeOnDelete();
            $table->foreignId('id_guru')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('ruangan')->nullable();
            $table->string('tahun_ajaran');
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->timestamps();

            $table->index(['hari', 'jam_mulai', 'jam_selesai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_pelajaran');
    }
};
