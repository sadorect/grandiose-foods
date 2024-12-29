<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'image'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    protected function image(): Attribute
{
    return Attribute::make(
        get: function ($value) {
            if ($value) {
                return Storage::url($value);
            }
            return asset('images/category/default-category.jpg');
        }
    );
}
}
