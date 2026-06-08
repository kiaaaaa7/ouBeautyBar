<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Design;
use App\Models\Slot;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function dashboard()
    {
        $appointments = Appointment::where('user_id', auth()->id())
            ->with('design')->latest()->get();
        $testimonials = Testimonial::where('user_id', auth()->id())->get();
        return view('dashboard', compact('appointments', 'testimonials'));
    }

    public function create(Design $design)
    {
        $allDesigns = Design::orderBy('nama')->get();

        // Slot tersedia (belum dibook, tanggal >= hari ini)
        $slots = Slot::where('is_booked', false)
            ->where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')->orderBy('jam')
            ->get()
            ->groupBy(fn($s) => $s->tanggal->format('Y-m-d'));

        return view('booking.create', compact('design', 'allDesigns', 'slots'));
    }

    // Return slot tersedia sebagai JSON (untuk live update jika perlu)
    public function slotsTersedia()
    {
        $slots = Slot::where('is_booked', false)
            ->where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')->orderBy('jam')
            ->get(['id', 'tanggal', 'jam']);

        return response()->json($slots);
    }

    public function store(Request $request)
    {
        $tipe = $request->tipe_order;

        $rules = [
            'design_id'    => 'required|exists:designs,id',
            'tipe_order'   => 'required|in:nail_art,press_on',
            'panjang_kuku' => 'required',
            'bentuk_kuku'  => 'required',
            'no_wa'        => 'required|string|max:20',
            'pilihan_jari' => 'nullable|array',
        ];

        if ($tipe === 'nail_art') {
            $rules['slot_id']        = 'required|exists:slots,id';
            $rules['metode_bayar']   = 'required';
            $rules['foto_referensi'] = 'nullable|image|max:2048';
            $rules['bukti_bayar']    = 'nullable|image|max:2048';
        }

        if ($tipe === 'press_on') {
            $rules['foto_jari_koin']   = 'required|image|max:2048';
            $rules['foto_referensi.*'] = 'nullable|image|max:2048';
        }

        $request->validate($rules, [
            'slot_id.required'        => 'Pilih jadwal kunjungan.',
            'no_wa.required'          => 'Nomor WhatsApp wajib diisi.',
            'foto_jari_koin.required' => 'Foto jari dengan koin 500 wajib diunggah.',
        ]);

        // Ambil data slot
        $slot   = null;
        $tanggal = null;
        $jam     = null;

        if ($tipe === 'nail_art') {
            $slot = Slot::findOrFail($request->slot_id);

            // Cek slot masih tersedia
            if ($slot->is_booked) {
                return redirect()->back()->withErrors(['slot_id' => 'Jadwal ini sudah diambil orang lain, pilih jadwal lain.'])->withInput();
            }

            $tanggal = $slot->tanggal->format('Y-m-d');
            $jam     = $slot->jam;
        }

        // Hitung total harga
        $pilihanJari = $request->pilihan_jari ?? [];
        $totalHarga  = 0;

        if (!empty($pilihanJari)) {
            $allDesignIds = collect($pilihanJari)->flatten()->unique()->values();
            $designPrices = Design::whereIn('id', $allDesignIds)->pluck('harga_min', 'id');
            foreach ($pilihanJari as $jari) {
                foreach ($jari as $designId) {
                    $totalHarga += ($designPrices[$designId] ?? 0);
                }
            }
        }

        // Foto
        $fotoRef = null;
if ($tipe === 'nail_art' && $request->hasFile('foto_referensi_na')) {
    $fotoRef = $request->file('foto_referensi_na')->store('referensi', 'public');
}

$buktiBayar = null;
if ($tipe === 'nail_art' && $request->hasFile('bukti_bayar')) {
    $buktiBayar = $request->file('bukti_bayar')->store('bukti-bayar', 'public');
} elseif ($tipe === 'press_on' && $request->hasFile('bukti_bayar_po')) {
    $buktiBayar = $request->file('bukti_bayar_po')->store('bukti-bayar', 'public');
}

        $fotoRefList = [];
        if ($tipe === 'press_on' && $request->hasFile('foto_referensi')) {
            foreach ($request->file('foto_referensi') as $foto) {
                $fotoRefList[] = $foto->store('referensi', 'public');
            }
        }

        $fotoJariKoin = null;
        if ($tipe === 'press_on' && $request->hasFile('foto_jari_koin')) {
            $fotoJariKoin = $request->file('foto_jari_koin')->store('jari-koin', 'public');
        }

        // Bukti bayar
        $buktiBayar = null;
        if ($request->hasFile('bukti_bayar')) {
            $buktiBayar = $request->file('bukti_bayar')->store('bukti-bayar', 'public');
        }

        $metodeBayar = $tipe === 'nail_art' ? $request->metode_bayar : 'Transfer Bank';

        Appointment::create([
            'user_id'             => auth()->id(),
            'design_id'           => $request->design_id,
            'tipe_order'          => $tipe,
            'tanggal'             => $tanggal,
            'jam'                 => $jam,
            'panjang_kuku'        => $request->panjang_kuku,
            'bentuk_kuku'         => $request->bentuk_kuku,
            'no_wa'               => $request->no_wa,
            'metode_bayar'        => $metodeBayar,
            'status'              => 'Pending',
            'catatan'             => $request->catatan,
            'foto_referensi'      => $fotoRef,
            'foto_referensi_list' => !empty($fotoRefList) ? $fotoRefList : null,
            'foto_jari_koin'      => $fotoJariKoin,
            'bukti_bayar'         => $buktiBayar,
            'pilihan_jari'        => !empty($pilihanJari) ? $pilihanJari : null,
            'total_harga'         => $totalHarga,
        ]);

        // Tandai slot sebagai booked
        if ($slot) {
            $slot->update(['is_booked' => true]);
        }

        $msg = $tipe === 'nail_art'
            ? 'Booking nail art berhasil! Admin akan menghubungi kamu untuk konfirmasi DP 50%.'
            : 'Order press on nail berhasil! Admin akan menghubungi kamu segera.';

        return redirect()->route('dashboard')->with('success', $msg);
    }

    public function destroy($id)
    {
        $appointment = Appointment::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Bebaskan slot kembali jika nail art
        if ($appointment->tipe_order === 'nail_art' && $appointment->tanggal && $appointment->jam) {
            Slot::where('tanggal', $appointment->tanggal)
                ->where('jam', $appointment->jam)
                ->update(['is_booked' => false]);
        }

        $appointment->delete();
        return redirect()->route('dashboard')->with('success', 'Order berhasil dibatalkan.');
    }
}