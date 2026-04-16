<?php

namespace App\Repository\Products;

use App\Models\Menu;
use App\Models\Product;
use App\Models\ProviderPricing;

class ProductSearchRepository
{
    public function search(array $data)
    {
        $products = Product::query();

        $products->where('is_published', Product::IS_PUBLISHED);
        // $productPricing = ProviderPricing::query();

        // if (isset($data['locations'])) { //search julies location coverage instead while doing meet our stylist
        //     $productPricing->whereIn('location_id', $data['locations']);
        // }

        if (isset($data['types'])) {
            $products->whereHas('productPrice', function ($query) use ($data) {
                return $query->whereIn('service_type', $data['types']);
            });
        }

        if (isset($data['rating'])) {
            $products->whereHas('productPrice.provider', function ($query) use ($data) {
                return $query->where('rating', $data['rating']);
            })->orWhereHas('supplierPrice.supplier', function ($query) use ($data) {
                return $query->where('rating', $data['rating']);
            });
        }

        if (isset($data['searchStr']) && $data['searchStr'] !== '') {
            $products->where(function ($query) use ($data) {
                $query->where('name', 'like', '%'.$data['searchStr'].'%')
                    ->orWhere('keywords', 'like', '%'.$data['searchStr'].'%')
                    ->orWhereHas('supplierPrice.supplier', function ($query) use ($data) {
                        return $query->where('name', 'like', '%'.$data['searchStr'].'%');
                    });
            });
        }

        if (isset($data['age_group'])) {
            $products->whereHas('ageGroups', function ($query) use ($data) {
                return $query->where('age_group_id', $data['age_group']);
            });
        }

        if (isset($data['menuId'])) {
            $menuIds = $this->getMenuChildIds($data['menuId']);
            $products->whereIn('menu_id', $menuIds);
        }

        // if (isset($data['pricing'])) {
        //     $products->whereBetween('amount', [$data['pricing']['start'], $data['pricing']['end']]);
        // }

        //try getting one product per search since prices are standardized.
        // dd($products->with(['category', 'attachments.media',  'discount'])
        // ->paginate(50));

        return $products->with(['category', 'attachments.media', 'discount', 'supplierPrice.unit']) // 'productPrice.location',
            ->paginate(50);
    }

    /**
     * get any menu under this menu
     *
     * @param int $menuId
     *
     * @return array
     */
    public function getMenuChildIds(int $menuId): array
    {
        $ids = [$menuId];
        $menus = Menu::where('id', $menuId)
            ->with(['children.children'])
            ->first();

        $menus->children->each(function ($menu) use (&$ids) {
            $ids= array_merge($ids, [
                $menu->id,
            ]);

            $menu->children->each(function ($child) use (&$ids) {
                $ids= array_merge($ids, [
                    $child->id,
                ]);
            });
        });

        return $ids;
    }
}
