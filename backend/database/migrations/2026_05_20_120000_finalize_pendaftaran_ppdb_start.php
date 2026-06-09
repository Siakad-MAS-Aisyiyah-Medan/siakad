<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Skema pendaftaran PPDB untuk alur "Mulai Pendaftaran".
 *
 * Mapping kolom:
 * - id → id_pendaftaran
 * - user_id → id_user
 * - tahun_ajaran → tahun_pelajaran
 * - status → status_pendaftaran
 */
return new class extends Migration
{
    private const STEP_KEY_TO_INDEX = [
        'keterangan-pribadi' => '1',
        'kesehatan' => '2',
        'pendidikan-asal' => '3',
        'orang-tua-wali' => '4',
        'kepribadian' => '5',
        'dokumen' => '6',
        'review' => '7',
    ];

    public function up(): void
    {
        if (!Schema::hasTable('pendaftaran')) {
            return;
        }

        Schema::table('pendaftaran', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftaran', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable();
            }
            if (!Schema::hasColumn('pendaftaran', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('submitted_at');
            }
        });

        foreach (DB::table('pendaftaran')->get() as $row) {
            $step = $row->current_step;
            if ($step === null || $step === '') {
                DB::table('pendaftaran')->where('id_pendaftaran', $row->id_pendaftaran)->update([
                    'current_step' => '1',
                ]);
                continue;
            }

            if (isset(self::STEP_KEY_TO_INDEX[$step])) {
                DB::table('pendaftaran')->where('id_pendaftaran', $row->id_pendaftaran)->update([
                    'current_step' => self::STEP_KEY_TO_INDEX[$step],
                ]);
            }
        }
    }

    public function down(): void
    {
        // Tidak mengembalikan format current_step lama
    }
};
