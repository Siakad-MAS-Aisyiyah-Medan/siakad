<?php

namespace App\Http\Controllers\PPDB;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PPDB\RegisterCalonMuridRequest;
use App\Http\Requests\PPDB\SaveFormulirRequest;
use App\Http\Requests\PPDB\UploadBerkasRequest;
use App\Http\Resources\PpdbResource;
use App\Http\Resources\UserResource;
use App\Services\PpdbService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Throwable;

class CalonMuridPendaftaranController extends Controller
{
    public function __construct(private PpdbService $ppdb)
    {
    }

    /**
     * @deprecated Gunakan POST /api/auth/register-calon-siswa
     */
    public function register(RegisterCalonMuridRequest $request)
    {
        return ApiResponse::error(
            'Endpoint ini tidak lagi digunakan. Daftar akun melalui POST /api/auth/register-calon-siswa, lalu isi formulir PPDB setelah login.',
            410
        );
    }

    public function me()
    {
        $user = Auth::user();
        $data = $this->ppdb->getByUser($user);

        return ApiResponse::success([
            'user' => (new UserResource($user))->resolve(),
            'pendaftaran' => $data ? PpdbResource::applicant($data)->resolve() : null,
        ]);
    }

    public function saveFormulir(SaveFormulirRequest $request)
    {
        try {
            $pendaftaran = $this->ppdb->saveFormulir(Auth::user(), $request->validated());

            return ApiResponse::success(
                PpdbResource::applicant($pendaftaran)->resolve(),
                'Formulir disimpan sebagai draft'
            );
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }

    public function uploadBerkas(UploadBerkasRequest $request)
    {
        try {
            $berkas = $this->ppdb->uploadBerkas(
                Auth::user(),
                $request->validated('jenis_berkas'),
                $request->file('file')
            );

            return ApiResponse::success($berkas, 'Berkas berhasil diunggah');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }

    public function submit()
    {
        $user = Auth::user();
        if ($user->role !== 'calon_siswa') {
            return ApiResponse::error('Hanya calon murid yang dapat submit', 403);
        }

        try {
            $pendaftaran = $this->ppdb->submit($user);

            return ApiResponse::success(
                PpdbResource::applicant($pendaftaran)->resolve(),
                'Pendaftaran berhasil diajukan'
            );
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }

    public function status()
    {
        $data = $this->ppdb->getByUser(Auth::user());

        if (!$data) {
            return ApiResponse::success(null, 'Belum ada data pendaftaran');
        }

        return ApiResponse::success([
            'status' => $data->ppdb_status,
            'no_registrasi' => $data->no_registrasi,
            'catatan_admin' => $data->catatan_admin,
            'submitted_at' => $data->submitted_at,
            'verified_at' => $data->verified_at,
            'accepted_at' => $data->accepted_at,
        ]);
    }

    public function bukti()
    {
        $data = $this->ppdb->getByUser(Auth::user());
        if (!$data) {
            return ApiResponse::error('Data pendaftaran tidak ditemukan', 404);
        }

        if (!in_array($data->ppdb_status, ['diterima', 'daftar_ulang', 'menjadi_murid'], true)) {
            return ApiResponse::error('Bukti hanya tersedia untuk pendaftar yang diterima', 403);
        }

        return ApiResponse::success($this->ppdb->getBuktiData($data), 'Bukti pendaftaran');
    }
}
