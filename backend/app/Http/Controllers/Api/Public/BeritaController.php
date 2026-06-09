<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Helpers\ApiResponse;

class BeritaController extends Controller
{
    /**
     * Mengambil daftar berita/prestasi yang sudah dipublikasi.
     * Tampilan untuk publik (tanpa login).
     */
    public function index()
    {
        // Ambil berita yang di-publish, urutkan dari yang terbaru
        $berita = Berita::where('is_published', true)
            ->orderByDesc('tanggal_publikasi')
            ->orderByDesc('id')
            ->get();

        return ApiResponse::success(
            $berita,
            'Berita berhasil diambil'
        );
    }

    /**
     * Mengambil detail satu berita.
     */
    public function show($id)
    {
        $berita = Berita::where('is_published', true)->findOrFail($id);

        return ApiResponse::success(
            $berita,
            'Detail berita berhasil diambil'
        );
    }
}
