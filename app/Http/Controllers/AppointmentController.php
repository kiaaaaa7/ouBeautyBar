<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Design;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function dashboard()
    {
        $appointments = Appointment::where('user_id', auth()->id())
            ->with('design')
            ->latest()
            ->get();

        $testimonials = Testimonial::where('user_id', auth()->id())->get();

        return view('dashboard', compact('appointments', 'testimonials'));
    }

    public function create(Design $design)
    {
        // Ambil semua design untuk dropdown pilihan per jari
        $allDesigns = Design::orderBy('nama')->get();
        return view('booking.create', compact('design', 'allDesigns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'design_id'      => 'required|exists:designs,id',
            'tanggal'        => 'required|date|after:today',
            'jam'            => 'required',
            'panjang_kuku'   => 'required',
            'metode_bayar'   => 'required',
            'foto_referensi' => 'nullable|image|max:2048',
            'foto_kuku'      => 'nullable|image|max:2048',
            'pilihan_jari'   => 'nullable|array',
        ], [
            'tanggal.after' => 'Tanggal harus minimal besok.',
        ]);

        // Simpan foto referensi
        $fotoRef = null;
        if ($request->hasFile('foto_referensi')) {
            $fotoRef = $request->file('foto_referensi')->store('referensi', 'public');
        }

        // Simpan foto kuku
        $fotoKuku = null;
        if ($request->hasFile('foto_kuku')) {
            $fotoKuku = $request->file('foto_kuku')->store('kuku', 'public');
        }

        // Hitung total harga dari pilihan per jari
        $pilihanJari = $request->pilihan_jari ?? [];
        $totalHarga  = 0;

        if (!empty($pilihanJari)) {
            $allDesignIds = collect($pilihanJari)
                ->flatten()
                ->unique()
                ->values();

            // Ambil harga design yang dipilih
            $designPrices = Design::whereIn('id', $allDesignIds)
                ->pluck('harga_min', 'id');

            foreach ($pilihanJari as $tangan => $jari) {
                foreach ($jari as $idx => $designId) {
                    $hargaDesign = $designPrices[$designId] ?? 0;
                    $totalHarga += $hargaDesign / 10; // per jari
                }
            }
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
            'foto_referensi' => $fotoRef,
            'foto_kuku'      => $fotoKuku,
            'pilihan_jari'   => $pilihanJari,
            'total_harga'    => $totalHarga,
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking berhasil! Menunggu konfirmasi.');
    }

    public function destroy($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $appointment->delete();

        return redirect()->route('dashboard')->with('success', 'Appointment berhasil dibatalkan.');
    }
}