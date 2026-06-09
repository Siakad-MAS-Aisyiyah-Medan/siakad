<?php

namespace App\Http\Requests\Wali;

use Illuminate\Foundation\Http\FormRequest;

class ValidateNilaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'semester' => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => 'required|string|max:20',
            'id_nilai' => 'nullable|array',
            'id_nilai.*' => 'integer|exists:nilai,id_nilai',
        ];
    }
}
