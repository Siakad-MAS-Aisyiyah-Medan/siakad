<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilSekolah;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfilSekolahController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show()
    {
        $profil = ProfilSekolah::first();
        
        if (!$profil) {
            // Jika belum ada, buat record kosong dengan default
            $profil = ProfilSekolah::create([
                'nama_sekolah' => 'Sistem Informasi Akademik',
                'hero_subtitle' => 'Sistem Informasi Akademik Terpadu',
                'tentang_kami' => 'Sistem informasi akademik berbasis web.',
                'alamat' => '-',
                'kata_sambutan' => 'Selamat datang di Sistem Informasi Akademik.',
                'nama_kepsek' => '-',
                'visi' => '-',
                'misi' => '-'
            ]);
        }

        return ApiResponse::success($profil, 'Profil Sekolah berhasil diambil');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_sekolah' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'tentang_kami' => 'nullable|string',
            'alamat' => 'nullable|string',
            'kata_sambutan' => 'nullable|string',
            'nama_kepsek' => 'nullable|string|max:255',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validasi Gagal', 422, $validator->errors());
        }

        $profil = ProfilSekolah::first();
        if (!$profil) {
            $profil = new ProfilSekolah();
        }

        $profil->fill($request->all());
        $profil->save();

        return ApiResponse::success($profil, 'Profil Sekolah berhasil diperbarui');
    }
}
