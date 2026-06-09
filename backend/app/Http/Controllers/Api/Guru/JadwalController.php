<?php

namespace App\Http\Controllers\Api\Guru;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\JadwalService;
use Illuminate\Http\Request;
class JadwalController extends Controller
{
    public function __construct(private JadwalService $jadwalService)
    {
    }

    public function index(Request $request)
    {
        $user = $request->user();

        if (!in_array($user->role, ['guru', 'wali_kelas'], true)) {
            return ApiResponse::error('Akses jadwal mengajar hanya untuk guru.', 403);
        }

        $items = $this->jadwalService->listForGuru(
            (int) $user->id_user,
            $request->query('tahun_ajaran'),
            $request->query('semester')
        );

        return ApiResponse::success($items, 'Berhasil mengambil jadwal mengajar');
    }
}
