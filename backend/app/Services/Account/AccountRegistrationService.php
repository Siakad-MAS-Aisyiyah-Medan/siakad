<?php

namespace App\Services\Account;

use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Registrasi akun (layer autentikasi) — TIDAK membuat data PPDB/pendaftaran.
 */
class AccountRegistrationService
{
    public const ROLE_CALON_SISWA = 'calon_siswa';

    public const STATUS_AKTIF = 'aktif';

    /**
     * Buat akun calon siswa di tabel users saja.
     *
     * @param  array{name: string, username: string, email: string, password: string}  $data
     */
    public function registerCalonSiswa(array $data): User
    {
        return DB::transaction(function () use ($data) {
            return User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => self::ROLE_CALON_SISWA,
                'status_aktif' => true,
                'status_akun' => self::STATUS_AKTIF,
            ]);
        });
    }
}
