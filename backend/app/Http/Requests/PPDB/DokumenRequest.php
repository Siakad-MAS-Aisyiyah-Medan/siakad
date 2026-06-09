<?php

namespace App\Http\Requests\PPDB;

use Illuminate\Foundation\Http\FormRequest;

class DokumenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'calon_siswa';
    }

    public function rules(): array
    {
        return [
            'foto_copy_ijazah' => 'nullable|string|max:500',
            'stk_asli' => 'nullable|string|max:500',
            'pas_foto' => 'nullable|string|max:500',
            'nisn_dokumen' => 'nullable|string|max:500',
            'fc_kartu_keluarga' => 'nullable|string|max:500',
            'fc_ktp_orang_tua' => 'nullable|string|max:500',
            'catatan_tambahan' => 'nullable|string',
        ];
    }
}
