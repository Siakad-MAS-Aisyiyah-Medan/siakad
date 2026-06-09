<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $additions = [
            'nisn' => fn (Blueprint $table) => $table->string('nisn', 20)->nullable()->after('id_user'),
            'tempat_lahir' => fn (Blueprint $table) => $table->string('tempat_lahir')->nullable(),
            'tgl_lahir' => fn (Blueprint $table) => $table->date('tgl_lahir')->nullable(),
            'jenis_kelamin' => fn (Blueprint $table) => $table->enum('jenis_kelamin', ['L', 'P'])->nullable(),
            'agama' => fn (Blueprint $table) => $table->string('agama')->nullable(),
            'kewarganegaraan' => fn (Blueprint $table) => $table->string('kewarganegaraan')->default('Indonesia'),
            'anak_ke' => fn (Blueprint $table) => $table->unsignedTinyInteger('anak_ke')->nullable(),
            'jml_saudara_kandung' => fn (Blueprint $table) => $table->unsignedTinyInteger('jml_saudara_kandung')->default(0),
            'jml_saudara_tiri' => fn (Blueprint $table) => $table->unsignedTinyInteger('jml_saudara_tiri')->default(0),
            'alamat' => fn (Blueprint $table) => $table->text('alamat')->nullable(),
            'no_telp' => fn (Blueprint $table) => $table->string('no_telp', 20)->nullable(),
            'status_yatim' => fn (Blueprint $table) => $table->enum('status_yatim', ['Yatim', 'Piatu', 'Yatim Piatu', 'Tidak'])->default('Tidak'),
            'berat_badan' => fn (Blueprint $table) => $table->unsignedSmallInteger('berat_badan')->nullable(),
            'tinggi_badan' => fn (Blueprint $table) => $table->unsignedSmallInteger('tinggi_badan')->nullable(),
            'gol_darah' => fn (Blueprint $table) => $table->string('gol_darah', 5)->nullable(),
            'sekolah_asal' => fn (Blueprint $table) => $table->string('sekolah_asal')->nullable(),
            'no_sttb' => fn (Blueprint $table) => $table->string('no_sttb')->nullable(),
            'nama_ayah' => fn (Blueprint $table) => $table->string('nama_ayah')->nullable(),
            'nama_ibu' => fn (Blueprint $table) => $table->string('nama_ibu')->nullable(),
            'pendidikan_ayah' => fn (Blueprint $table) => $table->string('pendidikan_ayah')->nullable(),
            'pendidikan_ibu' => fn (Blueprint $table) => $table->string('pendidikan_ibu')->nullable(),
            'pekerjaan_ayah' => fn (Blueprint $table) => $table->string('pekerjaan_ayah')->nullable(),
            'pekerjaan_ibu' => fn (Blueprint $table) => $table->string('pekerjaan_ibu')->nullable(),
            'agama_ortu' => fn (Blueprint $table) => $table->string('agama_ortu')->nullable(),
            'alamat_ortu' => fn (Blueprint $table) => $table->text('alamat_ortu')->nullable(),
            'no_hp_ortu' => fn (Blueprint $table) => $table->string('no_hp_ortu', 20)->nullable(),
            'hobi' => fn (Blueprint $table) => $table->string('hobi')->nullable(),
            'cita_cita' => fn (Blueprint $table) => $table->string('cita_cita')->nullable(),
            'status_kelulusan' => fn (Blueprint $table) => $table->enum('status_kelulusan', ['Pending', 'Lulus', 'Tidak Lulus'])->default('Pending'),
            'no_registrasi' => fn (Blueprint $table) => $table->string('no_registrasi', 30)->nullable()->unique(),
            'tahun_lulus' => fn (Blueprint $table) => $table->string('tahun_lulus', 4)->nullable(),
            'ppdb_status' => fn (Blueprint $table) => $table->string('ppdb_status', 30)->default('draft'),
            'submitted_at' => fn (Blueprint $table) => $table->timestamp('submitted_at')->nullable(),
            'verified_at' => fn (Blueprint $table) => $table->timestamp('verified_at')->nullable(),
            'accepted_at' => fn (Blueprint $table) => $table->timestamp('accepted_at')->nullable(),
        ];

        Schema::table('pendaftaran', function (Blueprint $table) use ($additions) {
            foreach ($additions as $column => $definition) {
                if (!Schema::hasColumn('pendaftaran', $column)) {
                    $definition($table);
                }
            }
        });
    }

    public function down(): void
    {
        // Kolom inti tidak di-drop agar data registrasi PPDB tetap aman.
    }
};
