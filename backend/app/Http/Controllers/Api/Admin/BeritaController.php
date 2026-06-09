<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBeritaRequest;
use App\Http\Requests\Admin\UpdateBeritaRequest;
use App\Services\BeritaService;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function __construct(private BeritaService $beritaService)
    {
    }

    public function index(Request $request)
    {
        $paginator = $this->beritaService->list(
            $request->query('search'),
            $request->query('kategori'),
            (int) $request->query('per_page', 15)
        );

        return ApiResponse::paginated($paginator, 'Berhasil mengambil data berita & prestasi');
    }

    public function show($id)
    {
        return ApiResponse::success(
            $this->beritaService->find((int) $id),
            'Berhasil mengambil detail artikel'
        );
    }

    public function store(StoreBeritaRequest $request)
    {
        $item = $this->beritaService->create($request->validated());

        return ApiResponse::success($item, 'Artikel berhasil ditambahkan', 201);
    }

    public function update(UpdateBeritaRequest $request, $id)
    {
        $item = $this->beritaService->update((int) $id, $request->validated());

        return ApiResponse::success($item, 'Artikel berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->beritaService->delete((int) $id);

        return ApiResponse::success(null, 'Artikel berhasil dihapus');
    }
}
