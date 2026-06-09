<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IndexAbsensiGuruRequest;
use App\Services\AbsensiGuruService;

class AbsensiGuruController extends Controller
{
    public function __construct(private AbsensiGuruService $absensiGuru)
    {
    }

    public function index(IndexAbsensiGuruRequest $request)
    {
        $paginator = $this->absensiGuru->listAdmin(
            $request->validated(),
            (int) $request->validated('per_page', 15)
        );

        return ApiResponse::paginated($paginator, 'Berhasil mengambil data absensi guru');
    }

    public function rekap(IndexAbsensiGuruRequest $request)
    {
        $rekap = $this->absensiGuru->rekap($request->validated());

        return ApiResponse::success($rekap, 'Berhasil mengambil rekap absensi guru');
    }
}
