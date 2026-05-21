<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Nomor pesanan unik, e.g. "ORD-20260520-0001"
            $table->string('order_number')->unique();

            // ── Informasi Pembeli ──────────────────────────────────────
            $table->string('buyer_name');
            $table->string('buyer_whatsapp');
            $table->text('buyer_address');
            $table->string('buyer_city');
            $table->string('buyer_postal_code');

            // ── Foto Kuku Pembeli ──────────────────────────────────────
            // Admin butuh ini untuk ukuran / fitting press on nail
            $table->string('nail_photo_path')->nullable();

            // ── Pengiriman ─────────────────────────────────────────────
            // 'courier' = kurir (JNE/J&T/dll), 'cod' = bayar/antar di tempat
            $table->enum('shipping_method', ['courier', 'cod']);
            $table->string('courier_name')->nullable();         // JNE, J&T, SiCepat, dll
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->string('tracking_number')->nullable();      // isi admin saat sudah dikirim

            // ── Pembayaran ─────────────────────────────────────────────
            // 'transfer' = TF bank, 'qris' = QRIS, 'cod' = bayar di tempat
            $table->enum('payment_method', ['transfer', 'qris', 'cod']);
            $table->string('payment_proof_path')->nullable();   // bukti TF yang diupload pembeli
            $table->timestamp('payment_confirmed_at')->nullable();

            // ── Harga ──────────────────────────────────────────────────
            $table->decimal('subtotal', 10, 2);                 // total harga produk
            $table->decimal('total_amount', 10, 2);             // subtotal + ongkir

            // ── Status Pesanan ─────────────────────────────────────────
            // pending      → baru masuk, menunggu konfirmasi admin
            // confirmed    → admin sudah konfirmasi & cek pembayaran
            // processing   → sedang dibuat / diproses
            // shipped      → sudah dikirim (ada resi)
            // completed    → barang sudah diterima pembeli
            // cancelled    → dibatalkan
            $table->enum('status', [
                'pending',
                'confirmed',
                'processing',
                'shipped',
                'completed',
                'cancelled',
            ])->default('pending');

            $table->text('notes')->nullable();                  // catatan dari pembeli
            $table->text('admin_notes')->nullable();            // catatan internal admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};