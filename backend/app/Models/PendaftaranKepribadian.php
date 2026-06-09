<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendaftaranKepribadian extends Model
{
    protected $table = 'pendaftaran_kepribadian';

    protected $fillable = [
        'pendaftaran_id',
        'hobi',
        'cita_cita',
    ];

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id', 'id_pendaftaran');
    }
}
