<?php

use App\Http\Controllers\Api\Kepsek\LaporanAbsensiController;
use App\Http\Controllers\Api\Kepsek\LaporanNilaiController;
use App\Http\Controllers\Api\LaporanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'permission:view_laporan'])->group(function () {
    Route::get('/kepsek/laporan', [LaporanController::class, 'index']);
    Route::get('/kepsek/laporan/absensi-siswa', [LaporanAbsensiController::class, 'siswa']);
    Route::get('/kepsek/laporan/absensi-guru', [LaporanAbsensiController::class, 'guru']);
    Route::get('/kepsek/laporan/nilai', [LaporanNilaiController::class, 'index']);
});
