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
                'kategori' => 'Gel',
                'deskripsi' => 'Desain kuku pink aesthetic',
                'harga' => 50000,
                'gambar' => 'design1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama' => 'Soft Glam Makeup',
                'kategori' => '3D',
                'deskripsi' => 'Soft glam elegan',
                'harga' => 120000,
                'gambar' => 'design2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}