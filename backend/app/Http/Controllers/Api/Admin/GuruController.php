<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IndexGuruRequest;
use App\Http\Requests\Admin\StoreGuruRequest;
use App\Http\Requests\Admin\UpdateGuruRequest;
use App\Services\GuruService;
use InvalidArgumentException;

class GuruController extends Controller
{
    public function __construct(private GuruService $guruService)
    {
    }

    public function index(IndexGuruRequest $request)
    {
        $paginator = $this->guruService->listGuru(
            $request->validated('search'),
            (int) $request->validated('per_page', 15),
            $request->validated('role')
        );

        return ApiResponse::paginated($paginator, 'Berhasil mengambil data guru');
    }

    public function store(StoreGuruRequest $request)
    {
        try {
            $guru = $this->guruService->createGuru($request->validated());

            return ApiResponse::success($guru, 'Data Guru berhasil ditambahkan', 201);
        } catch (\Throwable $e) {
            report($e);

            return ApiResponse::error('Gagal menyimpan data guru', 500);
        }
    }

    public function update(UpdateGuruRequest $request, $id)
    {
        try {
            $guru = $this->guruService->updateGuru((int) $id, $request->validated());

            return ApiResponse::success($guru, 'Data Guru berhasil diperbarui');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        } catch (\Throwable $e) {
            report($e);

            return ApiResponse::error('Gagal memperbarui data guru', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->guruService->deleteGuru((int) $id);

            return ApiResponse::success(null, 'Data Guru berhasil dihapus');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        } catch (\Throwable $e) {
            report($e);

            return ApiResponse::error('Gagal menghapus data guru', 500);
        }
    }
}
