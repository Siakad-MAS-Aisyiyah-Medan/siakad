<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('tgl_lahir');
        });

        Schema::table('siswa', function (Blueprint $table) {
            $table->unique('id_user');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn('jenis_kelamin');
        });

        Schema::table('siswa', function (Blueprint $table) {
            $table->dropUnique(['id_user']);
        });
    }
};
