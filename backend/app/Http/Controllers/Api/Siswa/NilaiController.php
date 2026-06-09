<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Siswa\SiswaFilterRequest;
use App\Http\Requests\Siswa\SiswaRaportRequest;
use App\Services\NilaiService;

class NilaiController extends Controller
{
    public function __construct(private NilaiService $nilaiService)
    {
    }

    public function index(SiswaFilterRequest $request)
    {
        $items = $this->nilaiService->listForSiswa(
            (int) $request->user()->id_user,
            $request->validated(),
            true
        );

        return ApiResponse::success($items, 'Berhasil mengambil nilai');
    }

    public function raport(SiswaRaportRequest $request)
    {
        $raport = $this->nilaiService->raportForSiswa(
            (int) $request->user()->id_user,
            $request->validated('semester'),
            $request->validated('tahun_ajaran')
        );

        return ApiResponse::success($raport, 'Berhasil mengambil rapor');
    }
}
