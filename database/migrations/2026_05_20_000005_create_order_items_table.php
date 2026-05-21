<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->string('product_name');         // snapshot nama produk saat order
            $table->decimal('product_price', 10, 2); // snapshot harga saat order
            $table->integer('quantity');
            $table->decimal('subtotal', 10, 2);     // price * quantity

            // Khusus produk custom: pembeli bisa upload foto referensi desain
            $table->string('custom_design_path')->nullable();
            $table->text('custom_notes')->nullable(); // catatan desain custom dari pembeli

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};