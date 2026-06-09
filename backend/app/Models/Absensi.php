<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $primaryKey = 'id_absensi';

    public const STATUS_HADIR = 'H';

    public const STATUS_ALPA = 'A';

    public const STATUS_IZIN = 'I';

    public const STATUS_SAKIT = 'S';

    public const STATUS_TERLAMBAT = 'T';

    public static function statusLabels(): array
    {
        return [
            self::STATUS_HADIR => 'Hadir',
            self::STATUS_SAKIT => 'Sakit',
            self::STATUS_IZIN => 'Izin',
            self::STATUS_ALPA => 'Alpa',
            self::STATUS_TERLAMBAT => 'Terlambat',
        ];
    }

    protected $fillable = [
        'id_user_siswa',
        'id_kelas',
        'id_mapel',
        'id_jadwal',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status',
        'id_guru_pencatat',
        'tahun_ajaran',
        'semester',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'id_user_siswa', 'id_user');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalPelajaran::class, 'id_jadwal', 'id_jadwal');
    }

    public function guruPencatat()
    {
        return $this->belongsTo(User::class, 'id_guru_pencatat', 'id_user');
    }
}
