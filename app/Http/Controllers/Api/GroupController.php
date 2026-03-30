<?php

namespace App\Http\Controllers\Api;

use App\Jobs\GroupFromSale;
use App\Models\Group;

class GroupController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Group::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'users', 'user'
        ];
    }


    /**
     * Refresh Group Memberships
     *
     * @param int $groupId
     * @return void
     */
    public function refreshMembers($groupId)
    {

        $group = Group::find($groupId);

        dispatch(new GroupFromSale($group));

        return response()->json([]);
    }
}
