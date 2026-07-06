<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Business shade codes for the beauty/hair industry.
     * These are inventory codes that customers recognize by label.
     * Some have visual swatches (hex_code), others are text-only pills.
     */
    public function run(): void
    {
        $colors = [
            // Named colors with visual swatches
            ['name' => 'Purple', 'hex_code' => '#7E57C2', 'display_type' => 'swatch'],
            ['name' => 'Wine', 'hex_code' => '#722F37', 'display_type' => 'swatch'],
            ['name' => 'Burgundy', 'hex_code' => '#800020', 'display_type' => 'swatch'],
            ['name' => 'Red', 'hex_code' => '#E53935', 'display_type' => 'swatch'],
            ['name' => 'Blue', 'hex_code' => '#1E88E5', 'display_type' => 'swatch'],
            ['name' => 'Green', 'hex_code' => '#43A047', 'display_type' => 'swatch'],

            // Business codes - text-only pills (customers know these by code)
            ['name' => '1', 'hex_code' => null, 'display_type' => 'pill'],
            ['name' => '1B', 'hex_code' => null, 'display_type' => 'pill'],
            ['name' => '2', 'hex_code' => null, 'display_type' => 'pill'],
            ['name' => '4', 'hex_code' => null, 'display_type' => 'pill'],
            ['name' => '27', 'hex_code' => null, 'display_type' => 'pill'],
            ['name' => '30', 'hex_code' => null, 'display_type' => 'pill'],
            ['name' => '33', 'hex_code' => null, 'display_type' => 'pill'],
            ['name' => '350', 'hex_code' => null, 'display_type' => 'pill'],
            ['name' => '613', 'hex_code' => null, 'display_type' => 'pill'],
            ['name' => '99J', 'hex_code' => null, 'display_type' => 'pill'],
            ['name' => 'T1B/30', 'hex_code' => null, 'display_type' => 'pill'],
            ['name' => 'T1B/27', 'hex_code' => null, 'display_type' => 'pill'],
        ];

        foreach ($colors as $colorData) {
            Color::firstOrCreate(
                ['name' => $colorData['name']],
                [
                    'slug' => strtolower(str_replace([' ', '/', '#'], ['-', '-', ''], $colorData['name'])),
                    'hex_code' => $colorData['hex_code'],
                    'display_type' => $colorData['display_type'],
                ]
            );
        }
    }
}