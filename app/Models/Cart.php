<?php

namespace App\Models;

use App\Models\User;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getSubtotalAttribute(): float
    {
        return $this->items->sum(fn($item) => $item->price * $item->quantity);
    }

    public function getTaxAttribute(): float
    {
        return $this->subtotal * 0.1;
    }

    public function getTotalAttribute(): float
    {
        return $this->subtotal + $this->tax;
    }
}
