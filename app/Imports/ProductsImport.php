<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            $variant = [
                [
                    'size' => $row['min_order_quantity'] ?? 1,
                    'unit' => 'kg',
                    'price' => $row['base_price'],
                    'stock' => $row['stock_quantity']
                ]
            ];
            return new Product([
                'name' => $row['name'],
                'slug' => Str::slug($row['name']),
                'category_id' => $row['category_id'],
                'description' => $row['description'],
                'sku' => $row['sku'],
                'base_price' => $row['base_price'],
                'stock_quantity' => $row['stock_quantity'],
                'min_order_quantity' => $row['min_order_quantity'] ?? 1,
                'variants' => json_encode($variant),  // Add encoded variants
                'is_active' => true
            ]);
        } catch (\Exception $e) {
            Log::error('Import error:', ['message' => $e->getMessage()]);
            throw $e;
        }
    }
    
}
