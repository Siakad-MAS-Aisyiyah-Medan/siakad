<?php

use App\Http\Controllers\Api\Wali\AbsensiController;
use App\Http\Controllers\Api\Wali\NilaiController;
use App\Http\Controllers\Api\LaporanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'permission:view_absensi_kelas'])->group(function () {
    Route::get('/wali/absensi/rekap', [AbsensiController::class, 'rekapKelas']);
});

Route::middleware(['auth:sanctum', 'permission:validate_nilai'])->group(function () {
    Route::get('/wali/nilai/leger', [NilaiController::class, 'leger']);
    Route::patch('/wali/nilai/validate', [NilaiController::class, 'validateNilai']);
});

Route::middleware(['auth:sanctum', 'permission:view_absensi_kelas'])->group(function () {
    Route::get('/wali/laporan', [LaporanController::class, 'index']);
});
