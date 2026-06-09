<?php

namespace App\Services;

use App\Traits\AuditsAdminActions;
use App\Http\Resources\KelasResource;
use App\Models\Kelas;
use App\Support\SearchInput;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class KelasService
{
    use AuditsAdminActions;
    public function list(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Kelas::with(['waliKelas.guru'])->withCount('jadwal');

        if ($term = SearchInput::escape($search)) {
            $query->where('nama_kelas', 'like', "%{$term}%");
        }

        $paginator = $query->orderBy('nama_kelas')->paginate($perPage);
        $paginator->getCollection()->transform(
            fn ($item) => (new KelasResource($item))->resolve()
        );

        return $paginator;
    }

    public function create(array $data): array
    {
        $kelas = Kelas::create($data);
        $this->auditAdmin('kelas.create', $kelas, ['nama_kelas' => $kelas->nama_kelas]);

        return (new KelasResource($kelas->load('waliKelas.guru')))->resolve();
    }

    public function update(int $id, array $data): array
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->update($data);
        $this->auditAdmin('kelas.update', $kelas, ['nama_kelas' => $kelas->nama_kelas]);

        return (new KelasResource($kelas->fresh(['waliKelas.guru'])))->resolve();
    }

    public function delete(int $id): void
    {
        $kelas = Kelas::findOrFail($id);
        $this->auditAdmin('kelas.delete', $kelas, ['nama_kelas' => $kelas->nama_kelas]);
        $kelas->delete();
    }
}
