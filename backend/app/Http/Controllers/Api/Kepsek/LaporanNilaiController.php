<?php

namespace App\Http\Controllers\Api\Kepsek;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\LaporanService;
use Illuminate\Http\Request;
use InvalidArgumentException;

class LaporanNilaiController extends Controller
{
    public function __construct(private LaporanService $laporanService)
    {
    }

    public function index(Request $request)
    {
        try {
            $filters = array_merge(
                $request->only(['id_kelas', 'id_mapel', 'semester', 'tahun_ajaran', 'validated_by_wali']),
                ['per_page' => 1, 'page' => 1]
            );
            if (empty($filters['tahun_ajaran'])) {
                $filters['tahun_ajaran'] = '2025/2026';
            }
            if (empty($filters['semester'])) {
                $filters['semester'] = 'Ganjil';
            }

            $data = $this->laporanService->generate($request->user(), 'nilai', $filters);

            return ApiResponse::success($data['summary'], 'Berhasil mengambil laporan nilai');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }
}
