<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const STATUS_MAP = [
        'draft' => 'draft',
        'submitted' => 'diajukan',
        'under_review' => 'terverifikasi',
        'accepted' => 'diterima',
        'rejected' => 'ditolak',
        'enrolled' => 'menjadi_murid',
    ];

    public function up(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->string('no_registrasi', 30)->nullable()->unique()->after('id_user');
            $table->string('nisn', 20)->nullable()->after('no_registrasi');
            $table->string('tahun_lulus', 4)->nullable()->after('sekolah_asal');
            $table->string('no_hp_ortu', 20)->nullable()->after('alamat_ortu');
            $table->timestamp('submitted_at')->nullable()->after('catatan_admin');
            $table->timestamp('verified_at')->nullable()->after('submitted_at');
            $table->timestamp('accepted_at')->nullable()->after('verified_at');
        });

        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->string('ppdb_status', 30)->default('draft')->change();
        });

        foreach (DB::table('pendaftaran')->get() as $row) {
            $newStatus = self::STATUS_MAP[$row->ppdb_status] ?? 'draft';
            $nisn = DB::table('users')->where('id_user', $row->id_user)->value('username');
            DB::table('pendaftaran')->where('id_pendaftaran', $row->id_pendaftaran)->update([
                'ppdb_status' => $newStatus,
                'nisn' => $nisn,
            ]);
        }

        Schema::create('berkas_pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')
                ->constrained('pendaftaran', 'id_pendaftaran')
                ->cascadeOnDelete();
            $table->string('jenis_berkas', 50);
            $table->string('file_path');
            $table->enum('status_verifikasi', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->unique(['pendaftaran_id', 'jenis_berkas']);
        });

        $fileMap = [
            'file_kk' => 'kartu_keluarga',
            'file_ijazah' => 'ijazah_atau_skl',
            'file_pas_photo' => 'foto',
            'file_stk' => 'rapor',
            'file_nisn' => 'rapor',
        ];

        foreach (DB::table('pendaftaran')->get() as $row) {
            foreach ($fileMap as $col => $jenis) {
                if (empty($row->{$col})) {
                    continue;
                }
                $exists = DB::table('berkas_pendaftarans')
                    ->where('pendaftaran_id', $row->id_pendaftaran)
                    ->where('jenis_berkas', $jenis)
                    ->exists();
                if ($exists) {
                    continue;
                }
                DB::table('berkas_pendaftarans')->insert([
                    'pendaftaran_id' => $row->id_pendaftaran,
                    'jenis_berkas' => $jenis,
                    'file_path' => $row->{$col},
                    'status_verifikasi' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas_pendaftarans');

        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn([
                'no_registrasi',
                'nisn',
                'tahun_lulus',
                'no_hp_ortu',
                'submitted_at',
                'verified_at',
                'accepted_at',
            ]);
        });
    }
};
