<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->date('tanggal')->nullable()->change();
            $table->string('jam')->nullable()->change();
            $table->enum('metode_bayar', ['Transfer Bank','QRIS','Bayar di Tempat','Lunas (Press On)'])->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->date('tanggal')->nullable(false)->change();
            $table->string('jam')->nullable(false)->change();
        });
    }
};