<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\ValidationException;


class BulkUpdate implements  ToModel, WithHeadingRow
{
    private $requiredHeaders = ['id', 'slug', 'keywords', 'seo_title', 'seo_description'];

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $this->validateHeaders(array_keys($row));

        
        Product::where('id', $row['id'])
            ->where('slug', $row['slug'])
            ->update([
                'keywords' => $row['keywords'],
                'seo_title' => $row['seo_title'],
                'seo_description' => $row['seo_description'],
            ]
        );
    }

    /**
     * Validate that all required headers exist in the Excel file.
     *
     * @param array $actualHeaders
     * @throws ValidationException
     */
    private function validateHeaders(array $actualHeaders)
    {
        $missingHeaders = array_diff($this->requiredHeaders, $actualHeaders);

        if (!empty($missingHeaders)) {
            throw ValidationException::withMessages([
                'headers' => 'Missing headers: ' . implode(', ', $missingHeaders),
            ]);
        }
    }
}
