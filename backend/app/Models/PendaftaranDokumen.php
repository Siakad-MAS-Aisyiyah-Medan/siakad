<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendaftaranDokumen extends Model
{
    protected $table = 'pendaftaran_dokumen';

    protected $fillable = [
        'pendaftaran_id',
        'foto_copy_ijazah',
        'stk_asli',
        'pas_foto',
        'nisn_dokumen',
        'fc_kartu_keluarga',
        'fc_ktp_orang_tua',
        'catatan_tambahan',
    ];

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id', 'id_pendaftaran');
    }
}
