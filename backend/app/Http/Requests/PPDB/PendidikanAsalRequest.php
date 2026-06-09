<?php

namespace App\Http\Requests\PPDB;

use Illuminate\Foundation\Http\FormRequest;

class PendidikanAsalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'calon_siswa';
    }

    public function rules(): array
    {
        return [
            'sekolah_asal' => 'nullable|string|max:255',
            'no_sttb' => 'nullable|string|max:100',
            'pindahan_dari' => 'nullable|string|max:255',
            'no_surat_pindah' => 'nullable|string|max:100',
        ];
    }
}
