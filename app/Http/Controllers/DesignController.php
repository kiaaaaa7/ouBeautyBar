<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Testimonial;

class DesignController extends Controller
{
    public function index()
    {
        $designs      = Design::latest()->get();
        $testimonials = Testimonial::with(['user', 'design'])
            ->latest()
            ->get();

        return view('home', compact('designs', 'testimonials'));
    }
}