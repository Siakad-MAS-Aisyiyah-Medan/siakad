<?php

namespace App\Http\Requests\PPDB;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCalonMuridRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required_without:nama|string|max:255',
            'nama' => 'required_without:nama_lengkap|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'nisn' => 'required|string|max:20|unique:users,username',
            'no_hp' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
