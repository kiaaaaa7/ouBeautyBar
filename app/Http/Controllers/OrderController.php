<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Halaman checkout - form pemesanan
    public function create(Request $request)
    {
        // Bisa checkout 1 produk langsung dari halaman detail
        $product = Product::active()->findOrFail($request->product_id);
        $quantity = max(1, (int) $request->get('quantity', 1));

        return view('orders.create', compact('product', 'quantity'));
    }

    // Simpan pesanan baru
    public function store(Request $request)
    {
        $request->validate([
            'product_id'        => 'required|exists:products,id',
            'quantity'          => 'required|integer|min:1',
            'buyer_name'        => 'required|string|max:255',
            'buyer_whatsapp'    => 'required|string|max:20',
            'buyer_address'     => 'required|string',
            'buyer_city'        => 'required|string|max:100',
            'buyer_postal_code' => 'required|string|max:10',
            'nail_photo'        => 'required|image|mimes:jpg,jpeg,png|max:5120', // max 5MB
            'shipping_method'   => 'required|in:courier,cod',
            'courier_name'      => 'required_if:shipping_method,courier|nullable|string|max:50',
            'payment_method'    => 'required|in:transfer,qris,cod',
            'notes'             => 'nullable|string|max:500',
            // Untuk produk custom
            'custom_design'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'custom_notes'      => 'nullable|string|max:500',
        ]);

        $product  = Product::active()->findOrFail($request->product_id);
        $quantity = (int) $request->quantity;

        // Cek stok (hanya untuk ready stock)
        if (!$product->is_custom && $product->stock < $quantity) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi.'])->withInput();
        }

        DB::transaction(function () use ($request, $product, $quantity) {
            // Upload foto kuku
            $nailPhotoPath = $request->file('nail_photo')
                ->store('nail-photos', 'public');

            // Upload foto referensi custom (opsional)
            $customDesignPath = null;
            if ($request->hasFile('custom_design')) {
                $customDesignPath = $request->file('custom_design')
                    ->store('custom-designs', 'public');
            }

            $subtotal     = $product->price * $quantity;
            $shippingCost = $request->shipping_method === 'cod' ? 0 : 0; // bisa diubah nanti
            $total        = $subtotal + $shippingCost;

            // Buat order
            $order = Order::create([
                'user_id'           => Auth::id(),
                'order_number'      => Order::generateOrderNumber(),
                'buyer_name'        => $request->buyer_name,
                'buyer_whatsapp'    => $request->buyer_whatsapp,
                'buyer_address'     => $request->buyer_address,
                'buyer_city'        => $request->buyer_city,
                'buyer_postal_code' => $request->buyer_postal_code,
                'nail_photo_path'   => $nailPhotoPath,
                'shipping_method'   => $request->shipping_method,
                'courier_name'      => $request->courier_name,
                'shipping_cost'     => $shippingCost,
                'payment_method'    => $request->payment_method,
                'subtotal'          => $subtotal,
                'total_amount'      => $total,
                'status'            => 'pending',
                'notes'             => $request->notes,
            ]);

            // Buat order item
            OrderItem::create([
                'order_id'           => $order->id,
                'product_id'         => $product->id,
                'product_name'       => $product->name,
                'product_price'      => $product->price,
                'quantity'           => $quantity,
                'subtotal'           => $subtotal,
                'custom_design_path' => $customDesignPath,
                'custom_notes'       => $request->custom_notes,
            ]);

            // Kurangi stok untuk ready stock
            if (!$product->is_custom) {
                $product->decrement('stock', $quantity);
            }

            $this->order = $order;
        });

        return redirect()->route('orders.show', $this->order)
            ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    // Halaman detail pesanan (untuk pembeli)
    public function show(Order $order)
    {
        // Pastikan hanya pemilik yang bisa lihat
        abort_if($order->user_id !== Auth::id(), 403);

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    // Halaman daftar pesanan milik user
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // Upload bukti pembayaran (untuk TF / QRIS)
    public function uploadPaymentProof(Request $request, Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);
        abort_if($order->status !== 'pending', 403);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $path = $request->file('payment_proof')->store('payment-proofs', 'public');

        $order->update(['payment_proof_path' => $path]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload!');
    }

    // Batalkan pesanan
    public function cancel(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);
        abort_if(!$order->isCancellable(), 403);

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}