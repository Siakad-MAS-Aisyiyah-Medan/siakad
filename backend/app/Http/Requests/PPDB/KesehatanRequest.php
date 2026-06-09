<?php

namespace App\Http\Requests\PPDB;

use Illuminate\Foundation\Http\FormRequest;

class KesehatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'calon_siswa';
    }

    public function rules(): array
    {
        return [
            'berat_badan' => 'nullable|integer|min:1',
            'tinggi_badan' => 'nullable|integer|min:1',
            'gol_darah' => 'nullable|string|max:5',
            'penyakit_diderita' => 'nullable|string',
            'cacat_badan' => 'nullable|string',
        ];
    }
}
