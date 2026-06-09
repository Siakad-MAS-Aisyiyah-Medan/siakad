<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('roles')) {
            return;
        }

        DB::table('roles')
            ->where('key', 'calon_siswa')
            ->update(['redirect_path' => '/calon-murid/dashboard']);
    }

    public function down(): void
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('roles')) {
            return;
        }

        DB::table('roles')
            ->where('key', 'calon_siswa')
            ->update(['redirect_path' => '/ppdb/dashboard']);
    }
};
