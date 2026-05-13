<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'design_id', 'tanggal', 'jam',
        'panjang_kuku', 'metode_bayar', 'status',
        'catatan', 'foto_referensi',
    ];

    public function user()   { return $this->belongsTo(User::class); }
    public function design() { return $this->belongsTo(Design::class); }
}