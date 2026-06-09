<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ekskul extends Model
{
    protected $table = 'ekstrakurikuler';

    protected $primaryKey = 'id_ekskul';

    protected $fillable = [
        'nama_ekskul',
        'deskripsi',
        'id_pembina',
        'hari',
        'jam',
        'lokasi',
    ];

    public function pembina()
    {
        return $this->belongsTo(User::class, 'id_pembina', 'id_user');
    }
}
