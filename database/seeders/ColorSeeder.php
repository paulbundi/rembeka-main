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
            '1#', '1B', '2#', '4#', '27#', '30#', '350', '613',
            'B29', 'BUG', 'C14', 'C15', 'D&L WINE', 'T27', 'T27-613',
            'T30', 'T33', 'T350', 'TBURG',
        ];

        foreach ($colors as $name) {
            Color::firstOrCreate(
                ['name' => $name],
                [
                    'slug' => strtolower(str_replace([' ', '/', '#', '&'], ['-', '-', '', ''], $name)),
                    'hex_code' => null,
                    'display_type' => 'pill',
                ]
            );
        }
    }
}