<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Concerns\IndexFilterRules;
use Illuminate\Foundation\Http\FormRequest;

class IndexGuruRequest extends FormRequest
{
    use IndexFilterRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge($this->paginationRules(), [
            'role' => 'nullable|in:guru,wali_kelas',
        ]);
    }
}
