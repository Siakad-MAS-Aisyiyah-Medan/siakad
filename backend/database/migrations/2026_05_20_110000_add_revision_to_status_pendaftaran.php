<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pendaftaran', 'status_pendaftaran')) {
            return;
        }

        DB::statement("
            ALTER TABLE pendaftaran
            MODIFY status_pendaftaran ENUM(
                'draft', 'revision', 'submitted', 'verified', 'accepted', 'rejected'
            ) NOT NULL DEFAULT 'draft'
        ");

        DB::table('pendaftaran')
            ->where('ppdb_status', 'revisi')
            ->update(['status_pendaftaran' => 'revision']);
    }

    public function down(): void
    {
        if (!Schema::hasColumn('pendaftaran', 'status_pendaftaran')) {
            return;
        }

        DB::table('pendaftaran')
            ->where('status_pendaftaran', 'revision')
            ->update(['status_pendaftaran' => 'draft']);

        DB::statement("
            ALTER TABLE pendaftaran
            MODIFY status_pendaftaran ENUM(
                'draft', 'submitted', 'verified', 'accepted', 'rejected'
            ) NOT NULL DEFAULT 'draft'
        ");
    }
};
