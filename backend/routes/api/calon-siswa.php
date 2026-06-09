<?php

use App\Http\Controllers\Api\CalonSiswa\PendaftaranController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'permission:manage_pendaftaran_pribadi,view_status_pendaftaran'])->group(function () {
    Route::get('/pendaftaran', [PendaftaranController::class, 'show']);
    Route::put('/pendaftaran', [PendaftaranController::class, 'update']);
    Route::post('/pendaftaran/submit', [PendaftaranController::class, 'submit']);
});
