<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'is_custom',
        'is_active',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'is_custom' => 'boolean',
        'is_active' => 'boolean',
    ];

    // ── Relasi ────────────────────────────────────────────────────────
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasMany
    {
        return $this->hasMany(ProductImage::class)->where('is_primary', true);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Scope ─────────────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeReadyStock($query)
    {
        return $query->where('is_custom', false);
    }

    public function scopeCustom($query)
    {
        return $query->where('is_custom', true);
    }

    // ── Helper ────────────────────────────────────────────────────────
    public function isInStock(): bool
    {
        // Produk custom dianggap selalu tersedia
        if ($this->is_custom) return true;
        return $this->stock > 0;
    }

    public function getPrimaryImageUrlAttribute(): ?string
    {
        $image = $this->images()->where('is_primary', true)->first();
        return $image ? asset('storage/' . $image->image_path) : null;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}