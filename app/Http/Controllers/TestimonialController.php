<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'isi'          => 'required|min:10',
            'rating'       => 'required|integer|min:1|max:5',
            'foto_testi.*' => 'nullable|image|max:2048',
        ]);

        // Upload foto testimoni customer
        $fotos = [];
        if ($request->hasFile('foto_testi')) {
            foreach ($request->file('foto_testi') as $foto) {
                $fotos[] = $foto->store('testimoni-customer', 'public');
            }
        }

        Testimonial::create([
            'user_id'   => auth()->id(),
            'isi'       => $request->isi,
            'rating'    => $request->rating,
            'foto_hasil' => !empty($fotos) ? $fotos : null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Testimoni berhasil dikirim!');
    }
}