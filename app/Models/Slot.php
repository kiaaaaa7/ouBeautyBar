<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $fillable = ['tanggal', 'jam', 'is_booked'];

    protected $casts = ['tanggal' => 'date', 'is_booked' => 'boolean'];
}