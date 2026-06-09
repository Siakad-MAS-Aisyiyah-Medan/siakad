<?php

namespace App\Http\Controllers\Api\Siswa;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\JadwalService;
use Illuminate\Http\Request;
use InvalidArgumentException;

class JadwalController extends Controller
{
    public function __construct(private JadwalService $jadwalService)
    {
    }

    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'siswa') {
            return ApiResponse::error('Akses jadwal pelajaran hanya untuk siswa.', 403);
        }

        try {
            $items = $this->jadwalService->listForSiswa(
                (int) $user->id_user,
                $request->query('tahun_ajaran'),
                $request->query('semester')
            );

            return ApiResponse::success($items, 'Berhasil mengambil jadwal pelajaran');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }
}
