<?php

namespace App\Http\Requests\PPDB;

use Illuminate\Foundation\Http\FormRequest;

class KepribadianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'calon_siswa';
    }

    public function rules(): array
    {
        return [
            'hobi' => 'nullable|string|max:255',
            'cita_cita' => 'nullable|string|max:255',
        ];
    }
}
