<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('designs')->insert([
            [
                'nama' => 'Nail Art Pink',
                'harga' => 50000,
                'image' => 'design1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama' => 'Soft Glam Makeup',
                'harga' => 120000,
                'image' => 'design2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}