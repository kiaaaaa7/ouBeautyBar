<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Design;
use App\Models\Slot;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
{
    $totalAppointments   = Appointment::count();
    $totalCustomers      = User::where('role', 'customer')->count();
    $totalDesigns        = Design::count();
    $pendingAppointments = Appointment::where('status', 'Pending')->count();

    $upcomingAppointments = Appointment::with('user')
        ->whereNotNull('tanggal')
        ->where('status', '!=', 'Selesai')
        ->orderBy('tanggal')
        ->orderBy('jam')
        ->take(5)
        ->get();

    return view('admin.index', compact(
        'totalAppointments',
        'totalCustomers',
        'totalDesigns',
        'pendingAppointments',
        'upcomingAppointments'
    ));
}

    public function customers(Request $request)
    {
        $query = User::where('is_admin', false)
            ->with(['appointments'])
            ->orderBy('name');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }

        $customers = $query->get();
        return view('admin.customers', compact('customers'));
    }

    public function appointments(Request $request)
    {
        $query = Appointment::with(['user', 'design'])->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%'.$request->search.'%'));
        }

        $appointments = $query->get();

        // Slot tersedia & sudah booked untuk ditampilkan admin
        $slots = Slot::orderBy('tanggal')->orderBy('jam')->get();

        return view('admin.appointments', compact('appointments', 'slots'));
    }

    // Tambah slot
    public function storeSlot(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'jam'     => 'required',
        ]);

        // Bulk: bisa pilih multiple jam
        $jams = is_array($request->jam) ? $request->jam : [$request->jam];

        foreach ($jams as $jam) {
            Slot::firstOrCreate(
                ['tanggal' => $request->tanggal, 'jam' => $jam],
                ['is_booked' => false]
            );
        }

        return redirect()->back()->with('success', 'Slot berhasil ditambahkan!');
    }

    // Hapus slot
    public function destroySlot($id)
    {
        $slot = Slot::findOrFail($id);
        if ($slot->is_booked) {
            return redirect()->back()->with('error', 'Slot ini sudah dibooked, tidak bisa dihapus.');
        }
        $slot->delete();
        return redirect()->back()->with('success', 'Slot berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:Pending,Konfirmasi,Selesai']);
        Appointment::findOrFail($id)->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status berhasil diupdate!');
    }

    public function destroy($id)
    {
        Appointment::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Appointment berhasil dihapus.');
    }

    public function designs()
    {
        $designs = Design::latest()->get();
        return view('admin.designs', compact('designs'));
    }

    public function createDesign()
    {
        return view('admin.designs-create');
    }

    public function storeDesign(Request $request)
    {
        $request->validate([
            'nama'       => 'required',
            'kategori'   => 'required',
            'deskripsi'  => 'required',
            'harga_type' => 'required|in:tetap,estimasi',
            'harga'      => 'required_if:harga_type,tetap|nullable|integer',
            'harga_min'  => 'required_if:harga_type,estimasi|nullable|integer',
            'harga_max'  => 'required_if:harga_type,estimasi|nullable|integer',
            'gambar'     => 'nullable|image|max:2048',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('designs', 'public');
        }

        Design::create([
            'nama'       => $request->nama,
            'kategori'   => $request->kategori,
            'deskripsi'  => $request->deskripsi,
            'harga_type' => $request->harga_type,
            'harga'      => $request->harga_type === 'tetap' ? $request->harga : $request->harga_min,
            'harga_min'  => $request->harga_type === 'estimasi' ? $request->harga_min : $request->harga,
            'harga_max'  => $request->harga_type === 'estimasi' ? $request->harga_max : $request->harga,
            'gambar'     => $gambar,
        ]);

        return redirect()->route('admin.designs')->with('success', 'Desain berhasil ditambahkan!');
    }

    public function editDesign($id)
    {
        $design = Design::findOrFail($id);
        return view('admin.designs-edit', compact('design'));
    }

    public function updateDesign(Request $request, $id)
    {
        $design = Design::findOrFail($id);

        $request->validate([
            'nama'       => 'required',
            'kategori'   => 'required',
            'deskripsi'  => 'required',
            'harga_type' => 'required|in:tetap,estimasi',
            'harga'      => 'required_if:harga_type,tetap|nullable|integer',
            'harga_min'  => 'required_if:harga_type,estimasi|nullable|integer',
            'harga_max'  => 'required_if:harga_type,estimasi|nullable|integer',
            'gambar'     => 'nullable|image|max:2048',
        ]);

        $data = [
            'nama'       => $request->nama,
            'kategori'   => $request->kategori,
            'deskripsi'  => $request->deskripsi,
            'harga_type' => $request->harga_type,
            'harga'      => $request->harga_type === 'tetap' ? $request->harga : $request->harga_min,
            'harga_min'  => $request->harga_type === 'estimasi' ? $request->harga_min : $request->harga,
            'harga_max'  => $request->harga_type === 'estimasi' ? $request->harga_max : $request->harga,
        ];

        if ($request->hasFile('gambar')) {
            if ($design->gambar) Storage::disk('public')->delete($design->gambar);
            $data['gambar'] = $request->file('gambar')->store('designs', 'public');
        }

        $design->update($data);
        return redirect()->route('admin.designs')->with('success', 'Desain berhasil diupdate!');
    }

    public function destroyDesign($id)
    {
        $design = Design::findOrFail($id);
        if ($design->gambar) Storage::disk('public')->delete($design->gambar);
        $design->delete();
        return redirect()->back()->with('success', 'Desain berhasil dihapus.');
    }
    public function rekap()
{
    $rekapBulanan = Appointment::selectRaw("
        MONTH(created_at) as bulan,
        YEAR(created_at) as tahun,

        SUM(CASE
            WHEN tipe_order = 'nail_art'
            THEN 1 ELSE 0
        END) as total_nail_art,

        SUM(CASE
            WHEN tipe_order = 'press_on'
            THEN 1 ELSE 0
        END) as total_press_on,

        COUNT(*) as total_pesanan
    ")
    ->groupBy('tahun', 'bulan')
    ->orderBy('tahun', 'desc')
    ->orderBy('bulan', 'desc')
    ->get();

    return view('admin.rekap', compact('rekapBulanan'));
}
}