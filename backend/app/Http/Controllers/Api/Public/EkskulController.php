<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\Ekskul;
use App\Helpers\ApiResponse;

class EkskulController extends Controller
{
    /**
     * Mengambil daftar ekstrakurikuler untuk publik.
     */
    public function index()
    {
        $ekskul = Ekskul::orderBy('nama_ekskul', 'asc')->get();

        return ApiResponse::success(
            $ekskul,
            'Data ekstrakurikuler berhasil diambil'
        );
    }
}
