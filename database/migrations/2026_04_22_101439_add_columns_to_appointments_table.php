<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('design_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->string('jam');
            $table->enum('panjang_kuku', ['Pendek', 'Sedang', 'Panjang']);
            $table->enum('metode_bayar', ['Transfer Bank', 'QRIS', 'Bayar di Tempat']);
            $table->enum('status', ['Pending', 'Konfirmasi', 'Selesai'])->default('Pending');
            $table->text('catatan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['user_id','design_id','tanggal','jam','panjang_kuku','metode_bayar','status','catatan']);
        });
    }
};