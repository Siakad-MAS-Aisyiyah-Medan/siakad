<?php

namespace App\Http\Resources;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AbsensiGuruResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_absensi_guru' => $this->id_absensi_guru,
            'id_user_guru' => $this->id_user_guru,
            'tanggal' => $this->tanggal?->format('Y-m-d'),
            'jam_masuk' => $this->jam_masuk,
            'jam_pulang' => $this->jam_pulang,
            'status' => $this->status,
            'status_label' => Absensi::statusLabels()[$this->status] ?? $this->status,
            'keterangan' => $this->keterangan,
            'tahun_ajaran' => $this->tahun_ajaran,
            'semester' => $this->semester,
            'guru' => $this->whenLoaded('guru', fn () => [
                'id_user' => $this->guru?->id_user,
                'nama_guru' => $this->guru?->guru?->nama_guru,
            ]),
        ];
    }
}
