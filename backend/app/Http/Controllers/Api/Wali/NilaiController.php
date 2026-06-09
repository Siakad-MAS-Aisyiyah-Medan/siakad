<?php

namespace App\Http\Controllers\Api\Wali;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Wali\NilaiLegerRequest;
use App\Http\Requests\Wali\ValidateNilaiRequest;
use App\Services\NilaiService;
use InvalidArgumentException;

class NilaiController extends Controller
{
    public function __construct(private NilaiService $nilaiService)
    {
    }

    public function leger(NilaiLegerRequest $request)
    {
        try {
            $data = $this->nilaiService->legerForWali(
                (int) $request->user()->id_user,
                $request->validated()
            );

            return ApiResponse::success($data, 'Berhasil mengambil leger nilai kelas');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }

    public function validateNilai(ValidateNilaiRequest $request)
    {
        try {
            $result = $this->nilaiService->validateByWali(
                (int) $request->user()->id_user,
                $request->validated()
            );

            return ApiResponse::success($result, 'Nilai berhasil divalidasi');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }
}
