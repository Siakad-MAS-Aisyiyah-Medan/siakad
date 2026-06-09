<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMapelRequest;
use App\Http\Requests\Admin\UpdateMapelRequest;
use App\Services\MapelService;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function __construct(private MapelService $mapelService)
    {
    }

    public function index(Request $request)
    {
        $paginator = $this->mapelService->list(
            $request->query('search'),
            (int) $request->query('per_page', 15)
        );

        return ApiResponse::paginated($paginator, 'Berhasil mengambil data mata pelajaran');
    }

    public function store(StoreMapelRequest $request)
    {
        $mapel = $this->mapelService->create($request->validated());

        return ApiResponse::success($mapel, 'Mata pelajaran berhasil ditambahkan', 201);
    }

    public function update(UpdateMapelRequest $request, $id)
    {
        $mapel = $this->mapelService->update((int) $id, $request->validated());

        return ApiResponse::success($mapel, 'Mata pelajaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->mapelService->delete((int) $id);

        return ApiResponse::success(null, 'Mata pelajaran berhasil dihapus');
    }
}
