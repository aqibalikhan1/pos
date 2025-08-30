<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Company;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;

class ProductImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Handle category_id - if it's a name, find or create the category
        $categoryId = $this->getCategoryId($row);
        
        // Handle company_id - if it's a name, find or create the company
        $companyId = $this->getCompanyId($row);

        return new Product([
            'name' => $row['name'],
            'sku' => $row['sku'],
            'description' => $row['description'] ?? null,
            'company_id' => $companyId,
            'category_id' => $categoryId,
            'purchase_price' => $row['purchase_price'],
            'trade_price' => $row['trade_price'],
            'print_price' => $row['print_price'],
            'wholesale_price' => $row['wholesale_price'],
            'stock_quantity' => $row['stock_quantity'] ?? 0,
            'min_stock_level' => $row['min_stock_level'] ?? 0,
            'barcode' => $row['barcode'] ?? null,
            'unit' => $row['unit'] ?? 'pcs',
            'pieces_per_pack' => $row['pieces_per_pack'] ?? 1,
            'packaging_type' => $row['packaging_type'] ?? 'pack',
            'is_active' => isset($row['is_active']) ? (bool)$row['is_active'] : true,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'purchase_price' => 'required|numeric|min:0',
            'trade_price' => 'required|numeric|min:0',
            'print_price' => 'required|numeric|min:0',
            'wholesale_price' => 'required|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'min_stock_level' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:20',
            'pieces_per_pack' => 'nullable|integer|min:1',
            'packaging_type' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
        ];
    }

    private function getCategoryId(array $row)
    {
        if (is_numeric($row['category_id'])) {
            return $row['category_id'];
        }

        // If it's a category name, find or create
        $category = Category::firstOrCreate(
            ['name' => $row['category_id']],
            ['is_active' => true]
        );

        return $category->id;
    }

    private function getCompanyId(array $row)
    {
        if (is_numeric($row['company_id'])) {
            return $row['company_id'];
        }

        // If it's a company name, find or create
        $company = Company::firstOrCreate(
            ['name' => $row['company_id']],
            ['is_active' => true]
        );

        return $company->id;
    }
}
