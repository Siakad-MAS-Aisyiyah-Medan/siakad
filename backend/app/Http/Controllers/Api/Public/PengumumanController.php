<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Http\Resources\PengumumanResource;
use App\Helpers\ApiResponse;

class PengumumanController extends Controller
{
    /**
     * Mengambil daftar pengumuman yang sudah dipublikasi.
     * Tampilan untuk publik (tanpa login).
     */
    public function index()
    {
        // Ambil pengumuman yang di-publish, urutkan dari yang terbaru
        $pengumuman = Pengumuman::where('is_published', true)
            ->orderByDesc('tanggal_publikasi')
            ->orderByDesc('id')
            ->paginate(12);

        return ApiResponse::paginated(
            $pengumuman,
            'Berita dan pengumuman berhasil diambil',
            fn ($item) => (new PengumumanResource($item))->resolve()
        );
    }

    /**
     * Mengambil detail satu pengumuman.
     */
    public function show($id)
    {
        // Pastikan hanya pengumuman yang di-publish yang bisa dilihat publik
        $pengumuman = Pengumuman::where('is_published', true)->findOrFail($id);

        return ApiResponse::success(
            (new PengumumanResource($pengumuman))->resolve(),
            'Detail berita berhasil diambil'
        );
    }
}
