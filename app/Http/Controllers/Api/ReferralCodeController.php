<?php

namespace App\Http\Controllers\Api;

use App\Models\Referralcode;
use Illuminate\Database\Eloquent\Builder;

class ReferralCodeController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Referralcode::class;
    }


    /**
     * Get a new query instance.
     *
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        return $this->model->newQuery()
            ->where('status', Referralcode::STATUS_ACTIVE);
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'user',
        ];
    }
}
