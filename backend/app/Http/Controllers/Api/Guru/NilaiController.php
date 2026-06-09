<?php

namespace App\Http\Controllers\Api\Guru;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Guru\BulkNilaiRequest;
use App\Http\Requests\Guru\NilaiFormRequest;
use App\Services\NilaiService;
use InvalidArgumentException;

class NilaiController extends Controller
{
    public function __construct(private NilaiService $nilaiService)
    {
    }

    public function formData(NilaiFormRequest $request)
    {
        try {
            $data = $this->nilaiService->getFormData(
                (int) $request->user()->id_user,
                $request->validated()
            );

            return ApiResponse::success($data, 'Berhasil mengambil daftar nilai siswa');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }

    public function bulkStore(BulkNilaiRequest $request)
    {
        try {
            $saved = $this->nilaiService->bulkSave(
                (int) $request->user()->id_user,
                $request->validated()
            );

            return ApiResponse::success($saved, 'Nilai siswa berhasil disimpan');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        } catch (\Throwable $e) {
            report($e);

            return ApiResponse::error('Gagal menyimpan nilai siswa', 500);
        }
    }
}
