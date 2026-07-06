<?php

namespace App\Http\Controllers\Api;

use App\Models\Color;
use Illuminate\Database\Eloquent\Builder;

class ColorController extends AbstractApiController
{
    protected function getModel(): string
    {
        return Color::class;
    }

    protected function newQuery(): Builder
    {
        $this->resolveModel();
        return $this->model->newQuery()->orderBy('name');
    }

    protected function getAllowedIncludes(): array
    {
        return [];
    }
}