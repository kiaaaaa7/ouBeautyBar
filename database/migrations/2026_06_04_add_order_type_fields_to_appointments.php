<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Tipe order
            $table->enum('tipe_order', ['nail_art', 'press_on'])->default('nail_art')->after('design_id');

            // Info kuku
            $table->string('bentuk_kuku')->nullable()->after('panjang_kuku');

            // Kontak
            $table->string('no_wa')->nullable()->after('bentuk_kuku');

            // Foto — ganti foto_referensi jadi JSON (multiple), tambah foto_jari_koin
            // foto_referensi sudah ada sebagai VARCHAR, kita tambah kolom baru
            $table->json('foto_referensi_list')->nullable()->after('foto_referensi');
            $table->string('foto_jari_koin')->nullable()->after('foto_referensi_list');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['tipe_order', 'bentuk_kuku', 'no_wa', 'foto_referensi_list', 'foto_jari_koin']);
        });
    }
};