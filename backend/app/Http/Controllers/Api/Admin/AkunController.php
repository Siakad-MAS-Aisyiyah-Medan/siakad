<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AkunController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::select('id_user', 'username', 'role', 'status_akun', 'status_aktif', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id_user,
                    'username' => $user->username,
                    'role' => $user->role,
                    'status' => $user->status_akun ?? ($user->status_aktif ? 'aktif' : 'nonaktif'),
                ];
            });

        $activeRoles = count(User::ROLES);

        return response()->json([
            'success' => true,
            'data' => [
                'users' => $users,
                'total_akun' => $users->count(),
                'role_aktif' => $activeRoles,
            ],
        ]);
    }

    public function store(\Illuminate\Http\Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:' . implode(',', User::ROLES),
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => $validated['role'],
            'status_aktif' => true,
            'status_akun' => 'aktif',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil ditambahkan',
            'data' => $user
        ], 201);
    }
}
