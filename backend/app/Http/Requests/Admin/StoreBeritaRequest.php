<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeritaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|in:Berita,Prestasi',
            'gambar' => 'nullable|string|max:500',
            'tanggal_publikasi' => 'nullable|date',
            'is_published' => 'sometimes|boolean',
        ];
    }
}
