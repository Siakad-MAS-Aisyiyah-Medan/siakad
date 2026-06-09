<?php

namespace App\Http\Requests\Siswa;

use Illuminate\Foundation\Http\FormRequest;

class SiswaFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'siswa';
    }

    public function rules(): array
    {
        return [
            'tahun_ajaran' => 'nullable|string|max:20',
            'semester' => 'nullable|in:Ganjil,Genap',
            'tanggal_dari' => 'nullable|date',
            'tanggal_sampai' => 'nullable|date|after_or_equal:tanggal_dari',
            'id_mapel' => 'nullable|exists:mata_pelajaran,id_mapel',
        ];
    }
}
