<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    // Halaman utama + katalog
    public function index()
    {
        $designs      = Design::latest()->get();
        $testimonials = Testimonial::with('user')->latest()->take(6)->get();

        return view('home', compact('designs', 'testimonials'));
    }
}