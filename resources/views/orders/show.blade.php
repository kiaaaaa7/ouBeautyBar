<x-app-layout>
    <x-slot name="title">{{ $order->order_number }} — OuBeautyBar</x-slot>

    <div style="max-width: 800px; margin: 0 auto; padding: 3rem 2rem;">

        {{-- Breadcrumb --}}
        <p style="font-family: Arial; font-size: 13px; color: var(--text-muted); margin-bottom: 2rem;">
            <a href="{{ route('orders.index') }}" style="color: var(--text-muted); text-decoration: none;">← Pesanan Saya</a>
        </p>

        {{-- STATUS TRACKER --}}
        @php
            $steps = ['pending', 'confirmed', 'processing', 'shipped', 'completed'];
            $labels = ['Menunggu', 'Dikonfirmasi', 'Diproses', 'Dikirim', 'Selesai'];
            $currentIdx = array_search($order->status, $steps);
            if ($order->status === 'cancelled') $currentIdx = -1;
        @endphp

        @if($order->status !== 'cancelled')
        <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem; margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; position: relative;">
                <div style="position: absolute; top: 16px; left: 0; right: 0; height: 2px; background: var(--cream-dark); z-index: 0;"></div>
                <div style="position: absolute; top: 16px; left: 0; height: 2px; background: var(--sage); z-index: 1;
                    width: {{ $currentIdx >= 0 ? ($currentIdx / (count($steps)-1) * 100) : 0 }}%;"></div>
                @foreach($steps as $i => $step)
                <div style="display: flex; flex-direction: column; align-items: center; gap: 6px; z-index: 2; min-width: 60px;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: Arial; font-size: 12px;
                        background: {{ $i <= $currentIdx ? 'var(--sage-dark)' : 'white' }};
                        border: 2px solid {{ $i <= $currentIdx ? 'var(--sage-dark)' : 'var(--cream-dark)' }};
                        color: {{ $i <= $currentIdx ? 'white' : 'var(--text-muted)' }};">
                        {{ $i < $currentIdx ? '✓' : ($i + 1) }}
                    </div>
                    <span style="font-family: Arial; font-size: 10px; color: {{ $i <= $currentIdx ? 'var(--sage-dark)' : 'var(--text-muted)' }}; text-align: center; letter-spacing: 0.3px;">
                        {{ $labels[$i] }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div style="background: #fde8e8; border: 1px solid #f5c6cb; padding: 1rem 1.25rem; margin-bottom: 1.5rem; font-family: Arial; font-size: 14px; color: #c62828;">
            ✗ Pesanan ini telah dibatalkan
        </div>
        @endif

        {{-- INFO PESANAN --}}
        <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem; margin-bottom: 1.5rem;">
            <h2 style="font-size: 14px; font-family: Arial; letter-spacing: 1px; color: var(--sage-dark); margin-bottom: 1.25rem;">DETAIL PESANAN</h2>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                <div>
                    <p style="font-family: Arial; font-size: 11px; color: var(--text-muted); margin-bottom: 4px; letter-spacing: 0.5px;">NOMOR PESANAN</p>
                    <p style="font-family: Arial; font-size: 14px; color: var(--text-dark);">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p style="font-family: Arial; font-size: 11px; color: var(--text-muted); margin-bottom: 4px; letter-spacing: 0.5px;">TANGGAL</p>
                    <p style="font-family: Arial; font-size: 14px; color: var(--text-dark);">{{ $order->created_at->format('d F Y, H:i') }}</p>
                </div>
                <div>
                    <p style="font-family: Arial; font-size: 11px; color: var(--text-muted); margin-bottom: 4px; letter-spacing: 0.5px;">PEMBAYARAN</p>
                    <p style="font-family: Arial; font-size: 14px; color: var(--text-dark);">{{ $order->payment_label }}</p>
                </div>
                <div>
                    <p style="font-family: Arial; font-size: 11px; color: var(--text-muted); margin-bottom: 4px; letter-spacing: 0.5px;">PENGIRIMAN</p>
                    <p style="font-family: Arial; font-size: 14px; color: var(--text-dark);">
                        {{ $order->shipping_method === 'courier' ? ($order->courier_name ?? 'Kurir') : 'COD / Antar Sendiri' }}
                    </p>
                </div>
                @if($order->tracking_number)
                <div>
                    <p style="font-family: Arial; font-size: 11px; color: var(--text-muted); margin-bottom: 4px; letter-spacing: 0.5px;">NO. RESI</p>
                    <p style="font-family: Arial; font-size: 14px; color: var(--sage-dark); font-weight: bold;">{{ $order->tracking_number }}</p>
                </div>
                @endif
            </div>

            {{-- Produk --}}
            <div style="border-top: 1px solid var(--cream-dark); padding-top: 1.25rem;">
                @foreach($order->items as $item)
                <div style="display: flex; justify-content: space-between; align-items: center; {{ !$loop->last ? 'margin-bottom: 12px;' : '' }}">
                    <div>
                        <p style="font-size: 15px; color: var(--text-dark); margin-bottom: 2px;">{{ $item->product_name }}</p>
                        <p style="font-family: Arial; font-size: 12px; color: var(--text-muted);">{{ $item->quantity }} × {{ $item->formattedPrice }}</p>
                        @if($item->custom_notes)
                            <p style="font-family: Arial; font-size: 12px; color: #6a4c93; margin-top: 2px;">📝 {{ $item->custom_notes }}</p>
                        @endif
                    </div>
                    <p style="font-family: Arial; font-size: 14px; font-weight: bold; color: var(--sage-dark);">{{ $item->formattedSubtotal }}</p>
                </div>
                @endforeach
                <div style="border-top: 1px solid var(--cream-dark); margin-top: 12px; padding-top: 12px; display: flex; justify-content: space-between;">
                    <span style="font-family: Arial; font-size: 14px; color: var(--text-muted);">Total</span>
                    <span style="font-family: Arial; font-size: 16px; font-weight: bold; color: var(--sage-dark);">{{ $order->formattedTotal }}</span>
                </div>
            </div>
        </div>

        {{-- FOTO KUKU --}}
        @if($order->nail_photo_path)
        <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem; margin-bottom: 1.5rem;">
            <h2 style="font-size: 14px; font-family: Arial; letter-spacing: 1px; color: var(--sage-dark); margin-bottom: 1rem;">FOTO KUKU</h2>
            <img src="{{ $order->nail_photo_url }}" alt="Foto kuku" style="max-width: 200px; border: 1px solid var(--cream-dark);">
        </div>
        @endif

        {{-- UPLOAD BUKTI BAYAR --}}
        @if(in_array($order->payment_method, ['transfer', 'qris']) && $order->status === 'pending')
        <div style="background: var(--sage-pale); border: 1px solid var(--sage-light); padding: 1.5rem; margin-bottom: 1.5rem;">
            <h2 style="font-size: 14px; font-family: Arial; letter-spacing: 1px; color: var(--sage-dark); margin-bottom: 0.75rem;">UPLOAD BUKTI PEMBAYARAN</h2>
            <p style="font-family: Arial; font-size: 13px; color: var(--text-muted); margin-bottom: 1rem; line-height: 1.6;">
                Silakan transfer ke rekening admin lalu upload bukti pembayaran di sini. Admin akan mengkonfirmasi dalam 1×24 jam.
            </p>
            @if($order->payment_proof_path)
                <div style="margin-bottom: 1rem;">
                    <p style="font-family: Arial; font-size: 12px; color: var(--sage-dark); margin-bottom: 6px;">Bukti sudah diupload:</p>
                    <img src="{{ $order->payment_proof_url }}" alt="Bukti pembayaran" style="max-width: 160px; border: 1px solid var(--sage-light);">
                </div>
            @endif
            <form method="POST" action="{{ route('orders.upload-proof', $order) }}" enctype="multipart/form-data" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                @csrf
                <input type="file" name="payment_proof" accept="image/*" required style="font-family: Arial; font-size: 13px;">
                <button type="submit" style="background: var(--sage-dark); color: white; padding: 8px 20px; border: none; cursor: pointer; font-family: Arial; font-size: 12px; letter-spacing: 1px;">
                    UPLOAD
                </button>
            </form>
        </div>
        @endif

        {{-- TOMBOL BATAL --}}
        @if($order->isCancellable())
        <div style="text-align: right;">
            <form method="POST" action="{{ route('orders.cancel', $order) }}" onsubmit="return confirm('Yakin mau batalkan pesanan ini?')">
                @csrf
                <button type="submit" style="background: none; border: 1px solid #e57373; color: #c62828; padding: 8px 20px; cursor: pointer; font-family: Arial; font-size: 12px; letter-spacing: 1px;">
                    BATALKAN PESANAN
                </button>
            </form>
        </div>
        @endif
    </div>
</x-app-layout>