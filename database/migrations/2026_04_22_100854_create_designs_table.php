<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori'); // contoh: Gel, 3D, Stamping
            $table->text('deskripsi');
            $table->integer('harga');
            $table->string('gambar')->nullable(); // nama file gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('designs');
    }
};