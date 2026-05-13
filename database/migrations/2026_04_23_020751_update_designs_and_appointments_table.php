<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah harga_min & harga_max di designs, hapus harga lama
        Schema::table('designs', function (Blueprint $table) {
            $table->integer('harga_min')->after('harga')->default(0);
            $table->integer('harga_max')->after('harga_min')->default(0);
        });

        // Tambah foto_referensi di appointments
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('foto_referensi')->nullable()->after('catatan');
        });
    }

    public function down(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->dropColumn(['harga_min', 'harga_max']);
        });
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('foto_referensi');
        });
    }
};