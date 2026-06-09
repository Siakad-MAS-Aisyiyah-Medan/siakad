<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable()->after('id_user');
            }
            if (!Schema::hasColumn('users', 'status_akun')) {
                $table->enum('status_akun', ['aktif', 'nonaktif'])->default('aktif')->after('status_aktif');
            }
        });

        foreach (DB::table('users')->get() as $user) {
            DB::table('users')->where('id_user', $user->id_user)->update([
                'status_akun' => ($user->status_aktif ?? true) ? 'aktif' : 'nonaktif',
            ]);
        }

        Schema::table('pendaftaran', function (Blueprint $table) {
            if (!Schema::hasColumn('pendaftaran', 'nomor_pendaftaran')) {
                $table->string('nomor_pendaftaran', 30)->nullable()->unique()->after('id_user');
            }
            if (!Schema::hasColumn('pendaftaran', 'tahun_pelajaran')) {
                $table->string('tahun_pelajaran', 20)->default('2026/2027')->after('nomor_pendaftaran');
            }
            if (!Schema::hasColumn('pendaftaran', 'status_pendaftaran')) {
                $table->enum('status_pendaftaran', [
                    'draft', 'submitted', 'verified', 'accepted', 'rejected',
                ])->default('draft')->after('tahun_pelajaran');
            }
            if (!Schema::hasColumn('pendaftaran', 'current_step')) {
                $table->string('current_step', 50)->nullable()->after('status_pendaftaran');
            }
        });

        foreach (DB::table('pendaftaran')->get() as $row) {
            $nomor = $row->nomor_pendaftaran ?? $row->no_registrasi ?? null;
            $status = match ($row->ppdb_status ?? 'draft') {
                'diajukan' => 'submitted',
                'terverifikasi' => 'verified',
                'diterima', 'daftar_ulang' => 'accepted',
                'ditolak' => 'rejected',
                default => 'draft',
            };
            DB::table('pendaftaran')->where('id_pendaftaran', $row->id_pendaftaran)->update([
                'nomor_pendaftaran' => $nomor,
                'status_pendaftaran' => $status,
            ]);
        }

        if (!Schema::hasTable('pendaftaran_keterangan_pribadi')) {
            Schema::create('pendaftaran_keterangan_pribadi', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pendaftaran_id')
                    ->constrained('pendaftaran', 'id_pendaftaran')
                    ->cascadeOnDelete();
                $table->string('nama_lengkap');
                $table->string('nisn', 20)->nullable();
                $table->string('tempat_lahir')->nullable();
                $table->date('tgl_lahir')->nullable();
                $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
                $table->string('agama')->nullable();
                $table->string('kewarganegaraan')->nullable();
                $table->unsignedTinyInteger('anak_ke')->nullable();
                $table->unsignedTinyInteger('jml_saudara_kandung')->nullable();
                $table->unsignedTinyInteger('jml_saudara_tiri')->nullable();
                $table->text('alamat')->nullable();
                $table->string('no_telp', 20)->nullable();
                $table->enum('status_yatim', ['Yatim', 'Piatu', 'Yatim Piatu', 'Tidak'])->nullable();
                $table->timestamps();
                $table->unique('pendaftaran_id');
            });
        }

        if (!Schema::hasTable('pendaftaran_kesehatan')) {
            Schema::create('pendaftaran_kesehatan', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pendaftaran_id')
                    ->constrained('pendaftaran', 'id_pendaftaran')
                    ->cascadeOnDelete();
                $table->unsignedSmallInteger('berat_badan')->nullable();
                $table->unsignedSmallInteger('tinggi_badan')->nullable();
                $table->string('gol_darah', 5)->nullable();
                $table->text('penyakit_diderita')->nullable();
                $table->text('cacat_badan')->nullable();
                $table->timestamps();
                $table->unique('pendaftaran_id');
            });
        }

        if (!Schema::hasTable('pendaftaran_pendidikan_asal')) {
            Schema::create('pendaftaran_pendidikan_asal', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pendaftaran_id')
                    ->constrained('pendaftaran', 'id_pendaftaran')
                    ->cascadeOnDelete();
                $table->string('sekolah_asal')->nullable();
                $table->string('no_sttb')->nullable();
                $table->string('pindahan_dari')->nullable();
                $table->string('no_surat_pindah')->nullable();
                $table->timestamps();
                $table->unique('pendaftaran_id');
            });
        }

        if (!Schema::hasTable('pendaftaran_orang_tua_wali')) {
            Schema::create('pendaftaran_orang_tua_wali', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pendaftaran_id')
                    ->constrained('pendaftaran', 'id_pendaftaran')
                    ->cascadeOnDelete();
                $table->string('nama_ayah')->nullable();
                $table->string('nama_ibu')->nullable();
                $table->string('pendidikan_ayah')->nullable();
                $table->string('pendidikan_ibu')->nullable();
                $table->string('pekerjaan_ayah')->nullable();
                $table->string('pekerjaan_ibu')->nullable();
                $table->string('agama_ortu')->nullable();
                $table->text('alamat_ortu')->nullable();
                $table->string('no_hp_ortu', 20)->nullable();
                $table->string('nama_wali')->nullable();
                $table->string('pendidikan_wali')->nullable();
                $table->string('pekerjaan_wali')->nullable();
                $table->string('agama_wali')->nullable();
                $table->text('alamat_wali')->nullable();
                $table->timestamps();
                $table->unique('pendaftaran_id');
            });
        }

        if (!Schema::hasTable('pendaftaran_kepribadian')) {
            Schema::create('pendaftaran_kepribadian', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pendaftaran_id')
                    ->constrained('pendaftaran', 'id_pendaftaran')
                    ->cascadeOnDelete();
                $table->string('hobi')->nullable();
                $table->string('cita_cita')->nullable();
                $table->timestamps();
                $table->unique('pendaftaran_id');
            });
        }

        if (!Schema::hasTable('pendaftaran_dokumen')) {
            Schema::create('pendaftaran_dokumen', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pendaftaran_id')
                    ->constrained('pendaftaran', 'id_pendaftaran')
                    ->cascadeOnDelete();
                $table->string('foto_copy_ijazah')->nullable();
                $table->string('stk_asli')->nullable();
                $table->string('pas_foto')->nullable();
                $table->string('nisn_dokumen')->nullable();
                $table->string('fc_kartu_keluarga')->nullable();
                $table->string('fc_ktp_orang_tua')->nullable();
                $table->text('catatan_tambahan')->nullable();
                $table->timestamps();
                $table->unique('pendaftaran_id');
            });
        }

        $this->migrateFlatDataToChildTables();
    }

    protected function migrateFlatDataToChildTables(): void
    {
        foreach (DB::table('pendaftaran')->get() as $row) {
            $id = $row->id_pendaftaran;

            if (!DB::table('pendaftaran_keterangan_pribadi')->where('pendaftaran_id', $id)->exists()) {
                DB::table('pendaftaran_keterangan_pribadi')->insert([
                    'pendaftaran_id' => $id,
                    'nama_lengkap' => $row->nama_lengkap ?: '—',
                    'nisn' => $row->nisn,
                    'tempat_lahir' => $row->tempat_lahir,
                    'tgl_lahir' => $row->tgl_lahir,
                    'jenis_kelamin' => $row->jenis_kelamin,
                    'agama' => $row->agama,
                    'kewarganegaraan' => $row->kewarganegaraan,
                    'anak_ke' => $row->anak_ke,
                    'jml_saudara_kandung' => $row->jml_saudara_kandung,
                    'jml_saudara_tiri' => $row->jml_saudara_tiri,
                    'alamat' => $row->alamat,
                    'no_telp' => $row->no_telp,
                    'status_yatim' => $row->status_yatim,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if (!DB::table('pendaftaran_kesehatan')->where('pendaftaran_id', $id)->exists()) {
                DB::table('pendaftaran_kesehatan')->insert([
                    'pendaftaran_id' => $id,
                    'berat_badan' => $row->berat_badan ?: null,
                    'tinggi_badan' => $row->tinggi_badan ?: null,
                    'gol_darah' => $row->gol_darah,
                    'penyakit_diderita' => $row->penyakit_diderita,
                    'cacat_badan' => $row->cacat_badan,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if (!DB::table('pendaftaran_pendidikan_asal')->where('pendaftaran_id', $id)->exists()) {
                DB::table('pendaftaran_pendidikan_asal')->insert([
                    'pendaftaran_id' => $id,
                    'sekolah_asal' => $row->sekolah_asal,
                    'no_sttb' => $row->no_sttb,
                    'pindahan_dari' => $row->pindahan_dari,
                    'no_surat_pindah' => $row->no_surat_pindah,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if (!DB::table('pendaftaran_orang_tua_wali')->where('pendaftaran_id', $id)->exists()) {
                DB::table('pendaftaran_orang_tua_wali')->insert([
                    'pendaftaran_id' => $id,
                    'nama_ayah' => $row->nama_ayah,
                    'nama_ibu' => $row->nama_ibu,
                    'pendidikan_ayah' => $row->pendidikan_ayah,
                    'pendidikan_ibu' => $row->pendidikan_ibu,
                    'pekerjaan_ayah' => $row->pekerjaan_ayah,
                    'pekerjaan_ibu' => $row->pekerjaan_ibu,
                    'agama_ortu' => $row->agama_ortu,
                    'alamat_ortu' => $row->alamat_ortu,
                    'no_hp_ortu' => $row->no_hp_ortu ?? null,
                    'nama_wali' => $row->nama_wali,
                    'pendidikan_wali' => $row->pendidikan_wali,
                    'pekerjaan_wali' => $row->pekerjaan_wali,
                    'agama_wali' => $row->agama_wali,
                    'alamat_wali' => $row->alamat_wali,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if (!DB::table('pendaftaran_kepribadian')->where('pendaftaran_id', $id)->exists()) {
                DB::table('pendaftaran_kepribadian')->insert([
                    'pendaftaran_id' => $id,
                    'hobi' => $row->hobi,
                    'cita_cita' => $row->cita_cita,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if (!DB::table('pendaftaran_dokumen')->where('pendaftaran_id', $id)->exists()) {
                DB::table('pendaftaran_dokumen')->insert([
                    'pendaftaran_id' => $id,
                    'foto_copy_ijazah' => $row->file_ijazah,
                    'stk_asli' => $row->file_stk,
                    'pas_foto' => $row->file_pas_photo,
                    'nisn_dokumen' => $row->file_nisn,
                    'fc_kartu_keluarga' => $row->file_kk,
                    'fc_ktp_orang_tua' => $row->file_ktp_ortua,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_dokumen');
        Schema::dropIfExists('pendaftaran_kepribadian');
        Schema::dropIfExists('pendaftaran_orang_tua_wali');
        Schema::dropIfExists('pendaftaran_pendidikan_asal');
        Schema::dropIfExists('pendaftaran_kesehatan');
        Schema::dropIfExists('pendaftaran_keterangan_pribadi');

        Schema::table('pendaftaran', function (Blueprint $table) {
            foreach (['nomor_pendaftaran', 'tahun_pelajaran', 'status_pendaftaran', 'current_step'] as $col) {
                if (Schema::hasColumn('pendaftaran', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('users', function (Blueprint $table) {
            foreach (['name', 'status_akun'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
