<?php

namespace App\Http\Controllers\Api\CalonSiswa;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CalonSiswa\UpdatePendaftaranRequest;
use App\Http\Resources\PendaftaranResource;
use App\Services\PendaftaranService;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class PendaftaranController extends Controller
{
    public function __construct(private PendaftaranService $pendaftaranService)
    {
    }

    public function show()
    {
        $user = Auth::user();
        $data = $this->pendaftaranService->getByUser($user);

        return ApiResponse::success(
            $data ? PendaftaranResource::applicant($data)->resolve() : null
        );
    }

    public function update(UpdatePendaftaranRequest $request)
    {
        $user = Auth::user();

        try {
            $pendaftaran = $this->pendaftaranService->saveDraftForUser(
                $user,
                $request->safeFields(),
                $request
            );

            return ApiResponse::success(
                PendaftaranResource::applicant($pendaftaran)->resolve(),
                'Draft pendaftaran disimpan'
            );
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }

    public function submit()
    {
        $user = Auth::user();
        if ($user->role !== 'calon_siswa') {
            return ApiResponse::error('Hanya calon siswa yang dapat submit', 403);
        }

        try {
            $pendaftaran = $this->pendaftaranService->submitForUser($user);

            return ApiResponse::success(
                PendaftaranResource::applicant($pendaftaran)->resolve(),
                'Pendaftaran berhasil dikirim'
            );
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }
}
