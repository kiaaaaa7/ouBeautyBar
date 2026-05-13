<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Design;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Dashboard admin
    public function index()
    {
        $totalAppointments  = Appointment::count();
        $totalCustomers     = User::where('role', 'customer')->count();
        $totalDesigns       = Design::count();
        $pendingAppointments = Appointment::where('status', 'Pending')->count();

        return view('admin.index', compact(
            'totalAppointments', 'totalCustomers',
            'totalDesigns', 'pendingAppointments'
        ));
    }

    // Kelola appointment
    public function appointments(Request $request)
    {
        $query = Appointment::with(['user', 'design'])->latest();

        // Filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Pencarian nama customer
        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $appointments = $query->get();

        return view('admin.appointments', compact('appointments'));
    }

    // Update status appointment
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:Pending,Konfirmasi,Selesai']);

        Appointment::findOrFail($id)->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status berhasil diupdate!');
    }

    // Hapus appointment
    public function destroy($id)
    {
        Appointment::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Appointment berhasil dihapus.');
    }

    // Halaman kelola desain
    public function designs()
    {
        $designs = Design::latest()->get();
        return view('admin.designs', compact('designs'));
    }

    // Form tambah desain
    public function createDesign()
    {
        return view('admin.designs-create');
    }

    // Simpan desain baru
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
// Form edit desain
public function editDesign($id)
{
    $design = Design::findOrFail($id);
    return view('admin.designs-edit', compact('design'));
}

// Simpan edit desain
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
    // Hapus desain
    public function destroyDesign($id)
    {
        $design = Design::findOrFail($id);
        if ($design->gambar) {
            Storage::disk('public')->delete($design->gambar);
        }
        $design->delete();

        return redirect()->back()->with('success', 'Desain berhasil dihapus.');
    }
}