<?php

namespace App\Imports;

use App\Models\Menu;
use App\Models\Product;
use App\Models\ProviderPricing;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
     * @var currentMenu.
     */
    protected $currentMenu;

    /**
     * @var currentMenu.
     */
    protected $childMenu;

    /**
     * default provider
     *
     * @var int
     */
    protected $providerId;

    /**
     * Initialize class.
     *
     * @param int $schoolId
     */
    public function __construct(int $providerId)
    {
        $this->providerId = $providerId;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $this->mainMenu($row);

        $product = Product::create([
            'type' => Product::TYPE_SERVICE,
            'name' => $row['styles'],
            'sku' => rand(1, 200000),
            'menu_id' => $this->childMenu->id,
            'product_used' => $row['products_used'],
            'duration_of_style' => $row['duration_of_styling'],
            'durability' => $row['durability'],
            'cost_of_labour' => $row['cost_of_labour'],
            'provider_cost' => $row['provider_cost'],
            'commission' => 30, // $row['commission'],
            'platform_fee' => $row['platform_fee'],
        ]);
        // dd($product);
        $product->ageGroups()->sync($this->ageGroups($row));

        ProviderPricing::create([
            'product_id' => $product->id,
            'category_id' => 1,
            'provider_id' => $this->providerId,
            'location_id' => 1,
            'commission' => 30, //$row['commission'],
            'service_pricing' => $row['service_pricing'],
            'amount' => $row['final_cost_on_e_commerce'],
            'status' => 1,
        ]);

        // dd($row);
    }

    protected function mainMenu($row)
    {
        if ($row['main_menu'] && ($this->currentMenu == null ||  $row['main_menu'] != $this->currentMenu->name)) {
            $this->currentMenu = Menu::firstOrCreate([
                'name' => $row['main_menu'],
            ]);

            $this->childMenu = Menu::firstOrCreate([
                'name' => $row['sub_categories'],
                'parent_id' => $this->currentMenu->id,
            ]);

            return;
        }

        if ($row['sub_categories'] != null && $this->childMenu->name != $row['sub_categories']) {
            $this->childMenu = Menu::firstOrCreate([
                'name' => $row['sub_categories'],
                'parent_id' => $this->currentMenu->id,
            ]);
        }
    }

    /**
     * Age Groups.
     *
     * @return void
     */
    public function ageGroups($row)
    {
        return ['1', '2', '3'];
    }
}
