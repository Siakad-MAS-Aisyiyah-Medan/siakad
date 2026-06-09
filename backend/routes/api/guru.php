<?php

use App\Http\Controllers\Api\Guru\AbsensiController;
use App\Http\Controllers\Api\Guru\JadwalController;
use App\Http\Controllers\Api\Guru\NilaiController;
use App\Http\Controllers\Api\LaporanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'permission:view_jadwal_mengajar'])->group(function () {
    Route::get('/guru/jadwal', [JadwalController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'permission:manage_absensi_siswa'])->group(function () {
    Route::get('/guru/absensi/siswa/form', [AbsensiController::class, 'formData']);
    Route::post('/guru/absensi/siswa/bulk', [AbsensiController::class, 'bulkStore']);
    Route::get('/guru/absensi/siswa/rekap', [AbsensiController::class, 'rekapSiswa']);
});

Route::middleware(['auth:sanctum', 'permission:manage_nilai_siswa'])->group(function () {
    Route::get('/guru/nilai/form', [NilaiController::class, 'formData']);
    Route::post('/guru/nilai/bulk', [NilaiController::class, 'bulkStore']);
});

Route::middleware(['auth:sanctum', 'permission:manage_absensi_siswa,manage_nilai_siswa'])->group(function () {
    Route::get('/guru/laporan', [LaporanController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'permission:view_dashboard_guru'])->group(function () {
    Route::post('/guru/absensi/self/check-in', [AbsensiController::class, 'checkIn']);
    Route::post('/guru/absensi/self/check-out', [AbsensiController::class, 'checkOut']);
    Route::get('/guru/absensi/self/riwayat', [AbsensiController::class, 'riwayatGuru']);
});
