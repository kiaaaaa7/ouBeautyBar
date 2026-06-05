<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('jam', 10);
            $table->boolean('is_booked')->default(false);
            $table->timestamps();

            $table->unique(['tanggal', 'jam']); // ga bisa duplikat slot
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};