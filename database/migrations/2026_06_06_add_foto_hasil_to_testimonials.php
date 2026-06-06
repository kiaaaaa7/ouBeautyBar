<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->json('foto_hasil')->nullable()->after('rating');
            $table->foreignId('design_id')->nullable()->constrained('designs')->nullOnDelete()->after('foto_hasil');
            $table->string('bentuk_kuku')->nullable()->after('design_id');
            $table->string('panjang_kuku')->nullable()->after('bentuk_kuku');
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropForeign(['design_id']);
            $table->dropColumn(['foto_hasil', 'design_id', 'bentuk_kuku', 'panjang_kuku']);
        });
    }
};