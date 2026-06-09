<?php

namespace App\Http\Requests\Guru;

use Illuminate\Foundation\Http\FormRequest;

class BulkNilaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'meta' => 'required|array',
            'meta.id_kelas' => 'required|exists:kelas,id_kelas',
            'meta.id_mapel' => 'required|exists:mata_pelajaran,id_mapel',
            'meta.tahun_ajaran' => 'required|string|max:20',
            'meta.semester' => 'required|in:Ganjil,Genap',
            'items' => 'required|array|min:1',
            'items.*.id_user_siswa' => 'required|exists:users,id_user',
            'items.*.nilai_tugas' => 'required|integer|min:0|max:100',
            'items.*.nilai_uts' => 'required|integer|min:0|max:100',
            'items.*.nilai_uas' => 'required|integer|min:0|max:100',
            'items.*.nilai_praktik' => 'nullable|integer|min:0|max:100',
            'items.*.nilai_sikap' => 'nullable|integer|min:0|max:100',
        ];
    }
}
