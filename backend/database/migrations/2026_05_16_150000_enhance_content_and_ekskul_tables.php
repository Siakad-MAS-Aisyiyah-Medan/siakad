<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengumumen', function (Blueprint $table) {
            $table->string('judul')->after('id');
            $table->text('isi')->after('judul');
            $table->date('tanggal_publikasi')->nullable()->after('isi');
            $table->boolean('is_published')->default(true)->after('tanggal_publikasi');
        });

        Schema::table('beritas', function (Blueprint $table) {
            $table->string('judul')->after('id');
            $table->text('isi')->after('judul');
            $table->enum('kategori', ['Berita', 'Prestasi'])->default('Berita')->after('isi');
            $table->string('gambar')->nullable()->after('kategori');
            $table->date('tanggal_publikasi')->nullable()->after('gambar');
            $table->boolean('is_published')->default(true)->after('tanggal_publikasi');
        });

        Schema::create('ekstrakurikuler', function (Blueprint $table) {
            $table->id('id_ekskul');
            $table->string('nama_ekskul');
            $table->text('deskripsi')->nullable();
            $table->foreignId('id_pembina')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->string('hari')->nullable();
            $table->string('jam')->nullable();
            $table->string('lokasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ekstrakurikuler');

        Schema::table('beritas', function (Blueprint $table) {
            $table->dropColumn(['judul', 'isi', 'kategori', 'gambar', 'tanggal_publikasi', 'is_published']);
        });

        Schema::table('pengumumen', function (Blueprint $table) {
            $table->dropColumn(['judul', 'isi', 'tanggal_publikasi', 'is_published']);
        });
    }
};
