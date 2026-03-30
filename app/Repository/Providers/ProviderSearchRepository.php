<?php

namespace App\Repository\Providers;

use App\Models\Location;
use App\Models\ProviderPricing;

class ProviderSearchRepository
{
    /**
     * Product Search.
     *
     * @param  $product
     *
     * @return void
     */
    public function search($productId, $data)
    {
        $query = ProviderPricing::query();

        $query->where('product_id', $productId);

        if (isset($data['locations'])) {
            $stylistLocations = $this->getLocationIds($data['locations']);
            $query->whereIn('location_id', $stylistLocations);
        }

        return $query->with(['provider.profile.attachments.media'])->paginate();
    }

    /**
     * get related location ids
     *
     * @param int $location
     *
     * @return array
     */
    public function getLocationIds($locationId)
    {
        $location =  Location::with('parent.parent')->findOrFail($locationId);//TODO Please use cache to check for this.

        if ($location->parent_id != null && $location->parent->parent_id == null) {
            $locationIZone = Location::where('parent_id', $location->parent->id)->get('id');
        } elseif ($location->parent_id != null && $location->parent->parent_id != null && $location->parent->parent->parent_id == null) {
            $locationIZone = Location::where('parent_id', $location->parent->parent->id)->get('id');
        } else {
            $locationIZone = Location::where('parent_id', $locationId)
                ->orWhere('id', $locationId)
                ->get('id');
        }

        $ids = [];

        $locationIZone->each(function ($item) use (&$ids) {
            $ids = array_merge($ids, [
                $item->id,
            ]);
        });

        return $ids;
    }
}
