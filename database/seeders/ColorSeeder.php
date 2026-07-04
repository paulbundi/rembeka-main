<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            '1#', '1B', '2#', '4#', '27#', '30#', '350', '613', 
            'B29', 'BUG', 'C14', 'C15', 'DSL WINE', 'T27', 'T27-613', 
            'T30', 'T33', 'T350', 'TBURG'
        ];

        foreach ($colors as $colorName) {
            Color::firstOrCreate(
                ['name' => $colorName],
                ['slug' => strtolower(str_replace([' ', '#'], ['', '-'], $colorName))]
            );
        }
    }
}