<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'isi', 'rating',
        'foto_hasil', 'design_id', 'bentuk_kuku', 'panjang_kuku',
    ];

    protected $casts = [
        'foto_hasil' => 'array',
    ];

    public function user()   { return $this->belongsTo(User::class); }
    public function design() { return $this->belongsTo(Design::class); }
}
