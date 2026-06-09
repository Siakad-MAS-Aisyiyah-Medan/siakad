<?php

require __DIR__.'/api/auth.php';
require __DIR__.'/api/ppdb.php';
require __DIR__.'/api/admin.php';
require __DIR__.'/api/guru.php';
require __DIR__.'/api/siswa.php';
require __DIR__.'/api/wali.php';
require __DIR__.'/api/kepsek.php';
require __DIR__.'/api/calon-siswa.php';

// Route Publik (Tidak butuh login)
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Public\PengumumanController as PublicPengumumanController;
use App\Http\Controllers\Api\Public\BeritaController as PublicBeritaController;
use App\Http\Controllers\Api\Public\EkskulController as PublicEkskulController;

Route::prefix('public')->group(function () {
    Route::get('/pengumuman', [PublicPengumumanController::class, 'index']);
    Route::get('/pengumuman/{id}', [PublicPengumumanController::class, 'show']);
    Route::get('/berita', [PublicBeritaController::class, 'index']);
    Route::get('/berita/{id}', [PublicBeritaController::class, 'show']);
    Route::get('/ekskul', [PublicEkskulController::class, 'index']);
});
