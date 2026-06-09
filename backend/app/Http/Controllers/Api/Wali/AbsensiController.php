<?php

namespace App\Http\Controllers\Api\Wali;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Services\AbsensiSiswaService;
use Illuminate\Http\Request;
use InvalidArgumentException;

class AbsensiController extends Controller
{
    public function __construct(private AbsensiSiswaService $absensiSiswa)
    {
    }

    public function rekapKelas(Request $request)
    {
        $user = $request->user();
        if ($user->role !== 'wali_kelas') {
            return ApiResponse::error('Akses hanya untuk wali kelas.', 403);
        }

        $kelas = Kelas::where('id_wali_kelas', $user->id_user)->first();
        if (!$kelas) {
            return ApiResponse::error('Anda belum ditugaskan sebagai wali kelas.', 422);
        }

        $filters = array_merge(
            $request->only(['id_mapel', 'tanggal_dari', 'tanggal_sampai', 'semester', 'tahun_ajaran']),
            ['id_kelas' => $kelas->id_kelas]
        );

        $rekap = $this->absensiSiswa->rekap($filters);

        return ApiResponse::success([
            'kelas' => [
                'id_kelas' => $kelas->id_kelas,
                'nama_kelas' => $kelas->nama_kelas,
            ],
            'rekap' => $rekap,
        ], 'Berhasil mengambil rekap absensi kelas');
    }
}
