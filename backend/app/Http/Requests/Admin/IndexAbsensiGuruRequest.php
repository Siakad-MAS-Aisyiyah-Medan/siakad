<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Concerns\IndexFilterRules;
use Illuminate\Foundation\Http\FormRequest;

class IndexAbsensiGuruRequest extends FormRequest
{
    use IndexFilterRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge($this->paginationRules(), [
            'id_user_guru' => 'nullable|exists:users,id_user',
            'tanggal_dari' => 'nullable|date',
            'tanggal_sampai' => 'nullable|date|after_or_equal:tanggal_dari',
            'semester' => 'nullable|in:Ganjil,Genap',
            'tahun_ajaran' => 'nullable|string|max:20',
        ]);
    }
}
