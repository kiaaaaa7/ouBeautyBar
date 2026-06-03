<x-admin-layout>
    <x-slot name="title">{{ $order->order_number }}</x-slot>

    <div style="display: grid; grid-template-columns: 1fr 340px; gap: 1.5rem; align-items: start;">

        {{-- KIRI --}}
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">

            {{-- INFO PEMBELI --}}
            <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                <h2 style="font-size: 12px; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 1.25rem;">INFORMASI PEMBELI</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <p style="font-size: 11px; color: var(--text-muted); margin-bottom: 3px; letter-spacing: 0.5px;">NAMA</p>
                        <p style="font-size: 14px; color: var(--text-dark);">{{ $order->buyer_name }}</p>
                    </div>
                    <div>
                        <p style="font-size: 11px; color: var(--text-muted); margin-bottom: 3px; letter-spacing: 0.5px;">WHATSAPP</p>
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $order->buyer_whatsapp) }}" target="_blank"
                           style="font-size: 14px; color: var(--sage-dark); text-decoration: none;">
                            {{ $order->buyer_whatsapp }} ↗
                        </a>
                    </div>
                    <div style="grid-column: span 2;">
                        <p style="font-size: 11px; color: var(--text-muted); margin-bottom: 3px; letter-spacing: 0.5px;">ALAMAT</p>
                        <p style="font-size: 14px; color: var(--text-dark); line-height: 1.6;">
                            {{ $order->buyer_address }}<br>
                            {{ $order->buyer_city }}, {{ $order->buyer_postal_code }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- DETAIL PRODUK --}}
            <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                <h2 style="font-size: 12px; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 1.25rem;">DETAIL PRODUK</h2>
                @foreach($order->items as $item)
                <div style="padding: 1rem; background: var(--cream); margin-bottom: 0.75rem;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                        <div>
                            <p style="font-size: 15px; color: var(--text-dark); margin-bottom: 2px;">{{ $item->product_name }}</p>
                            <p style="font-size: 12px; color: var(--text-muted);">{{ $item->quantity }} × {{ $item->formattedPrice }}</p>
                        </div>
                        <p style="font-size: 14px; font-weight: bold; color: var(--sage-dark);">{{ $item->formattedSubtotal }}</p>
                    </div>
                    @if($item->custom_notes)
                    <div style="background: var(--lavender-light); border-left: 3px solid var(--lavender); padding: 8px 12px; margin-top: 8px;">
                        <p style="font-size: 11px; color: #6a4c93; letter-spacing: 0.5px; margin-bottom: 3px;">CATATAN CUSTOM</p>
                        <p style="font-size: 13px; color: var(--text-dark);">{{ $item->custom_notes }}</p>
                    </div>
                    @endif
                    @if($item->custom_design_path)
                    <div style="margin-top: 8px;">
                        <p style="font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">FOTO REFERENSI DESAIN</p>
                        <a href="{{ $item->custom_design_url }}" target="_blank">
                            <img src="{{ $item->custom_design_url }}" alt="Referensi desain"
                                 style="max-width: 160px; max-height: 160px; object-fit: cover; border: 1px solid var(--cream-dark);">
                        </a>
                    </div>
                    @endif
                </div>
                @endforeach

                {{-- Total --}}
                <div style="border-top: 1px solid var(--cream-dark); padding-top: 1rem; margin-top: 0.5rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                        <span style="font-size: 13px; color: var(--text-muted);">Subtotal produk</span>
                        <span style="font-size: 13px;">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                        <span style="font-size: 13px; color: var(--text-muted);">Ongkir</span>
                        <span style="font-size: 13px;">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; border-top: 1px solid var(--cream-dark); padding-top: 8px; margin-top: 4px;">
                        <span style="font-size: 14px; font-weight: bold;">Total</span>
                        <span style="font-size: 16px; font-weight: bold; color: var(--sage-dark);">{{ $order->formattedTotal }}</span>
                    </div>
                </div>
            </div>

            {{-- FOTO KUKU --}}
            @if($order->nail_photo_path)
            <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                <h2 style="font-size: 12px; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 1rem;">FOTO KUKU PEMBELI</h2>
                <a href="{{ $order->nail_photo_url }}" target="_blank">
                    <img src="{{ $order->nail_photo_url }}" alt="Foto kuku"
                         style="max-width: 240px; max-height: 240px; object-fit: cover; border: 1px solid var(--cream-dark);">
                </a>
                <p style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Klik foto untuk memperbesar</p>
            </div>
            @endif

            {{-- BUKTI PEMBAYARAN --}}
            @if($order->payment_proof_path)
            <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h2 style="font-size: 12px; letter-spacing: 1px; color: var(--text-muted);">BUKTI PEMBAYARAN</h2>
                    @if(!$order->payment_confirmed_at)
                    <form method="POST" action="{{ route('admin.orders.confirm-payment', $order) }}">
                        @csrf
                        <button type="submit" style="background: var(--sage-dark); color: white; padding: 6px 16px; border: none; cursor: pointer; font-size: 11px; letter-spacing: 0.5px;">
                            ✓ KONFIRMASI BAYAR
                        </button>
                    </form>
                    @else
                    <span style="font-size: 12px; color: var(--sage-dark);">✓ Dikonfirmasi {{ $order->payment_confirmed_at->format('d M Y H:i') }}</span>
                    @endif
                </div>
                <a href="{{ $order->payment_proof_url }}" target="_blank">
                    <img src="{{ $order->payment_proof_url }}" alt="Bukti pembayaran"
                         style="max-width: 240px; max-height: 300px; object-fit: cover; border: 1px solid var(--cream-dark);">
                </a>
            </div>
            @endif

            {{-- CATATAN --}}
            @if($order->notes)
            <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                <h2 style="font-size: 12px; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 0.75rem;">CATATAN PEMBELI</h2>
                <p style="font-size: 14px; color: var(--text-dark); line-height: 1.6;">{{ $order->notes }}</p>
            </div>
            @endif
        </div>

        {{-- KANAN: UPDATE STATUS --}}
        <div style="position: sticky; top: 20px; display: flex; flex-direction: column; gap: 1.5rem;">

            {{-- Status sekarang --}}
            @php
                $colorMap = [
                    'pending'    => ['bg' => '#fff9e6', 'text' => '#856404'],
                    'confirmed'  => ['bg' => '#e6f0ff', 'text' => '#0c4a9e'],
                    'processing' => ['bg' => '#f0e6ff', 'text' => '#4a2c6a'],
                    'shipped'    => ['bg' => '#e6e8ff', 'text' => '#3730a3'],
                    'completed'  => ['bg' => '#e8f0dc', 'text' => '#4a5a3a'],
                    'cancelled'  => ['bg' => '#fde8e8', 'text' => '#c62828'],
                ];
                $c = $colorMap[$order->status] ?? ['bg' => '#f5f5f5', 'text' => '#333'];
            @endphp
            <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                <h2 style="font-size: 12px; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 1rem;">STATUS PESANAN</h2>

                <div style="background: {{ $c['bg'] }}; padding: 10px 16px; text-align: center; margin-bottom: 1.25rem;">
                    <p style="font-size: 16px; font-weight: bold; color: {{ $c['text'] }};">{{ $order->status_label }}</p>
                </div>

                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                    @csrf
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">UBAH STATUS KE</label>
                        <select name="status" style="width: 100%; padding: 8px 12px; border: 1px solid var(--cream-dark); background: var(--cream); font-size: 13px; outline: none;">
                            <option value="pending"    {{ $order->status === 'pending'    ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="confirmed"  {{ $order->status === 'confirmed'  ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="shipped"    {{ $order->status === 'shipped'    ? 'selected' : '' }}>Dikirim</option>
                            <option value="completed"  {{ $order->status === 'completed'  ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled"  {{ $order->status === 'cancelled'  ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <div id="trackingField" style="margin-bottom: 1rem; display: {{ $order->status === 'shipped' ? 'block' : 'none' }};">
                        <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">NOMOR RESI</label>
                        <input type="text" name="tracking_number" value="{{ $order->tracking_number }}"
                               placeholder="Masukkan nomor resi..."
                               style="width: 100%; padding: 8px 12px; border: 1px solid var(--cream-dark); background: var(--cream); font-size: 13px; outline: none;">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">CATATAN ADMIN (opsional)</label>
                        <textarea name="admin_notes" rows="2" placeholder="Catatan internal..."
                            style="width: 100%; padding: 8px 12px; border: 1px solid var(--cream-dark); background: var(--cream); font-size: 13px; outline: none; resize: vertical;">{{ $order->admin_notes }}</textarea>
                    </div>

                    <button type="submit" style="width: 100%; background: var(--sage-dark); color: white; padding: 10px; border: none; cursor: pointer; font-size: 12px; letter-spacing: 1px;">
                        UPDATE STATUS
                    </button>
                </form>
            </div>

            {{-- Info pengiriman & pembayaran --}}
            <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                <h2 style="font-size: 12px; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 1rem;">INFO PESANAN</h2>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <div>
                        <p style="font-size: 11px; color: var(--text-muted); margin-bottom: 2px; letter-spacing: 0.5px;">NOMOR PESANAN</p>
                        <p style="font-size: 13px; font-weight: bold; color: var(--sage-dark);">{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p style="font-size: 11px; color: var(--text-muted); margin-bottom: 2px; letter-spacing: 0.5px;">TANGGAL ORDER</p>
                        <p style="font-size: 13px; color: var(--text-dark);">{{ $order->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div>
                        <p style="font-size: 11px; color: var(--text-muted); margin-bottom: 2px; letter-spacing: 0.5px;">PEMBAYARAN</p>
                        <p style="font-size: 13px; color: var(--text-dark);">{{ $order->payment_label }}</p>
                    </div>
                    <div>
                        <p style="font-size: 11px; color: var(--text-muted); margin-bottom: 2px; letter-spacing: 0.5px;">PENGIRIMAN</p>
                        <p style="font-size: 13px; color: var(--text-dark);">
                            {{ $order->shipping_method === 'courier' ? ($order->courier_name ?? 'Kurir') : 'COD / Antar Sendiri' }}
                        </p>
                    </div>
                    @if($order->tracking_number)
                    <div>
                        <p style="font-size: 11px; color: var(--text-muted); margin-bottom: 2px; letter-spacing: 0.5px;">NO. RESI</p>
                        <p style="font-size: 13px; font-weight: bold; color: var(--sage-dark);">{{ $order->tracking_number }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <a href="{{ route('admin.orders.index') }}"
               style="display: block; text-align: center; padding: 10px; border: 1px solid var(--cream-dark); color: var(--text-muted); text-decoration: none; font-size: 12px; letter-spacing: 0.5px;">
                ← Kembali ke Daftar Pesanan
            </a>
        </div>
    </div>

    <script>
        document.querySelector('select[name="status"]').addEventListener('change', function() {
            document.getElementById('trackingField').style.display = this.value === 'shipped' ? 'block' : 'none';
        });
    </script>
</x-admin-layout>