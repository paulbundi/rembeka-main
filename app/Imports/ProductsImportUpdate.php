<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImportUpdate implements ToModel, WithHeadingRow
{
    /**
     * Initialize class.
     *
     * @param int $schoolId
     */
    public function __construct()
    {
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        Product::where('id', $row['id'])
            ->where('menu_id', $row['menu_id'])// necessary to protect against editing id column
            ->update([
                'name' => $row['name'],
                'product_used' => $row['product_used'],
                'duration_of_style' => $row['duration_of_style'],
                'durability' => $row['durability'],
                'cost_of_labour' => $row['cost_of_labour'],
                'provider_cost' => $row['provider_cost'],
                'commission' => $row['commission'],
                'platform_fee' => $row['platform_fee'],
                'description' => $row['description'],
                'keywords' => $row['keywords'],
                'seo_title' => $row['seo_title'],
                'seo_description' => $row['seo_description'],
                'product_price'=> $row['product_price'],
                'final_price' => (ceil($row['product_price'] / 10) * 10),
            ]);
    }
}
