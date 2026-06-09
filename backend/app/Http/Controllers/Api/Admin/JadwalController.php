<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exceptions\JadwalConflictException;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreJadwalRequest;
use App\Http\Requests\Admin\UpdateJadwalRequest;
use App\Services\JadwalService;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function __construct(private JadwalService $jadwalService)
    {
    }

    public function matrix(Request $request, $id_kelas)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        $waktuList = \App\Models\WaktuPelajaran::orderBy('jam_mulai')->get();
        $jadwalList = \App\Models\JadwalPelajaran::with(['mapel', 'guru.guru'])
            ->where('id_kelas', $id_kelas)
            ->where('tahun_ajaran', $request->query('tahun_ajaran'))
            ->where('semester', $request->query('semester'))
            ->get();

        $matrix = [];
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        foreach ($waktuList as $waktu) {
            $row = [
                'waktu' => $waktu,
                'jadwal' => []
            ];
            foreach ($hariList as $hari) {
                $j = $jadwalList->first(fn($item) => $item->hari === $hari && $item->id_waktu === $waktu->id_waktu);
                $row['jadwal'][$hari] = $j ? (new \App\Http\Resources\JadwalResource($j))->resolve() : null;
            }
            $matrix[] = $row;
        }

        return ApiResponse::success([
            'waktu' => $waktuList,
            'matrix' => $matrix
        ], 'Berhasil mengambil matrix jadwal');
    }

    public function storeMatrix(Request $request, $id_kelas)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:Ganjil,Genap',
            'jadwal' => 'array',
            'jadwal.*.hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jadwal.*.id_waktu' => 'required|exists:waktu_pelajaran,id_waktu',
            'jadwal.*.id_mapel' => 'required|exists:mata_pelajaran,id_mapel',
            'jadwal.*.id_guru' => 'required|exists:users,id_user',
            'jadwal.*.ruangan' => 'nullable|string'
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            \App\Models\JadwalPelajaran::where('id_kelas', $id_kelas)
                ->where('tahun_ajaran', $request->tahun_ajaran)
                ->where('semester', $request->semester)
                ->delete();

            foreach ($request->jadwal ?? [] as $j) {
                $data = array_merge($j, [
                    'id_kelas' => $id_kelas,
                    'tahun_ajaran' => $request->tahun_ajaran,
                    'semester' => $request->semester
                ]);
                $this->jadwalService->create($data);
            }
            
            \Illuminate\Support\Facades\DB::commit();
            return ApiResponse::success(null, 'Jadwal matrix berhasil disimpan');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            if ($e instanceof JadwalConflictException) {
                return $this->conflictResponse($e);
            }
            throw $e;
        }
    }

    public function index(Request $request)
    {
        $paginator = $this->jadwalService->list(
            $request->query('search'),
            (int) $request->query('per_page', 15)
        );

        return ApiResponse::paginated($paginator, 'Berhasil mengambil data jadwal');
    }

    public function store(StoreJadwalRequest $request)
    {
        try {
            $jadwal = $this->jadwalService->create($request->validated());

            return ApiResponse::success($jadwal, 'Jadwal berhasil ditambahkan', 201);
        } catch (JadwalConflictException $e) {
            return $this->conflictResponse($e);
        } catch (\Throwable $e) {
            report($e);

            return ApiResponse::error('Gagal menyimpan jadwal', 500);
        }
    }

    public function update(UpdateJadwalRequest $request, $id)
    {
        try {
            $jadwal = $this->jadwalService->update((int) $id, $request->validated());

            return ApiResponse::success($jadwal, 'Jadwal berhasil diperbarui');
        } catch (JadwalConflictException $e) {
            return $this->conflictResponse($e);
        } catch (\Throwable $e) {
            report($e);

            return ApiResponse::error('Gagal memperbarui jadwal', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->jadwalService->delete((int) $id);

            return ApiResponse::success(null, 'Jadwal berhasil dihapus');
        } catch (\Throwable $e) {
            report($e);

            return ApiResponse::error('Gagal menghapus jadwal', 500);
        }
    }

    private function conflictResponse(JadwalConflictException $e)
    {
        return ApiResponse::error($e->getMessage(), 422, [
            'conflict_type' => $e->conflictType,
        ]);
    }
}
