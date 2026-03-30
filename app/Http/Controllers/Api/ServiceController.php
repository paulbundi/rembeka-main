<?php

namespace App\Http\Controllers\Api;

use App\Models\Attachment;
use App\Models\Product;
use App\Models\ProviderPricing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ServiceController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Product::class;
    }

    /**
     * Get a new query instance.
     *
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        return $this->model->newQuery()
            ->where('type', Product::TYPE_SERVICE);
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'users', 'attachments', 'attachments.media', 'menu', 'ageGroups',
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postStore(FormRequest $request)
    {
        $this->model->slug = Str::slug($request->name.'-'.$this->model->id);
        $this->model->platform_fee = Product::PLATFORM_FEE;
        $this->model->provider_cost = $request->cost_of_labour * ((100 - $request->commission)/100);
        $this->model->save();

        $ages =  $request->get('age_groups');
        if ($this->model->wasRecentlyCreated && isset($ages)) {
            $this->model->ageGroups()->sync($ages);
        }
    }

    /**
     * @param Request $request
     * @param [type]  $modelId
     *
     * @return void
     */
    public function postUpdate(Request $request, $modelId)
    {
        $this->model->provider_cost = $request->cost_of_labour * ((100 - $this->model->commission)/100);
        $this->model->final_price = (ceil($this->model->product_price / 10) * 10);
        $this->model->save();

        if ($request->get('update_provider_pricing')) {
            ProviderPricing::where('product_id', $modelId)
                ->update([
                    'cost_of_labour' => $this->model->cost_of_labour,
                    'commission' => $this->model->commission,
                    'provider_cost' => $this->model->provider_cost,
                    'service_pricing' => $this->model->product_price,
                    'amount' => (ceil($this->model->product_price / 10) * 10),
                ]);
        }
    }

    /**
     * Attaches the given many to many relations.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $id
     * @param string                   $relationName
     *
     * @return \Illuminate\Http\Response
     */
    public function attachMorphRelations(Request $request, $id, $relationName)
    {
        $this->model = $this->model->findOrFail($id);
        if (! method_exists($this->model, $relationName)) {
            throw new BadRequestHttpException('relation doesnt exist', null, 400);
        }

        $ids = $request->input('data', []);
        foreach ($ids as $mediaId) {
            Attachment::create([
                'user_id' => auth()->id(),
                'attachable_id' => $this->model->id,
                'attachable_type' => 'App\Models\Product',
                'media_id' => $mediaId,
            ]);
        }

        return response()->json();
    }

    /**
     * Dettache the given many to many relations.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $id
     * @param string                   $relationName
     *
     * @return \Illuminate\Http\Response
     */
    public function dettachMorphRelations(Request $request, $id, $relationName)
    {
        $this->model = $this->model->findOrFail($id);
        if (! method_exists($this->model, $relationName)) {
            throw new BadRequestHttpException('relation doesnt exist', null, 400);
        }

        $ids = $request->input('data', []);
        foreach ($ids as $attachementId) {
            Attachment::where('id', $attachementId)->delete();
        }

        return response()->json();
    }
}
