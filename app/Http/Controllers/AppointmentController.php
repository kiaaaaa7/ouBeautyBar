<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Design;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Dashboard customer
    public function dashboard()
    {
        $appointments = Appointment::where('user_id', auth()->id())
            ->with('design')
            ->latest()
            ->get();

        $testimonials = Testimonial::where('user_id', auth()->id())->get();

        return view('dashboard', compact('appointments', 'testimonials'));
    }

    // Form booking
    public function create(Design $design)
    {
        return view('booking.create', compact('design'));
    }

    // Simpan booking
    public function store(Request $request)
{
    $request->validate([
        'design_id'      => 'required|exists:designs,id',
        'tanggal'        => 'required|date|after:today',
        'jam'            => 'required',
        'panjang_kuku'   => 'required',
        'metode_bayar'   => 'required',
        'foto_referensi' => 'nullable|image|max:2048',
    ], [
        'tanggal.after' => 'Tanggal harus minimal besok.',
    ]);

    $foto = null;
    if ($request->hasFile('foto_referensi')) {
        $foto = $request->file('foto_referensi')->store('referensi', 'public');
    }

    Appointment::create([
        'user_id'        => auth()->id(),
        'design_id'      => $request->design_id,
        'tanggal'        => $request->tanggal,
        'jam'            => $request->jam,
        'panjang_kuku'   => $request->panjang_kuku,
        'metode_bayar'   => $request->metode_bayar,
        'status'         => 'Pending',
        'catatan'        => $request->catatan,
        'foto_referensi' => $foto,
    ]);

    return redirect()->route('dashboard')->with('success', 'Booking berhasil! Menunggu konfirmasi.');
}

    // Hapus booking
    public function destroy($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $appointment->delete();

        return redirect()->route('dashboard')->with('success', 'Appointment berhasil dibatalkan.');
    }
}