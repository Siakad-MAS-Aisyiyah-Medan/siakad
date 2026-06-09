<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePengumumanRequest;
use App\Http\Requests\Admin\UpdatePengumumanRequest;
use App\Services\PengumumanService;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function __construct(private PengumumanService $pengumumanService)
    {
    }

    public function index(Request $request)
    {
        $paginator = $this->pengumumanService->list(
            $request->query('search'),
            (int) $request->query('per_page', 15)
        );

        return ApiResponse::paginated($paginator, 'Berhasil mengambil data pengumuman');
    }

    public function show($id)
    {
        return ApiResponse::success(
            $this->pengumumanService->find((int) $id),
            'Berhasil mengambil detail pengumuman'
        );
    }

    public function store(StorePengumumanRequest $request)
    {
        $item = $this->pengumumanService->create($request->validated());

        return ApiResponse::success($item, 'Pengumuman berhasil ditambahkan', 201);
    }

    public function update(UpdatePengumumanRequest $request, $id)
    {
        $item = $this->pengumumanService->update((int) $id, $request->validated());

        return ApiResponse::success($item, 'Pengumuman berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->pengumumanService->delete((int) $id);

        return ApiResponse::success(null, 'Pengumuman berhasil dihapus');
    }
}
