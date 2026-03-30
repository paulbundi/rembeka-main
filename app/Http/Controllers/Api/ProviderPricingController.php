<?php

namespace App\Http\Controllers\Api;

use App\Models\Provider;
use App\Models\ProviderPricing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProviderPricingController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return ProviderPricing::class;
    }

    /**
     * Get a new query instance.
     *
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        return $this->model->newQuery()
            ->whereHas('provider', function ($query) {
                $query->where('status', Provider::STATUS_ACTIVE);
            });
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'product', 'location', 'category', 'provider', 'product.discount',
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postStore(Request $request)
    {
        $this->model->amount = ceil($request->service_pricing / 10) * 10;
        $this->model->provider_cost = $request->cost_of_labour * ((100 - $request->commission)/100);
        $this->model->save();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function preUpdate(Request $request, $modelId)
    {
        $this->model->amount = ceil($request->service_pricing / 10) * 10;
        $this->model->provider_cost = $request->cost_of_labour * ((100 - $request->commission)/100);
    }
}
