<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_price',
        'quantity',
        'subtotal',
        'custom_design_path',
        'custom_notes',
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'subtotal'      => 'decimal:2',
    ];

    // ── Relasi ────────────────────────────────────────────────────────
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ── Helper ────────────────────────────────────────────────────────
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->product_price, 0, ',', '.');
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    public function getCustomDesignUrlAttribute(): ?string
    {
        return $this->custom_design_path
            ? asset('storage/' . $this->custom_design_path)
            : null;
    }
}