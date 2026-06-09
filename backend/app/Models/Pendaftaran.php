<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $primaryKey = 'id_pendaftaran';

    protected $fillable = [
        'id_user',
        'nomor_pendaftaran',
        'no_registrasi',
        'tahun_pelajaran',
        'status_pendaftaran',
        'current_step',
        'submitted_at',
        'verified_at',
        'accepted_at',
        'catatan_admin',
        'ppdb_status',
        'status_kelulusan',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'verified_at' => 'datetime',
            'accepted_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function berkas()
    {
        return $this->hasMany(BerkasPendaftaran::class, 'pendaftaran_id', 'id_pendaftaran');
    }

    public function keteranganPribadi(): HasOne
    {
        return $this->hasOne(PendaftaranKeteranganPribadi::class, 'pendaftaran_id', 'id_pendaftaran');
    }

    public function kesehatan(): HasOne
    {
        return $this->hasOne(PendaftaranKesehatan::class, 'pendaftaran_id', 'id_pendaftaran');
    }

    public function pendidikanAsal(): HasOne
    {
        return $this->hasOne(PendaftaranPendidikanAsal::class, 'pendaftaran_id', 'id_pendaftaran');
    }

    public function orangTuaWali(): HasOne
    {
        return $this->hasOne(PendaftaranOrangTuaWali::class, 'pendaftaran_id', 'id_pendaftaran');
    }

    public function kepribadian(): HasOne
    {
        return $this->hasOne(PendaftaranKepribadian::class, 'pendaftaran_id', 'id_pendaftaran');
    }

    public function dokumen(): HasOne
    {
        return $this->hasOne(PendaftaranDokumen::class, 'pendaftaran_id', 'id_pendaftaran');
    }

    public function getStatusAttribute(): string
    {
        return $this->status_pendaftaran ?? $this->ppdb_status ?? 'draft';
    }

    public function isEditable(): bool
    {
        $status = $this->status_pendaftaran ?? $this->ppdb_status ?? 'draft';
        if (in_array($status, ['draft', 'revision', 'revisi'], true)) {
            return true;
        }

        return false;
    }
}
