<?php

namespace App\Http\Requests\CalonSiswa;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePendaftaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'calon_siswa';
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => 'sometimes|string|max:255',
            'tempat_lahir' => 'sometimes|string|max:100',
            'tgl_lahir' => 'sometimes|date',
            'agama' => 'sometimes|string|max:50',
            'kewarganegaraan' => 'sometimes|string|max:50',
            'anak_ke' => 'sometimes|integer|min:1',
            'jml_saudara_kandung' => 'sometimes|integer|min:0',
            'jml_saudara_tiri' => 'sometimes|integer|min:0',
            'alamat' => 'sometimes|string',
            'no_telp' => 'sometimes|string|max:20',
            'status_yatim' => 'sometimes|in:Yatim,Piatu,Yatim Piatu,Tidak',
            'berat_badan' => 'sometimes|integer|min:1',
            'tinggi_badan' => 'sometimes|integer|min:1',
            'gol_darah' => 'sometimes|string|max:5',
            'penyakit_diderita' => 'nullable|string|max:255',
            'cacat_badan' => 'nullable|string|max:255',
            'sekolah_asal' => 'sometimes|string|max:255',
            'no_sttb' => 'sometimes|string|max:100',
            'pindahan_dari' => 'nullable|string|max:255',
            'no_surat_pindah' => 'nullable|string|max:100',
            'nama_ayah' => 'sometimes|string|max:255',
            'nama_ibu' => 'sometimes|string|max:255',
            'pendidikan_ayah' => 'sometimes|string|max:100',
            'pendidikan_ibu' => 'sometimes|string|max:100',
            'pekerjaan_ayah' => 'sometimes|string|max:100',
            'pekerjaan_ibu' => 'sometimes|string|max:100',
            'agama_ortu' => 'sometimes|string|max:50',
            'alamat_ortu' => 'sometimes|string',
            'nama_wali' => 'nullable|string|max:255',
            'pendidikan_wali' => 'nullable|string|max:100',
            'pekerjaan_wali' => 'nullable|string|max:100',
            'agama_wali' => 'nullable|string|max:50',
            'alamat_wali' => 'nullable|string',
            'hobi' => 'sometimes|string|max:255',
            'cita_cita' => 'sometimes|string|max:255',
            'file_ijazah' => 'nullable|file|mimes:pdf|max:5120',
            'file_stk' => 'nullable|file|mimes:pdf|max:5120',
            'file_pas_photo' => 'nullable|file|mimes:pdf|max:5120',
            'file_nisn' => 'nullable|file|mimes:pdf|max:5120',
            'file_kk' => 'nullable|file|mimes:pdf|max:5120',
            'file_ktp_ortua' => 'nullable|file|mimes:pdf|max:5120',
        ];
    }

    /** Whitelist field yang boleh disimpan calon siswa */
    public function safeFields(): array
    {
        return $this->only(array_keys($this->rules()));
    }
}
