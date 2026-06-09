<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id('id_pendaftaran');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            
            // A. KETERANGAN PRIBADI
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->string('agama');
            $table->string('kewarganegaraan');
            $table->integer('anak_ke');
            $table->integer('jml_saudara_kandung');
            $table->integer('jml_saudara_tiri');
            $table->text('alamat');
            $table->string('no_telp');
            $table->enum('status_yatim', ['Yatim', 'Piatu', 'Yatim Piatu', 'Tidak']);

            // B. KESEHATAN
            $table->integer('berat_badan');
            $table->integer('tinggi_badan');
            $table->string('gol_darah');
            $table->string('penyakit_diderita')->nullable();
            $table->string('cacat_badan')->nullable();

            // C. PENDIDIKAN ASAL
            $table->string('sekolah_asal');
            $table->string('no_sttb');
            $table->string('pindahan_dari')->nullable();
            $table->string('no_surat_pindah')->nullable();

            // D. KETERANGAN ORANG TUA / WALI
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('pendidikan_ayah');
            $table->string('pendidikan_ibu');
            $table->string('pekerjaan_ayah');
            $table->string('pekerjaan_ibu');
            $table->string('agama_ortu');
            $table->text('alamat_ortu');
            $table->string('nama_wali')->nullable();
            $table->string('pendidikan_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('agama_wali')->nullable();
            $table->text('alamat_wali')->nullable();

            // E. KEPRIBADIAN
            $table->string('hobi');
            $table->string('cita_cita');

            // F. UPLOAD DOKUMEN (Path File PDF)
            $table->string('file_ijazah')->nullable();
            $table->string('file_stk')->nullable();
            $table->string('file_pas_photo')->nullable();
            $table->string('file_nisn')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('file_ktp_ortua')->nullable();

            // STATUS PENDAFTARAN
            $table->enum('status_kelulusan', ['Pending', 'Lulus', 'Tidak Lulus'])->default('Pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
