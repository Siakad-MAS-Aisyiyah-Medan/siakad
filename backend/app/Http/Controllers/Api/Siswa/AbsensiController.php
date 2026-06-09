<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Siswa\SiswaFilterRequest;
use App\Services\AbsensiSiswaService;

class AbsensiController extends Controller
{
    public function __construct(private AbsensiSiswaService $absensiSiswa)
    {
    }

    public function index(SiswaFilterRequest $request)
    {
        $items = $this->absensiSiswa->listForSiswa(
            (int) $request->user()->id_user,
            $request->validated()
        );

        return ApiResponse::success($items, 'Berhasil mengambil riwayat absensi');
    }
}
