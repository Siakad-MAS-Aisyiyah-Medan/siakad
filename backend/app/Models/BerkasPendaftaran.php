<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasPendaftaran extends Model
{
    protected $table = 'berkas_pendaftarans';

    protected $fillable = [
        'pendaftaran_id',
        'jenis_berkas',
        'file_path',
        'status_verifikasi',
        'catatan',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id', 'id_pendaftaran');
    }
}
