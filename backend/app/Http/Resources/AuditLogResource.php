<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuditLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'action' => $this->action,
            'subject_type' => $this->subject_type,
            'subject_id' => $this->subject_id,
            'ip_address' => $this->ip_address,
            'meta' => $this->meta,
            'created_at' => $this->created_at,
            'actor' => $this->whenLoaded('user', fn () => $this->user ? [
                'id_user' => $this->user->id_user,
                'username' => $this->user->username,
                'role' => $this->user->role,
            ] : null),
        ];
    }
}
