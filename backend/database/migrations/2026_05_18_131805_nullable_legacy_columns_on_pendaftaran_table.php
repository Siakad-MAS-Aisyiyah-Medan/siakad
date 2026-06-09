<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom legacy di tabel pendaftaran dibuat nullable agar data formulir
     * disimpan di tabel step terpisah (pendaftaran_keterangan_pribadi, dll).
     */
    public function up(): void
    {
        if (!Schema::hasTable('pendaftaran')) {
            return;
        }

        $nullableStrings = [
            'nama_lengkap', 'tempat_lahir', 'agama', 'kewarganegaraan', 'alamat', 'no_telp',
            'gol_darah', 'sekolah_asal', 'no_sttb', 'nama_ayah', 'nama_ibu',
            'pendidikan_ayah', 'pendidikan_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu',
            'agama_ortu', 'alamat_ortu', 'hobi', 'cita_cita',
            'pindahan_dari', 'no_surat_pindah', 'nama_wali', 'pendidikan_wali',
            'pekerjaan_wali', 'agama_wali', 'alamat_wali',
        ];

        $textColumns = ['alamat', 'alamat_ortu', 'alamat_wali'];
        foreach ($nullableStrings as $column) {
            if (!Schema::hasColumn('pendaftaran', $column)) {
                continue;
            }
            $type = in_array($column, $textColumns, true) ? 'TEXT' : 'VARCHAR(255)';
            DB::statement("ALTER TABLE pendaftaran MODIFY `{$column}` {$type} NULL");
        }

        if (Schema::hasColumn('pendaftaran', 'tgl_lahir')) {
            DB::statement('ALTER TABLE pendaftaran MODIFY `tgl_lahir` DATE NULL');
        }

        foreach (['anak_ke', 'jml_saudara_kandung', 'jml_saudara_tiri', 'berat_badan', 'tinggi_badan'] as $column) {
            if (Schema::hasColumn('pendaftaran', $column)) {
                DB::statement("ALTER TABLE pendaftaran MODIFY `{$column}` INT NULL");
            }
        }

        if (Schema::hasColumn('pendaftaran', 'status_yatim')) {
            DB::statement("ALTER TABLE pendaftaran MODIFY `status_yatim` ENUM('Yatim','Piatu','Yatim Piatu','Tidak') NULL");
        }

        $indexes = collect(DB::select('SHOW INDEX FROM pendaftaran'))
            ->pluck('Key_name')
            ->unique();

        if (!$indexes->contains('pendaftaran_id_user_unique')) {
            try {
                DB::statement('ALTER TABLE pendaftaran ADD UNIQUE pendaftaran_id_user_unique (id_user)');
            } catch (\Throwable) {
                // Abaikan jika duplikat data atau index sudah ada dengan nama lain.
            }
        }
    }

    public function down(): void
    {
        // Tidak mengembalikan NOT NULL agar data existing tetap aman.
    }
};
