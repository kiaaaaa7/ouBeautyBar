<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->json('pilihan_jari')->nullable()->after('foto_referensi');
            $table->string('foto_kuku')->nullable()->after('pilihan_jari');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['pilihan_jari', 'foto_kuku']);
        });
    }
};