<?php

namespace App\Http\Requests\Concerns;

trait IndexFilterRules
{
    protected function paginationRules(int $maxPerPage = 100): array
    {
        return [
            'per_page' => 'nullable|integer|min:1|max:'.$maxPerPage,
            'page' => 'nullable|integer|min:1',
            'search' => 'nullable|string|max:100',
        ];
    }
}
