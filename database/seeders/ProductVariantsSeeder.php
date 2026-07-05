<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\VariantAttribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVariantsSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // Get all products that have colors assigned via product_color pivot
            $products = Product::whereHas('colors')->get();

            foreach ($products as $product) {
                // Get colors assigned to this product
                $colors = $product->colors;

                foreach ($colors as $color) {
                    // Create variant for each color
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => $product->sku . '-' . strtoupper(str_replace(['#', ' '], ['', ''], $color->name)),
                        'price' => $product->supplierPrice->first()?->amount ?? $product->final_price ?? 0,
                        'stock' => rand(5, 50), // Default stock
                        'image' => null, // Use product's default image
                    ]);

                    // Add color attribute
                    VariantAttribute::create([
                        'product_variant_id' => $variant->id,
                        'attribute' => 'color',
                        'value' => $color->name,
                    ]);
                }
            }
        });
    }
}