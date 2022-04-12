<?php

namespace App\Imports;

use App\Models\Products;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function __construct($company_id)
    {
        $this->company_id = $company_id;
    }
    public function model(array $row)
    {
        return new Products([
            'product_code' => $row['product_code'],
            'gtin' => $row['gtin'],
            'product_name' => $row['product_name'],
            'description' => $row['description'],
            'brand' => $row['brand'],
            'size' => $row['size'],
            'company_id'=> $this->company_id,
        ]);
    }
}
