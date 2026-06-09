<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEkskulRequest;
use App\Http\Requests\Admin\UpdateEkskulRequest;
use App\Services\EkskulService;
use Illuminate\Http\Request;

class EkskulController extends Controller
{
    public function __construct(private EkskulService $ekskulService)
    {
    }

    public function index(Request $request)
    {
        $paginator = $this->ekskulService->list(
            $request->query('search'),
            (int) $request->query('per_page', 15)
        );

        return ApiResponse::paginated($paginator, 'Berhasil mengambil data ekstrakurikuler');
    }

    public function show($id)
    {
        return ApiResponse::success(
            $this->ekskulService->find((int) $id),
            'Berhasil mengambil detail ekstrakurikuler'
        );
    }

    public function store(StoreEkskulRequest $request)
    {
        $item = $this->ekskulService->create($request->validated());

        return ApiResponse::success($item, 'Ekstrakurikuler berhasil ditambahkan', 201);
    }

    public function update(UpdateEkskulRequest $request, $id)
    {
        $item = $this->ekskulService->update((int) $id, $request->validated());

        return ApiResponse::success($item, 'Ekstrakurikuler berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->ekskulService->delete((int) $id);

        return ApiResponse::success(null, 'Ekstrakurikuler berhasil dihapus');
    }
}
