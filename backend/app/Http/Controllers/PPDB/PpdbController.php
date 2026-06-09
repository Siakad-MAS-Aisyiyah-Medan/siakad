<?php

namespace App\Http\Controllers\PPDB;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PPDB\DokumenRequest;
use App\Http\Requests\PPDB\KepribadianRequest;
use App\Http\Requests\PPDB\KesehatanRequest;
use App\Http\Requests\PPDB\KeteranganPribadiRequest;
use App\Http\Requests\PPDB\OrangTuaWaliRequest;
use App\Http\Requests\PPDB\PendidikanAsalRequest;
use App\Services\PpdbRegistrationService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Throwable;

class PpdbController extends Controller
{
    public function __construct(private PpdbRegistrationService $ppdb)
    {
    }

    public function myRegistration()
    {
        try {
            $pendaftaran = $this->ppdb->getByUser(Auth::user());

            return ApiResponse::success([
                'has_registration' => $pendaftaran !== null,
                'pendaftaran' => $this->ppdb->toArray($pendaftaran),
            ]);
        } catch (Throwable $e) {
            return $this->handleError($e);
        }
    }

    public function start()
    {
        try {
            $result = $this->ppdb->start(Auth::user());
            $payload = $this->ppdb->formatStartResponse($result);

            return ApiResponse::success(
                $payload,
                $result['created']
                    ? 'Draft pendaftaran berhasil dibuat'
                    : 'Melanjutkan draft pendaftaran',
                $result['created'] ? 201 : 200
            );
        } catch (Throwable $e) {
            return $this->handleError($e);
        }
    }

    public function saveKeteranganPribadi(KeteranganPribadiRequest $request)
    {
        return $this->saveStep(
            fn () => $this->ppdb->saveKeteranganPribadi(Auth::user(), $request->validated()),
            'Keterangan pribadi disimpan'
        );
    }

    public function saveKesehatan(KesehatanRequest $request)
    {
        return $this->saveStep(
            fn () => $this->ppdb->saveKesehatan(Auth::user(), $request->validated()),
            'Data kesehatan disimpan'
        );
    }

    public function savePendidikanAsal(PendidikanAsalRequest $request)
    {
        return $this->saveStep(
            fn () => $this->ppdb->savePendidikanAsal(Auth::user(), $request->validated()),
            'Pendidikan asal disimpan'
        );
    }

    public function saveOrangTuaWali(OrangTuaWaliRequest $request)
    {
        return $this->saveStep(
            fn () => $this->ppdb->saveOrangTuaWali(Auth::user(), $request->validated()),
            'Data orang tua/wali disimpan'
        );
    }

    public function saveKepribadian(KepribadianRequest $request)
    {
        return $this->saveStep(
            fn () => $this->ppdb->saveKepribadian(Auth::user(), $request->validated()),
            'Data kepribadian disimpan'
        );
    }

    public function saveDokumen(DokumenRequest $request)
    {
        return $this->saveStep(
            fn () => $this->ppdb->saveDokumen(Auth::user(), $request->validated()),
            'Data dokumen disimpan'
        );
    }

    public function submit()
    {
        try {
            $pendaftaran = $this->ppdb->submit(Auth::user());

            return ApiResponse::success(
                $this->ppdb->toArray($pendaftaran),
                'Pendaftaran berhasil diajukan'
            );
        } catch (Throwable $e) {
            return $this->handleError($e);
        }
    }

    public function status()
    {
        $pendaftaran = $this->ppdb->getByUser(Auth::user());

        if (!$pendaftaran) {
            return ApiResponse::success([
                'has_registration' => false,
                'status_pendaftaran' => null,
            ], 'Belum ada data pendaftaran');
        }

        return ApiResponse::success([
            'has_registration' => true,
            'nomor_pendaftaran' => $pendaftaran->nomor_pendaftaran ?? $pendaftaran->no_registrasi,
            'status_pendaftaran' => $pendaftaran->status_pendaftaran,
            'current_step' => $pendaftaran->current_step,
            'submitted_at' => $pendaftaran->submitted_at,
            'verified_at' => $pendaftaran->verified_at,
            'catatan_admin' => $pendaftaran->catatan_admin,
        ]);
    }

    protected function saveStep(callable $action, string $message)
    {
        try {
            $pendaftaran = $action();

            return ApiResponse::success($this->ppdb->toArray($pendaftaran), $message);
        } catch (Throwable $e) {
            return $this->handleError($e);
        }
    }

    protected function handleError(Throwable $e)
    {
        if ($e instanceof InvalidArgumentException) {
            return ApiResponse::error($e->getMessage(), 422);
        }

        if ($e instanceof QueryException) {
            Log::error('PPDB database error', [
                'message' => $e->getMessage(),
                'sql' => $e->getSql(),
            ]);

            $message = config('app.debug')
                ? 'Database: '.$e->getMessage()
                : 'Gagal menyimpan data pendaftaran. Periksa kelengkapan data atau hubungi admin.';

            return ApiResponse::error($message, 500);
        }

        Log::error('PPDB error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

        $message = config('app.debug')
            ? $e->getMessage()
            : 'Terjadi kesalahan pada proses PPDB.';

        return ApiResponse::error($message, 500);
    }
}
