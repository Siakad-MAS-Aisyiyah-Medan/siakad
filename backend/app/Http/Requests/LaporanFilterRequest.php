<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LaporanFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $jenis = $this->query('jenis', $this->input('jenis'));

        $rules = [
            'jenis' => ['required', Rule::in(config('laporan.jenis', []))],
            'per_page' => 'nullable|integer|min:1|max:'.config('laporan.per_page_max', 100),
            'page' => 'nullable|integer|min:1',
            'tahun_ajaran' => 'nullable|string|max:20',
            'semester' => 'nullable|in:Ganjil,Genap',
            'id_kelas' => 'nullable|exists:kelas,id_kelas',
            'id_mapel' => 'nullable|exists:mata_pelajaran,id_mapel',
            'tanggal_dari' => 'nullable|date',
            'tanggal_sampai' => 'nullable|date|after_or_equal:tanggal_dari',
            'bulan' => ['nullable', 'regex:/^\d{4}-\d{2}$/'],
            'role' => 'nullable|in:guru,wali_kelas,siswa,calon_siswa',
            'status' => 'nullable|string|max:30',
            'search' => 'nullable|string|max:100',
            'id_user_guru' => 'nullable|exists:users,id_user',
            'validated_by_wali' => 'nullable|boolean',
        ];

        if (in_array($jenis, ['absensi_siswa', 'absensi_guru', 'nilai', 'jadwal'], true)) {
            $rules['tahun_ajaran'] = 'required_without_all:tanggal_dari,bulan|nullable|string|max:20';
            $rules['semester'] = 'required_without_all:tanggal_dari,bulan|nullable|in:Ganjil,Genap';
        }

        if ($jenis === 'ppdb') {
            $rules['status'] = 'nullable|in:draft,diajukan,revisi,terverifikasi,diterima,ditolak,daftar_ulang,menjadi_murid';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'jenis.required' => 'Jenis laporan wajib dipilih.',
            'tahun_ajaran.required_without_all' => 'Tahun ajaran wajib diisi (atau gunakan rentang tanggal / bulan).',
            'semester.required_without_all' => 'Semester wajib diisi (atau gunakan rentang tanggal / bulan).',
        ];
    }
}
