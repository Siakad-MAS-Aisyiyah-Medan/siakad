<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (!$this->has('login')) {
            if ($this->filled('username')) {
                $this->merge(['login' => $this->input('username')]);
            } elseif ($this->filled('email')) {
                $this->merge(['login' => $this->input('email')]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'login' => 'required|string|max:255',
            'password' => 'required|string',
            'username' => 'sometimes|string|max:255',
        ];
    }
}
