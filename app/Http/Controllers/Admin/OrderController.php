<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    // Daftar semua pesanan
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items'])->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by metode bayar
        if ($request->filled('payment')) {
            $query->where('payment_method', $request->payment);
        }

        // Search by nomor pesanan / nama pembeli
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('buyer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('buyer_whatsapp', 'like', '%' . $request->search . '%');
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        $statusCounts = Order::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    // Detail pesanan
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    // Update status pesanan
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status'          => 'required|in:pending,confirmed,processing,shipped,completed,cancelled',
            'tracking_number' => 'required_if:status,shipped|nullable|string|max:100',
            'admin_notes'     => 'nullable|string|max:500',
        ]);

        $data = ['status' => $request->status];

        if ($request->filled('tracking_number')) {
            $data['tracking_number'] = $request->tracking_number;
        }

        if ($request->filled('admin_notes')) {
            $data['admin_notes'] = $request->admin_notes;
        }

        // Tandai pembayaran dikonfirmasi
        if ($request->status === 'confirmed' && !$order->payment_confirmed_at) {
            $data['payment_confirmed_at'] = now();
        }

        $order->update($data);

        return back()->with('success', 'Status pesanan berhasil diupdate!');
    }

    // Admin konfirmasi pembayaran manual
    public function confirmPayment(Order $order)
    {
        $order->update([
            'payment_confirmed_at' => now(),
            'status'               => 'confirmed',
        ]);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
}