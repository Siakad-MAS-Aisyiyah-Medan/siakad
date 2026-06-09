<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Users = autentikasi & akun saja.
 * Data PPDB (pendaftaran + tabel anak) dibuat terpisah via POST /api/ppdb/start setelah login.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('status_akun');
            }
        });

        if (Schema::hasColumn('users', 'status_akun')) {
            DB::statement("
                ALTER TABLE users
                MODIFY COLUMN status_akun
                ENUM('aktif', 'pending', 'nonaktif', 'diblokir')
                NOT NULL DEFAULT 'aktif'
            ");
        }

        if (Schema::hasColumn('users', 'role')) {
            DB::statement("
                ALTER TABLE users
                MODIFY COLUMN role
                ENUM('admin', 'operator', 'kepsek', 'guru', 'wali_kelas', 'siswa', 'calon_siswa')
                NOT NULL
            ");
        }

        // Backfill name dari username jika masih kosong
        DB::table('users')
            ->whereNull('name')
            ->orWhere('name', '')
            ->update(['name' => DB::raw('username')]);
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'last_login_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('last_login_at');
            });
        }

        if (Schema::hasColumn('users', 'status_akun')) {
            DB::statement("
                ALTER TABLE users
                MODIFY COLUMN status_akun
                ENUM('aktif', 'nonaktif')
                NOT NULL DEFAULT 'aktif'
            ");
        }
    }
};
