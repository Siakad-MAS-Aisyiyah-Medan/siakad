<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const MAP = [
        'foto' => 'pas_foto',
        'rapor' => 'stk',
        'akta_kelahiran' => 'nisn',
    ];

    public function up(): void
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('berkas_pendaftarans')) {
            return;
        }

        foreach (self::MAP as $from => $to) {
            DB::table('berkas_pendaftarans')
                ->where('jenis_berkas', $from)
                ->update(['jenis_berkas' => $to]);
        }
    }

    public function down(): void
    {
        // tidak mengembalikan jenis lama
    }
};
