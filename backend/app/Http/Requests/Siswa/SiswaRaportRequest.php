<?php

namespace App\Http\Requests\Siswa;

use Illuminate\Foundation\Http\FormRequest;

class SiswaRaportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'siswa';
    }

    public function rules(): array
    {
        return [
            'semester' => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => 'required|string|max:20',
        ];
    }
}
