<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'design_id',
        'tipe_order',
        'tanggal', 'jam',
        'panjang_kuku', 'bentuk_kuku',
        'no_wa',
        'metode_bayar', 'status',
        'catatan',
        'foto_referensi',
        'foto_referensi_list',
        'foto_jari_koin',
        'bukti_bayar',
        'pilihan_jari',
        'total_harga',
    ];

    protected $casts = [
        'pilihan_jari'        => 'array',
        'foto_referensi_list' => 'array',
        'total_harga'         => 'decimal:2',
    ];

    public function user()   { return $this->belongsTo(User::class); }
    public function design() { return $this->belongsTo(Design::class); }
}