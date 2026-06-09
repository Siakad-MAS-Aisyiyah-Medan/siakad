<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumumen';

    protected $fillable = [
        'judul',
        'isi',
        'tanggal_publikasi',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_publikasi' => 'date',
            'is_published' => 'boolean',
        ];
    }
}
