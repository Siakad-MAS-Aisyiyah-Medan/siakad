<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreEkskulRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_ekskul' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'id_pembina' => 'nullable|exists:users,id_user',
            'hari' => 'nullable|string|max:20',
            'jam' => 'nullable|string|max:50',
            'lokasi' => 'nullable|string|max:100',
        ];
    }
}
