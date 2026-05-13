<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'kategori', 'deskripsi',
        'harga', 'harga_type', 'harga_min', 'harga_max', 'gambar'
    ];

    public function appointments() { return $this->hasMany(Appointment::class); }
}