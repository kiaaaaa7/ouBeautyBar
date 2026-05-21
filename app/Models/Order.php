<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'buyer_name',
        'buyer_whatsapp',
        'buyer_address',
        'buyer_city',
        'buyer_postal_code',
        'nail_photo_path',
        'shipping_method',
        'courier_name',
        'shipping_cost',
        'tracking_number',
        'payment_method',
        'payment_proof_path',
        'payment_confirmed_at',
        'subtotal',
        'total_amount',
        'status',
        'notes',
        'admin_notes',
    ];

    protected $casts = [
        'subtotal'             => 'decimal:2',
        'total_amount'         => 'decimal:2',
        'shipping_cost'        => 'decimal:2',
        'payment_confirmed_at' => 'datetime',
    ];

    // ── Status Labels (untuk ditampilkan ke user) ─────────────────────
    const STATUS_LABELS = [
        'pending'    => 'Menunggu Konfirmasi',
        'confirmed'  => 'Dikonfirmasi',
        'processing' => 'Sedang Diproses',
        'shipped'    => 'Dikirim',
        'completed'  => 'Selesai',
        'cancelled'  => 'Dibatalkan',
    ];

    const STATUS_COLORS = [
        'pending'    => 'yellow',
        'confirmed'  => 'blue',
        'processing' => 'purple',
        'shipped'    => 'indigo',
        'completed'  => 'green',
        'cancelled'  => 'red',
    ];

    const PAYMENT_LABELS = [
        'transfer' => 'Transfer Bank',
        'qris'     => 'QRIS',
        'cod'      => 'Bayar di Tempat',
    ];

    const SHIPPING_LABELS = [
        'courier' => 'Kurir',
        'cod'     => 'Antar / Ambil Sendiri',
    ];

    // ── Relasi ────────────────────────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Helper ────────────────────────────────────────────────────────
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'gray';
    }

    public function getPaymentLabelAttribute(): string
    {
        return self::PAYMENT_LABELS[$this->payment_method] ?? $this->payment_method;
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    public function getNailPhotoUrlAttribute(): ?string
    {
        return $this->nail_photo_path
            ? asset('storage/' . $this->nail_photo_path)
            : null;
    }

    public function getPaymentProofUrlAttribute(): ?string
    {
        return $this->payment_proof_path
            ? asset('storage/' . $this->payment_proof_path)
            : null;
    }

    // Generate nomor pesanan unik
    public static function generateOrderNumber(): string
    {
        $date   = now()->format('Ymd');
        $last   = self::whereDate('created_at', today())->count() + 1;
        return 'ORD-' . $date . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
    }

    // Cek apakah pesanan bisa dibatalkan oleh user
    public function isCancellable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }
}