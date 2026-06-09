<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiGuru extends Model
{
    protected $table = 'absensi_guru';

    protected $primaryKey = 'id_absensi_guru';

    protected $fillable = [
        'id_user_guru',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
        'keterangan',
        'tahun_ajaran',
        'semester',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'id_user_guru', 'id_user');
    }
}
