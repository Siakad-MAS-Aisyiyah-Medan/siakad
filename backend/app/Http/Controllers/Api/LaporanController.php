<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LaporanFilterRequest;
use App\Services\LaporanService;
use Illuminate\Http\Request;
use InvalidArgumentException;

class LaporanController extends Controller
{
    public function __construct(private LaporanService $laporanService)
    {
    }

    public function index(LaporanFilterRequest $request)
    {
        try {
            $data = $this->laporanService->generate(
                $request->user(),
                $request->input('jenis'),
                $request->validated()
            );

            return ApiResponse::success($data, 'Berhasil mengambil laporan');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }
}
