<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::select([
            'name', 'category_id', 'description', 'sku',
            'base_price', 'stock_quantity', 'min_order_quantity'
        ])->get();
    }

    public function headings(): array
    {
        return [
            'Name', 'Category ID', 'Description', 'SKU',
            'Base Price', 'Stock Quantity', 'Min Order Quantity'
        ];
    }
}
