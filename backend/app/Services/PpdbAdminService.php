<?php

namespace App\Services;

use App\Models\Pendaftaran;
use App\Traits\AuditsAdminActions;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use InvalidArgumentException;

class PpdbAdminService
{
    use AuditsAdminActions;

    public function __construct(
        private PendaftaranStateService $state,
        private PpdbService $ppdb,
    ) {
    }

    public function list(?string $search = null, ?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->ppdb->adminList($search, $status, $perPage);
    }

    public function find(int $id): Pendaftaran
    {
        return $this->ppdb->adminFind($id);
    }

    public function updateStatus(int $id, string $status, ?string $catatan = null): Pendaftaran
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $updated = match ($status) {
            'terverifikasi' => $this->ppdb->adminVerifikasi($id),
            'revisi' => $this->ppdb->adminRevisi($id, $catatan ?? ''),
            'diterima' => $this->ppdb->adminTerima($id, $catatan),
            'ditolak' => $this->ppdb->adminTolak($id, $catatan ?? ''),
            default => throw new InvalidArgumentException('Status tidak valid.'),
        };

        $this->auditAdmin('ppdb.status_update', $updated, [
            'status' => $status,
            'id_user' => $updated->id_user,
        ]);

        return $updated;
    }
}
