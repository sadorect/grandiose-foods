<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'sku',
        'base_price',
        'is_featured',
        'is_active',
        'variants',
        'stock_quantity',
        'specifications',
        'weight_variants'
    ];

    protected $casts = [
        'specifications' => 'json',
        'weight_variants' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
