<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Design;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppointmentController extends Controller
{
    // ─── Dashboard customer ──────────────────────────────────────────────────
    public function dashboard()
    {
        $appointments = Appointment::where('user_id', auth()->id())
            ->with('design')
            ->latest()
            ->get();

        $testimonials = Testimonial::where('user_id', auth()->id())->get();

        return view('dashboard', compact('appointments', 'testimonials'));
    }

    // ─── Form booking ────────────────────────────────────────────────────────
    public function create(Design $design)
    {
        return view('booking.create', compact('design'));
    }

    // ─── Simpan booking ──────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'design_id'        => 'required|exists:designs,id',
            'tanggal'          => 'required|date|after:today',
            'jam'              => 'required',
            'panjang_kuku'     => 'required',
            'metode_bayar'     => 'required|in:QRIS,Transfer Bank,Bayar di Tempat',
            'foto_referensi'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ], [
            'tanggal.after'           => 'Tanggal harus minimal besok.',
            'metode_bayar.required'   => 'Pilih metode pembayaran.',
            'bukti_pembayaran.image'  => 'Bukti pembayaran harus berupa gambar.',
            'bukti_pembayaran.mimes'  => 'Format bukti harus JPG, JPEG, atau PNG.',
            'bukti_pembayaran.max'    => 'Ukuran bukti maksimal 4MB.',
        ]);

        // ── Ambil harga dari design ──────────────────────────────────────────
        $design    = Design::findOrFail($request->design_id);
        $totalHarga = $design->harga ?? $design->harga_min ?? 0;

        // ── Upload foto referensi (opsional) ─────────────────────────────────
        $fotoReferensi = null;
        if ($request->hasFile('foto_referensi')) {
            $fotoReferensi = $request->file('foto_referensi')
                ->store('referensi', 'public');
        }

        // ── Upload bukti pembayaran ───────────────────────────────────────────
        // Disimpan ke public/bukti/ sesuai permintaan
        $buktiBayar = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $file       = $request->file('bukti_pembayaran');
            $filename   = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Pastikan folder public/bukti/ ada
            if (!is_dir(public_path('bukti'))) {
                mkdir(public_path('bukti'), 0755, true);
            }

            $file->move(public_path('bukti'), $filename);
            $buktiBayar = $filename;
        }

        // ── Tentukan payment_status awal ─────────────────────────────────────
        //  • Bayar di Tempat  → pending
        //  • Upload bukti ada → waiting_confirmation
        //  • Pilih QRIS/Bank tapi belum upload → pending
        $paymentStatus = 'pending';
        if ($buktiBayar) {
            $paymentStatus = 'waiting_confirmation';
        }

        // ── Simpan appointment ───────────────────────────────────────────────
        Appointment::create([
            'user_id'          => auth()->id(),
            'design_id'        => $request->design_id,
            'tanggal'          => $request->tanggal,
            'jam'              => $request->jam,
            'panjang_kuku'     => $request->panjang_kuku,
            'metode_bayar'     => $request->metode_bayar,
            'payment_method'   => $request->metode_bayar,
            'payment_status'   => $paymentStatus,
            'bukti_pembayaran' => $buktiBayar,
            'total_harga'      => $totalHarga,
            'status'           => 'Pending',
            'catatan'          => $request->catatan,
            'foto_referensi'   => $fotoReferensi,
        ]);

        $pesan = $buktiBayar
            ? 'Booking berhasil! Bukti pembayaran sedang dikonfirmasi.'
            : 'Booking berhasil! Silakan upload bukti pembayaran.';

        return redirect()->route('dashboard')->with('success', $pesan);
    }

    // ─── Hapus booking ───────────────────────────────────────────────────────
    public function destroy($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $appointment->delete();

        return redirect()->route('dashboard')->with('success', 'Appointment berhasil dibatalkan.');
    }

    // ─── [ADMIN] Update status pembayaran ───────────────────────────────────
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,waiting_confirmation,paid',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update([
            'payment_status' => $request->payment_status,
            'status'         => $request->payment_status === 'paid' ? 'Confirmed' : $appointment->status,
        ]);

        return redirect()->back()->with('success', 'Status pembayaran diperbarui.');
    }
}