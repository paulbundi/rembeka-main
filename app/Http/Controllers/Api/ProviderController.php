<?php

namespace App\Http\Controllers\Api;

use App\Models\Attachment;
use App\Models\Menu;
use App\Models\Provider;
use App\Models\ProviderPricing;
use App\Models\ProviderProfile;
use Illuminate\Http\Request;

class ProviderController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Provider::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'products', 'productPricings.product', 'locations',
            'profile.attachments.media', 'orders', 'user',
        ];
    }

    /**
     * @param Request $request
     *
     * @return void
     */
    public function postStore(Request $request)
    {
        $profile = $this->getProviderProfile($request);

        if ($request->get('profile_image')) {
            $this->providerImage($request, $profile);
        }

        if ($request->get('provider_styles')) { // dublicate existing details for this service.
            foreach ($request->get('provider_styles') as $style) {
                if (ProviderPricing::where('product_id', $style)
                    ->where('provider_id', $this->model->id)
                    ->exists()) {
                    return;
                }
                $productPricing = ProviderPricing::where('product_id', $style)->first();

                if ($productPricing) {
                    ProviderPricing::create([
                        'product_id' => $productPricing->product_id,
                        'category_id' => $productPricing->category_id ,
                        'provider_id' => $this->model->id,
                        'location_id' => $request->get('location_id')[0], //TODO redefine zoning and pricing.
                        'amount' => $productPricing->amount,
                        'status' => ProviderPricing::STATUS_ACTIVE,
                    ]);
                }
            }
        }


        if ($request->get('location_id')) {
            $this->model->locations()->attach($request->get('location_id'));
        }
    }

    /**
     * Get Provider profile.
     *
     * @param Request $request
     *
     * @return ProviderProfile
     */
    public function getProviderProfile(Request $request): ProviderProfile
    {
        $profile = ProviderProfile::where('provider_id', $this->model->id)->first();

        if ($profile == null || $this->model->wasRecentlyCreated) {
            $profile = ProviderProfile::create([
                'professional_qualifications' => $request->get('professional_qualifications'),
                'works_experience' => $request->get('works_experience'),
                'provider_id' => $this->model->id,
            ]);
        } else {
            $profile->professional_qualifications = $request->get('professional_qualifications');
            $profile->works_experience = $request->get('works_experience');
            $profile->save();
        }

        return $profile;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($modelId)
    {
        $request = $this->getRequest();

        $this->model = $this->model->findOrFail($modelId);

        $this->model->fill($request->only(array_keys($request->rules())));
        $this->model->save();

        if (isset($request->assign_service_by) &&  $request->assign_service_by == '1') {
            $this->assignProductsByMenu($request->get('provider_styles'));
        }

        if ($request->get('location_id')) {
            $this->model->locations()->attach($request->get('location_id'));
        }

        if ($request->get('profile_image')) {
            $profile = $this->getProviderProfile($request);
            $this->providerImage($request, $profile);
        }

        return $this->getModelResource($this->model);
    }

    /**
     * update provider Image
     *
     * @param [type] $request
     * @param [type] $profile
     *
     * @return void
     */
    public function providerImage($request, $profile)
    {
        Attachment::updateOrCreate([
            'attachable_id' => $profile->id,
            'attachable_type' => 'App\Models\ProviderProfile',
        ], [
        'user_id' => auth()->id(),
        'media_id' => $request->get('profile_image'),
        ]);
    }

    /**
     * Assign Products by selected menu
     *
     * @param  $menus
     *
     * @return void
     */
    public function assignProductsByMenu($menus)
    {
        foreach ($menus as $menu) {
            $selectedIds = [];
            array_push($selectedIds, $menu);
            $menus = Menu::with(['children.children'])
                ->where('id', $menu)->first();
            $menus->children->each(function ($menu) use (&$selectedIds) {
                array_push($selectedIds, $menu->id);
                $menu->children->each(function ($child) use (&$selectedIds) {
                    array_push($selectedIds, $child->id);
                });
            });
        }

        foreach ($selectedIds as $menuId) {
            if (ProviderPricing::whereHas('product', function ($query) use ($menuId) {
                $query->where('menu_id', $menuId);
            })
                ->where('provider_id', $this->model->id)
                ->exists()) {
                return;
            }
            $productPricing = ProviderPricing::whereHas('product', function ($query) use ($menuId) {
                $query->where('menu_id', $menuId);
            })->first();

            if ($productPricing) {
                ProviderPricing::create([
                    'product_id' => $productPricing->product_id,
                    'category_id' => $productPricing->category_id ,
                    'provider_id' => $this->model->id,
                    'location_id' => 1,
                    'amount' => $productPricing->amount,
                    'status' => ProviderPricing::STATUS_ACTIVE,
                ]);
            }
        }
    }
}
