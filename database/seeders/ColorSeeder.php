<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            ['name' => '1#', 'hex_code' => '#F5E6A8', 'display_type' => 'swatch'],
            ['name' => '1B', 'hex_code' => null, 'display_type' => 'pill'],
            ['name' => '2#', 'hex_code' => '#E8D58A', 'display_type' => 'swatch'],
            ['name' => '4#', 'hex_code' => '#F2E8C9', 'display_type' => 'swatch'],
            ['name' => '27#', 'hex_code' => '#D4B483', 'display_type' => 'swatch'],
            ['name' => '30#', 'hex_code' => '#C9A66B', 'display_type' => 'swatch'],
            ['name' => '350', 'hex_code' => '#B8860B', 'display_type' => 'swatch'],
            ['name' => '613', 'hex_code' => '#F5DEB3', 'display_type' => 'swatch'],
            ['name' => 'B29', 'hex_code' => '#8B4513', 'display_type' => 'swatch'],
            ['name' => 'BUG', 'hex_code' => '#8B0000', 'display_type' => 'swatch'],
            ['name' => 'C14', 'hex_code' => '#A0522D', 'display_type' => 'swatch'],
            ['name' => 'C15', 'hex_code' => '#A52A2A', 'display_type' => 'swatch'],
            ['name' => 'DSL WINE', 'hex_code' => '#800080', 'display_type' => 'swatch'],
            ['name' => 'T27', 'hex_code' => '#D2691E', 'display_type' => 'swatch'],
            ['name' => 'T27-613', 'hex_code' => '#DAA520', 'display_type' => 'swatch'],
            ['name' => 'T30', 'hex_code' => '#CD853F', 'display_type' => 'swatch'],
            ['name' => 'T33', 'hex_code' => '#8B4513', 'display_type' => 'swatch'],
            ['name' => 'T350', 'hex_code' => '#B8860B', 'display_type' => 'swatch'],
            ['name' => 'TBURG', 'hex_code' => '#800000', 'display_type' => 'swatch'],
        ];

        foreach ($colors as $colorData) {
            Color::firstOrCreate(
                ['name' => $colorData['name']],
                [
                    'slug' => strtolower(str_replace([' ', '#'], ['', '-'], $colorData['name'])),
                    'hex_code' => $colorData['hex_code'],
                    'display_type' => $colorData['display_type'],
                ]
            );
        }
    }
}