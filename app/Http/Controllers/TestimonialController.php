<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'isi'    => 'required|min:10',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Testimonial::create([
            'user_id' => auth()->id(),
            'isi'     => $request->isi,
            'rating'  => $request->rating,
        ]);

        return redirect()->route('dashboard')->with('success', 'Testimoni berhasil dikirim!');
    }
}