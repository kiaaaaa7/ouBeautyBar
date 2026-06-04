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
        return view('booking.create', compact('design'));
    }

    public function store(Request $request)
    {
        $tipe = $request->tipe_order;

        // Validasi bersama
        $rules = [
            'design_id'    => 'required|exists:designs,id',
            'tipe_order'   => 'required|in:nail_art,press_on',
            'panjang_kuku' => 'required',
            'bentuk_kuku'  => 'required',
            'no_wa'        => 'required|string|max:20',
        ];

        // Validasi khusus nail art
        if ($tipe === 'nail_art') {
            $rules['tanggal']        = 'required|date|after:today';
            $rules['jam']            = 'required';
            $rules['metode_bayar']   = 'required';
            $rules['foto_referensi'] = 'nullable|image|max:2048';
        }

        // Validasi khusus press on
        if ($tipe === 'press_on') {
            $rules['foto_jari_koin']    = 'required|image|max:2048';
            $rules['foto_referensi.*']  = 'nullable|image|max:2048';
        }

        $request->validate($rules, [
            'tanggal.after'       => 'Tanggal harus minimal besok.',
            'no_wa.required'      => 'Nomor WhatsApp wajib diisi.',
            'foto_jari_koin.required' => 'Foto jari dengan koin 500 wajib diunggah.',
        ]);

        // ===== SIMPAN FOTO =====

        // Nail art: 1 foto referensi
        $fotoRef = null;
        if ($tipe === 'nail_art' && $request->hasFile('foto_referensi')) {
            $fotoRef = $request->file('foto_referensi')->store('referensi', 'public');
        }

        // Press on: multiple foto referensi
        $fotoRefList = [];
        if ($tipe === 'press_on' && $request->hasFile('foto_referensi')) {
            foreach ($request->file('foto_referensi') as $foto) {
                $fotoRefList[] = $foto->store('referensi', 'public');
            }
        }

        // Press on: foto jari + koin
        $fotoJariKoin = null;
        if ($tipe === 'press_on' && $request->hasFile('foto_jari_koin')) {
            $fotoJariKoin = $request->file('foto_jari_koin')->store('jari-koin', 'public');
        }

        // ===== METODE BAYAR =====
        // Nail art → DP (admin konfirmasi harga via WA)
        // Press on → Lunas
        $metodeBayar = $tipe === 'nail_art'
            ? $request->metode_bayar
            : 'Lunas (Press On)';

        Appointment::create([
            'user_id'             => auth()->id(),
            'design_id'           => $request->design_id,
            'tipe_order'          => $tipe,
            'tanggal'             => $tipe === 'nail_art' ? $request->tanggal : null,
            'jam'                 => $tipe === 'nail_art' ? $request->jam : null,
            'panjang_kuku'        => $request->panjang_kuku,
            'bentuk_kuku'         => $request->bentuk_kuku,
            'no_wa'               => $request->no_wa,
            'metode_bayar'        => $metodeBayar,
            'status'              => 'Pending',
            'catatan'             => $request->catatan,
            'foto_referensi'      => $fotoRef,
            'foto_referensi_list' => !empty($fotoRefList) ? $fotoRefList : null,
            'foto_jari_koin'      => $fotoJariKoin,
        ]);

        $msg = $tipe === 'nail_art'
            ? 'Booking nail art berhasil! Admin akan menghubungi kamu untuk konfirmasi DP.'
            : 'Order press on nail berhasil! Admin akan menghubungi kamu segera.';

        return redirect()->route('dashboard')->with('success', $msg);
    }

    public function destroy($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $appointment->delete();

        return redirect()->route('dashboard')->with('success', 'Order berhasil dibatalkan.');
    }
}