<?php

namespace App\Http\Requests\Admin;

use App\Rules\GuruPengampuUser;
use Illuminate\Foundation\Http\FormRequest;

class StoreJadwalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'id_mapel' => 'required|exists:mata_pelajaran,id_mapel',
            'id_guru' => ['required', 'integer', 'exists:users,id_user', new GuruPengampuUser()],
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'id_waktu' => 'required|exists:waktu_pelajaran,id_waktu',
            'ruangan' => 'nullable|string|max:50',
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap',
        ];
    }
}
