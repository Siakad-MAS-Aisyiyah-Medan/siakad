<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EkskulResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_ekskul' => $this->id_ekskul,
            'nama_ekskul' => $this->nama_ekskul,
            'deskripsi' => $this->deskripsi,
            'id_pembina' => $this->id_pembina,
            'hari' => $this->hari,
            'jam' => $this->jam,
            'lokasi' => $this->lokasi,
            'pembina' => $this->whenLoaded('pembina', fn () => [
                'id_user' => $this->pembina?->id_user,
                'nama_guru' => $this->pembina?->guru?->nama_guru,
            ]),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
