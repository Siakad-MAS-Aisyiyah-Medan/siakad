<?php

namespace App\Http\Controllers\Api\Kepsek;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\AbsensiGuruService;
use App\Services\AbsensiSiswaService;
use Illuminate\Http\Request;

class LaporanAbsensiController extends Controller
{
    public function __construct(
        private AbsensiSiswaService $absensiSiswa,
        private AbsensiGuruService $absensiGuru
    ) {
    }

    public function siswa(Request $request)
    {
        $rekap = $this->absensiSiswa->rekap($request->only([
            'id_kelas', 'id_mapel', 'tanggal_dari', 'tanggal_sampai', 'semester', 'tahun_ajaran', 'bulan',
        ]));

        return ApiResponse::success($rekap, 'Berhasil mengambil laporan absensi siswa');
    }

    public function guru(Request $request)
    {
        $rekap = $this->absensiGuru->rekap($request->only([
            'id_user_guru', 'tanggal_dari', 'tanggal_sampai', 'semester', 'tahun_ajaran', 'bulan',
        ]));

        return ApiResponse::success($rekap, 'Berhasil mengambil laporan absensi guru');
    }
}
