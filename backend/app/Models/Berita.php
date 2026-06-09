<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'beritas';

    protected $fillable = [
        'judul',
        'isi',
        'kategori',
        'gambar',
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
