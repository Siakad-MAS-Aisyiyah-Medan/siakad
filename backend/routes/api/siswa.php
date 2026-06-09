<?php

use App\Http\Controllers\Api\Siswa\AbsensiController;
use App\Http\Controllers\Api\Siswa\JadwalController;
use App\Http\Controllers\Api\Siswa\NilaiController;
use App\Http\Controllers\Api\LaporanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'permission:view_jadwal_siswa'])->group(function () {
    Route::get('/siswa/jadwal', [JadwalController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'permission:view_absensi_pribadi'])->group(function () {
    Route::get('/siswa/absensi', [AbsensiController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'permission:view_nilai_pribadi'])->group(function () {
    Route::get('/siswa/nilai', [NilaiController::class, 'index']);
    Route::get('/siswa/nilai/raport', [NilaiController::class, 'raport']);
});

Route::middleware(['auth:sanctum', 'permission:view_absensi_pribadi,view_nilai_pribadi'])->group(function () {
    Route::get('/siswa/laporan', [LaporanController::class, 'index']);
});
