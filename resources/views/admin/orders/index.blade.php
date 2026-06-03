<x-admin-layout>
    <x-slot name="title">Daftar Pesanan</x-slot>

    {{-- STATS --}}
    <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 1rem; margin-bottom: 2rem;">
        @php
            $statItems = [
                ['label' => 'Pending',      'status' => 'pending',    'color' => '#856404', 'bg' => '#fff9e6'],
                ['label' => 'Dikonfirmasi', 'status' => 'confirmed',  'color' => '#0c4a9e', 'bg' => '#e6f0ff'],
                ['label' => 'Diproses',     'status' => 'processing', 'color' => '#4a2c6a', 'bg' => '#f0e6ff'],
                ['label' => 'Dikirim',      'status' => 'shipped',    'color' => '#3730a3', 'bg' => '#e6e8ff'],
                ['label' => 'Selesai',      'status' => 'completed',  'color' => '#4a5a3a', 'bg' => '#e8f0dc'],
                ['label' => 'Dibatalkan',   'status' => 'cancelled',  'color' => '#c62828', 'bg' => '#fde8e8'],
            ];
        @endphp
        @foreach($statItems as $s)
        <a href="{{ route('admin.orders.index') }}?status={{ $s['status'] }}" style="text-decoration: none;">
            <div style="background: {{ $s['bg'] }}; padding: 1rem; border: 1px solid {{ $s['color'] }}22; text-align: center;">
                <p style="font-size: 22px; font-weight: bold; color: {{ $s['color'] }}; margin-bottom: 2px;">
                    {{ $statusCounts[$s['status']] ?? 0 }}
                </p>
                <p style="font-size: 11px; color: {{ $s['color'] }}; letter-spacing: 0.5px;">{{ $s['label'] }}</p>
            </div>
        </a>
        @endforeach
    </div>

    {{-- FILTER & SEARCH --}}
    <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.25rem; margin-bottom: 1.5rem;">
        <form method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;">
            <div>
                <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 4px; letter-spacing: 0.5px;">STATUS</label>
                <select name="status" style="padding: 8px 12px; border: 1px solid var(--cream-dark); background: var(--cream); font-size: 13px; outline: none;">
                    <option value="">Semua</option>
                    <option value="pending"    {{ request('status') === 'pending'    ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed"  {{ request('status') === 'confirmed'  ? 'selected' : '' }}>Dikonfirmasi</option>
                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Diproses</option>
                    <option value="shipped"    {{ request('status') === 'shipped'    ? 'selected' : '' }}>Dikirim</option>
                    <option value="completed"  {{ request('status') === 'completed'  ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled"  {{ request('status') === 'cancelled'  ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 4px; letter-spacing: 0.5px;">PEMBAYARAN</label>
                <select name="payment" style="padding: 8px 12px; border: 1px solid var(--cream-dark); background: var(--cream); font-size: 13px; outline: none;">
                    <option value="">Semua</option>
                    <option value="transfer" {{ request('payment') === 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="qris"     {{ request('payment') === 'qris'     ? 'selected' : '' }}>QRIS</option>
                    <option value="cod"      {{ request('payment') === 'cod'      ? 'selected' : '' }}>COD</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 4px; letter-spacing: 0.5px;">CARI</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nomor pesanan / nama / WA..."
                    style="width: 100%; padding: 8px 12px; border: 1px solid var(--cream-dark); background: var(--cream); font-size: 13px; outline: none;">
            </div>
            <button type="submit" style="background: var(--sage-dark); color: white; padding: 8px 20px; border: none; cursor: pointer; font-size: 12px; letter-spacing: 1px;">FILTER</button>
            <a href="{{ route('admin.orders.index') }}" style="padding: 8px 16px; border: 1px solid var(--cream-dark); color: var(--text-muted); font-size: 12px; text-decoration: none;">Reset</a>
        </form>
    </div>

    {{-- TABEL PESANAN --}}
    <div style="background: white; border: 1px solid var(--cream-dark); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
                <tr style="background: var(--cream); border-bottom: 1px solid var(--cream-dark);">
                    <th style="padding: 10px 1rem; text-align: left; font-size: 11px; letter-spacing: 0.5px; color: var(--text-muted);">NO. PESANAN</th>
                    <th style="padding: 10px 1rem; text-align: left; font-size: 11px; letter-spacing: 0.5px; color: var(--text-muted);">PEMBELI</th>
                    <th style="padding: 10px 1rem; text-align: left; font-size: 11px; letter-spacing: 0.5px; color: var(--text-muted);">PRODUK</th>
                    <th style="padding: 10px 1rem; text-align: left; font-size: 11px; letter-spacing: 0.5px; color: var(--text-muted);">TOTAL</th>
                    <th style="padding: 10px 1rem; text-align: left; font-size: 11px; letter-spacing: 0.5px; color: var(--text-muted);">BAYAR</th>
                    <th style="padding: 10px 1rem; text-align: left; font-size: 11px; letter-spacing: 0.5px; color: var(--text-muted);">STATUS</th>
                    <th style="padding: 10px 1rem; text-align: left; font-size: 11px; letter-spacing: 0.5px; color: var(--text-muted);">TANGGAL</th>
                    <th style="padding: 10px 1rem; text-align: left; font-size: 11px; letter-spacing: 0.5px; color: var(--text-muted);"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
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
                <tr style="border-bottom: 1px solid var(--cream-dark);"
                    onmouseover="this.style.background='var(--cream)'"
                    onmouseout="this.style.background='white'">
                    <td style="padding: 10px 1rem; font-weight: bold; color: var(--sage-dark);">{{ $order->order_number }}</td>
                    <td style="padding: 10px 1rem;">
                        <p style="margin-bottom: 2px;">{{ $order->buyer_name }}</p>
                        <p style="font-size: 11px; color: var(--text-muted);">{{ $order->buyer_whatsapp }}</p>
                    </td>
                    <td style="padding: 10px 1rem; color: var(--text-muted);">
                        {{ $order->items->count() }} item
                    </td>
                    <td style="padding: 10px 1rem; font-weight: bold;">{{ $order->formattedTotal }}</td>
                    <td style="padding: 10px 1rem;">
                        <span style="font-size: 11px; color: var(--text-muted);">{{ $order->payment_label }}</span>
                        @if($order->payment_proof_path && $order->status === 'pending')
                            <br><span style="font-size: 10px; color: #856404;">⚠ Ada bukti TF</span>
                        @endif
                    </td>
                    <td style="padding: 10px 1rem;">
                        <span style="padding: 3px 10px; font-size: 11px; letter-spacing: 0.3px; background: {{ $c['bg'] }}; color: {{ $c['text'] }};">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td style="padding: 10px 1rem; font-size: 12px; color: var(--text-muted);">
                        {{ $order->created_at->format('d M Y') }}<br>
                        <span style="font-size: 11px;">{{ $order->created_at->format('H:i') }}</span>
                    </td>
                    <td style="padding: 10px 1rem;">
                        <a href="{{ route('admin.orders.show', $order) }}"
                           style="background: var(--sage-dark); color: white; padding: 5px 14px; text-decoration: none; font-size: 11px; letter-spacing: 0.5px;">
                            DETAIL
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 3rem; text-align: center; color: var(--text-muted);">Tidak ada pesanan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">{{ $orders->links() }}</div>
</x-admin-layout>