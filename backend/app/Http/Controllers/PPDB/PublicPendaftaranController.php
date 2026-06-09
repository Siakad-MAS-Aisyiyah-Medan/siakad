<?php

namespace App\Http\Controllers\PPDB;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\PpdbService;

class PublicPendaftaranController extends Controller
{
    public function __construct(private PpdbService $ppdb)
    {
    }

    public function info()
    {
        return ApiResponse::success($this->ppdb->getPublicInfo(), 'Informasi PPDB');
    }
}
