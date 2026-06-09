<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Concerns\IndexFilterRules;
use Illuminate\Foundation\Http\FormRequest;

class IndexAuditLogRequest extends FormRequest
{
    use IndexFilterRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge($this->paginationRules(50), [
            'action' => 'nullable|string|max:120',
        ]);
    }
}
