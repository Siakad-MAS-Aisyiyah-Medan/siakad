<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Concerns\IndexFilterRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexPpdbRequest extends FormRequest
{
    use IndexFilterRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge($this->paginationRules(), [
            'status' => ['nullable', Rule::in([
                'draft', 'diajukan', 'revisi', 'terverifikasi', 'diterima', 'ditolak', 'daftar_ulang', 'menjadi_murid',
            ])],
        ]);
    }
}
