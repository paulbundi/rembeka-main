<?php

namespace App\Http\Controllers\Api;

use App\Models\ExpenseType;
use Illuminate\Database\Eloquent\Builder;

class ExpenseTypeController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return ExpenseType::class;
    }

    /**
     * Get a new query instance.
     *
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'users', 'children', 'children.children', 'children.children.children',
            'children.children.children.children'
        ];
    }
}
