<?php

namespace App\Http\Controllers\PPDB;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PPDB\UploadBerkasRequest;
use App\Services\PpdbBerkasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class PpdbBerkasController extends Controller
{
    public function __construct(private PpdbBerkasService $berkas)
    {
    }

    public function index()
    {
        try {
            return ApiResponse::success($this->berkas->listForUser(Auth::user()));
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }

    public function store(UploadBerkasRequest $request)
    {
        try {
            $item = $this->berkas->upload(
                Auth::user(),
                $request->validated('jenis_berkas'),
                $request->file('file')
            );

            return ApiResponse::success($item, 'Berkas berhasil diunggah');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }

    public function destroy(string $jenis)
    {
        try {
            $this->berkas->delete(Auth::user(), $jenis);

            return ApiResponse::success(null, 'Berkas berhasil dihapus');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }
}
