<?php

namespace App\Http\Controllers\Api\Guru;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Guru\AbsensiSiswaFormRequest;
use App\Http\Requests\Guru\BulkAbsensiSiswaRequest;
use App\Http\Requests\Guru\GuruAbsensiSelfRequest;
use App\Http\Requests\Guru\GuruRekapAbsensiRequest;
use App\Http\Requests\Guru\GuruRiwayatAbsensiRequest;
use App\Services\AbsensiGuruService;
use App\Services\AbsensiSiswaService;
use Illuminate\Http\Request;
use InvalidArgumentException;

class AbsensiController extends Controller
{
    public function __construct(
        private AbsensiSiswaService $absensiSiswa,
        private AbsensiGuruService $absensiGuru
    ) {
    }

    public function formData(AbsensiSiswaFormRequest $request)
    {
        try {
            $data = $this->absensiSiswa->getFormData(
                (int) $request->user()->id_user,
                $request->validated()
            );

            return ApiResponse::success($data, 'Berhasil mengambil daftar siswa');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }

    public function bulkStore(BulkAbsensiSiswaRequest $request)
    {
        try {
            $saved = $this->absensiSiswa->bulkSave(
                (int) $request->user()->id_user,
                $request->validated()
            );

            return ApiResponse::success($saved, 'Absensi siswa berhasil disimpan');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        } catch (\Throwable $e) {
            report($e);

            return ApiResponse::error('Gagal menyimpan absensi siswa', 500);
        }
    }

    public function rekapSiswa(GuruRekapAbsensiRequest $request)
    {
        try {
            $rekap = $this->absensiSiswa->rekap(
                $request->validated(),
                (int) $request->user()->id_user
            );

            return ApiResponse::success($rekap, 'Berhasil mengambil rekap absensi siswa');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }

    public function checkIn(GuruAbsensiSelfRequest $request)
    {
        try {
            $data = $this->absensiGuru->checkIn(
                (int) $request->user()->id_user,
                $request->validated('keterangan')
            );

            return ApiResponse::success($data, 'Absen masuk berhasil dicatat');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }

    public function checkOut(GuruAbsensiSelfRequest $request)
    {
        try {
            $data = $this->absensiGuru->checkOut(
                (int) $request->user()->id_user,
                $request->validated('keterangan')
            );

            return ApiResponse::success($data, 'Absen pulang berhasil dicatat');
        } catch (InvalidArgumentException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        }
    }

    public function riwayatGuru(GuruRiwayatAbsensiRequest $request)
    {
        $items = $this->absensiGuru->listForGuru(
            (int) $request->user()->id_user,
            $request->validated()
        );

        return ApiResponse::success($items, 'Berhasil mengambil riwayat absensi guru');
    }
}
