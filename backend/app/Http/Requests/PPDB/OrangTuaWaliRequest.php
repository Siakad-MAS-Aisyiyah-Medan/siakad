<?php

namespace App\Http\Requests\PPDB;

use Illuminate\Foundation\Http\FormRequest;

class OrangTuaWaliRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'calon_siswa';
    }

    public function rules(): array
    {
        return [
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pendidikan_ayah' => 'nullable|string|max:100',
            'pendidikan_ibu' => 'nullable|string|max:100',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'agama_ortu' => 'nullable|string|max:50',
            'alamat_ortu' => 'nullable|string',
            'no_hp_ortu' => 'nullable|string|max:20',
            'nama_wali' => 'nullable|string|max:255',
            'pendidikan_wali' => 'nullable|string|max:100',
            'pekerjaan_wali' => 'nullable|string|max:100',
            'agama_wali' => 'nullable|string|max:50',
            'alamat_wali' => 'nullable|string',
        ];
    }
}
