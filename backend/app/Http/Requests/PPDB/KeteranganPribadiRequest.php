<?php

namespace App\Http\Requests\PPDB;

use Illuminate\Foundation\Http\FormRequest;

class KeteranganPribadiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'calon_siswa';
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'nullable|string|max:20',
            'tempat_lahir' => 'nullable|string|max:255',
            'tgl_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:100',
            'anak_ke' => 'nullable|integer|min:1',
            'jml_saudara_kandung' => 'nullable|integer|min:0',
            'jml_saudara_tiri' => 'nullable|integer|min:0',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:20',
            'status_yatim' => 'nullable|in:Yatim,Piatu,Yatim Piatu,Tidak',
        ];
    }
}
