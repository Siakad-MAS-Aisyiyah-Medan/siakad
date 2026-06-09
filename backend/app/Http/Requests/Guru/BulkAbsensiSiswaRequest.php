<?php

namespace App\Http\Requests\Guru;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkAbsensiSiswaRequest extends FormRequest
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
            'meta.tanggal' => 'required|date',
            'meta.jam_mulai' => 'required|date_format:H:i',
            'meta.jam_selesai' => 'required|date_format:H:i|after:meta.jam_mulai',
            'meta.tahun_ajaran' => 'required|string|max:20',
            'meta.semester' => 'required|in:Ganjil,Genap',
            'meta.id_jadwal' => 'nullable|exists:jadwal_pelajaran,id_jadwal',
            'items' => 'required|array|min:1',
            'items.*.id_user_siswa' => 'required|exists:users,id_user',
            'items.*.status' => ['required', Rule::in(['H', 'A', 'I', 'S', 'T'])],
            'items.*.keterangan' => 'nullable|string|max:255',
        ];
    }
}
