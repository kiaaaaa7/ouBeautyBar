<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');                             // nama produk
            $table->string('slug')->unique();
            $table->text('description')->nullable();            // deskripsi produk
            $table->decimal('price', 10, 2);                   // harga
            $table->integer('stock')->default(0);              // stok (0 = unlimited untuk custom)
            $table->boolean('is_custom')->default(false);      // true = produk custom
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};