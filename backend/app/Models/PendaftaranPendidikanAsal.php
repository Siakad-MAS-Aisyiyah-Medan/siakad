<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendaftaranPendidikanAsal extends Model
{
    protected $table = 'pendaftaran_pendidikan_asal';

    protected $fillable = [
        'pendaftaran_id',
        'sekolah_asal',
        'no_sttb',
        'pindahan_dari',
        'no_surat_pindah',
    ];

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id', 'id_pendaftaran');
    }
}
