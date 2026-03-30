<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class RoleController extends AbstractApiController
{
    /**
     * Get a new query instance.
     *
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        if (auth()->user() && auth()->user()->organization_id) {
            return $this->model->newQuery()
                ->where('organization_id', auth()->user()->organization_id);
        }

        if (auth()->user() && auth()->user()->roles->first()->id != 1) {
            return $this->model->newQuery()->where('id', '!=', 1);
        }

        return $this->model->newQuery();
    }

    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Role::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'users',
        ];
    }

    /**
     * Get available system permissions.
     *
     * @return JsonResponse
     */
    public function getPermissions(): JsonResponse
    {
        return response()->json(Role::getPermissions());
    }
}
