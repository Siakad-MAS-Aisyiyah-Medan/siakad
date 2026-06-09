<?php

namespace App\Http\Requests\PPDB;

use Illuminate\Foundation\Http\FormRequest;

class SaveFormulirRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'calon_siswa';
    }

    public function rules(): array
    {
        return [
            'nisn' => 'sometimes|string|max:20',
            'nama_lengkap' => 'sometimes|string|max:255',
            'jenis_kelamin' => 'sometimes|in:L,P',
            'tempat_lahir' => 'sometimes|string|max:100',
            'tanggal_lahir' => 'sometimes|date',
            'tgl_lahir' => 'sometimes|date',
            'agama' => 'sometimes|string|max:50',
            'alamat' => 'sometimes|string',
            'asal_sekolah' => 'sometimes|string|max:255',
            'sekolah_asal' => 'sometimes|string|max:255',
            'tahun_lulus' => 'sometimes|string|max:4',
            'nama_ayah' => 'sometimes|string|max:255',
            'pekerjaan_ayah' => 'sometimes|string|max:100',
            'nama_ibu' => 'sometimes|string|max:255',
            'pekerjaan_ibu' => 'sometimes|string|max:100',
            'no_hp_ortu' => 'sometimes|string|max:20',
            'no_telp' => 'sometimes|string|max:20',
        ];
    }
}
