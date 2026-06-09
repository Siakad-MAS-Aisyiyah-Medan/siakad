<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterCalonSiswaRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    /** @deprecated Gunakan registerCalonSiswa — alias kompatibilitas */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = $this->authService->registerCalonSiswa([
            'name' => $data['nama'],
            'email' => $data['email'],
            'username' => $data['nisn'],
            'password' => $data['password'],
        ]);

        return ApiResponse::success(
            (new UserResource($user))->resolve(),
            'Akun berhasil dibuat. Login lalu mulai formulir PPDB dari dashboard jika ingin mendaftar.',
            201
        );
    }

    /**
     * Registrasi akun saja (tabel users). Tidak membuat draft pendaftaran PPDB.
     */
    public function registerCalonSiswa(RegisterCalonSiswaRequest $request)
    {
        $user = $this->authService->registerCalonSiswa($request->validated());

        return ApiResponse::success(
            [
                'user' => (new UserResource($user))->resolve(),
                'next_steps' => [
                    'login' => '/login-calon-murid',
                    'dashboard' => '/calon-murid/dashboard',
                    'start_ppdb' => 'POST /api/ppdb/start (setelah login, opsional)',
                ],
            ],
            'Akun berhasil dibuat. Login untuk mengakses dashboard. Data PPDB dibuat saat Anda memulai formulir pendaftaran.',
            201
        );
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login(
            $request->validated('login'),
            $request->validated('password')
        );

        if (isset($result['error'])) {
            return ApiResponse::error($result['error'], $result['code']);
        }

        return ApiResponse::success($result['data'], 'Login Berhasil');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return ApiResponse::success(null, 'Logout berhasil');
    }

    public function me(Request $request)
    {
        $user = $request->user();
        $user->loadProfileRelations();

        return ApiResponse::success([
            'user' => (new UserResource($user))->resolve(),
            'profile' => $user->resolveProfile(),
            'permissions' => app(\App\Services\PermissionService::class)->permissionsForUser($user),
            'menus' => app(\App\Services\PermissionService::class)->menusForUser($user),
        ]);
    }
}
