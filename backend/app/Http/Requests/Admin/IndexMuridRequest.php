<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Concerns\IndexFilterRules;
use Illuminate\Foundation\Http\FormRequest;

class IndexMuridRequest extends FormRequest
{
    use IndexFilterRules;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->paginationRules();
    }
}
