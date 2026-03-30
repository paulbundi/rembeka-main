<?php

namespace App\Observers;

use App\Jobs\GroupFromSale;
use App\Models\Group;

class GroupObserver
{
    public function created(Group $group)
    {
        if ($group->product_id) {
            dispatch(new GroupFromSale($group));
        }
    }
}
