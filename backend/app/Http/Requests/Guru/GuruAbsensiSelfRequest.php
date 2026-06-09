<?php

namespace App\Http\Requests\Guru;

use Illuminate\Foundation\Http\FormRequest;

class GuruAbsensiSelfRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()?->role, ['guru', 'wali_kelas'], true);
    }

    public function rules(): array
    {
        return [
            'keterangan' => 'nullable|string|max:500',
        ];
    }
}
