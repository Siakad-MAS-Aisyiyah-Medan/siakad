<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->enum('ppdb_status', [
                'draft',
                'submitted',
                'under_review',
                'accepted',
                'rejected',
                'enrolled',
            ])->default('draft')->after('id_user');
            $table->text('catatan_admin')->nullable()->after('ppdb_status');
        });

        foreach (DB::table('pendaftaran')->orderBy('id_pendaftaran')->get() as $row) {
            $status = match ($row->status_kelulusan ?? 'Pending') {
                'Lulus' => 'accepted',
                'Tidak Lulus' => 'rejected',
                default => 'draft',
            };
            DB::table('pendaftaran')->where('id_pendaftaran', $row->id_pendaftaran)->update([
                'ppdb_status' => $status,
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn(['ppdb_status', 'catatan_admin']);
        });
    }
};
