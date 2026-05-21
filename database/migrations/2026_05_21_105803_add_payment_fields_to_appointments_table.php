<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Tambah kolom payment jika belum ada
            if (!Schema::hasColumn('appointments', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('metode_bayar');
            }
            if (!Schema::hasColumn('appointments', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'waiting_confirmation', 'paid'])
                      ->default('pending')
                      ->after('payment_method');
            }
            if (!Schema::hasColumn('appointments', 'bukti_pembayaran')) {
                $table->string('bukti_pembayaran')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('appointments', 'total_harga')) {
                $table->decimal('total_harga', 12, 2)->nullable()->after('bukti_pembayaran');
            }
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumnIfExists('payment_method');
            $table->dropColumnIfExists('payment_status');
            $table->dropColumnIfExists('bukti_pembayaran');
            $table->dropColumnIfExists('total_harga');
        });
    }
};