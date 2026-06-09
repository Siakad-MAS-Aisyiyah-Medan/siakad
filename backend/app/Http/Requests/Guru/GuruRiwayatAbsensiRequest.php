<?php

namespace App\Http\Requests\Guru;

use Illuminate\Foundation\Http\FormRequest;

class GuruRiwayatAbsensiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()?->role, ['guru', 'wali_kelas'], true);
    }

    public function rules(): array
    {
        return [
            'tanggal_dari' => 'nullable|date',
            'tanggal_sampai' => 'nullable|date|after_or_equal:tanggal_dari',
            'semester' => 'nullable|in:Ganjil,Genap',
            'tahun_ajaran' => 'nullable|string|max:20',
        ];
    }
}
