<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hapus data lama agar tidak error foreign key saat update
        Schema::disableForeignKeyConstraints();
        DB::table('absensi')->truncate();
        DB::table('jadwal_pelajaran')->truncate();
        Schema::enableForeignKeyConstraints();

        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            $table->dropColumn(['jam_mulai', 'jam_selesai']);
            $table->unsignedBigInteger('id_waktu')->after('hari');
            
            $table->foreign('id_waktu')->references('id_waktu')->on('waktu_pelajaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            $table->dropForeign(['id_waktu']);
            $table->dropColumn('id_waktu');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
        });
    }
};
