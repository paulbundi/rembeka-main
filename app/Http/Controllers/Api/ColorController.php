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

    protected function getAllowedIncludes(): array
    {
        return [];
    }
}