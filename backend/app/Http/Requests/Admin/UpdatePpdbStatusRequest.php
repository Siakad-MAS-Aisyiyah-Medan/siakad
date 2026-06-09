<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePpdbStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:terverifikasi,revisi,diterima,ditolak',
            'catatan_admin' => 'nullable|string|max:2000',
        ];
    }
}
