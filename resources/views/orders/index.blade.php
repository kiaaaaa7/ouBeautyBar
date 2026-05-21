<x-app-layout>
    <x-slot name="title">Pesanan Saya — OuBeautyBar</x-slot>

    <div style="max-width: 800px; margin: 0 auto; padding: 3rem 2rem;">
        <h1 style="font-size: 2rem; color: var(--text-dark); margin-bottom: 0.5rem;">Pesanan Saya</h1>
        <p style="font-family: Arial; font-size: 14px; color: var(--text-muted); margin-bottom: 3rem;">Pantau status pesananmu di sini</p>

        @if($orders->isEmpty())
            <div style="text-align: center; padding: 5rem 0; background: white; border: 1px solid var(--cream-dark);">
                <p style="font-size: 3rem; margin-bottom: 1rem;">🛍️</p>
                <p style="font-family: Arial; font-size: 16px; color: var(--text-muted); margin-bottom: 1.5rem;">Belum ada pesanan</p>
                <a href="{{ route('products.index') }}"
                   style="background: var(--sage-dark); color: white; padding: 12px 24px; text-decoration: none; font-family: Arial; font-size: 13px; letter-spacing: 1px;">
                    MULAI BELANJA
                </a>
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($orders as $order)
                <div style="background: white; border: 1px solid var(--cream-dark); overflow: hidden;">

                    {{-- Header --}}
                    <div style="padding: 1rem 1.25rem; background: var(--cream); border-bottom: 1px solid var(--cream-dark); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                        <div>
                            <p style="font-family: Arial; font-size: 12px; color: var(--text-muted); margin-bottom: 2px; letter-spacing: 0.5px;">NOMOR PESANAN</p>
                            <p style="font-family: Arial; font-size: 14px; font-weight: bold; color: var(--text-dark);">{{ $order->order_number }}</p>
                        </div>
                        <div style="text-align: right;">
                            <p style="font-family: Arial; font-size: 11px; color: var(--text-muted); margin-bottom: 4px;">{{ $order->created_at->format('d M Y') }}</p>
                            @php $color = $order->status_color; @endphp
                            <span style="padding: 4px 12px; font-family: Arial; font-size: 11px; letter-spacing: 0.5px;
                                background: {{ [
                                    'yellow' => '#fff9e6', 'blue' => '#e6f0ff', 'purple' => '#f0e6ff',
                                    'indigo' => '#e6e8ff', 'green' => 'var(--sage-pale)', 'red' => '#fde8e8'
                                ][$color] ?? '#f5f5f5' }};
                                color: {{ [
                                    'yellow' => '#856404', 'blue' => '#0c4a9e', 'purple' => '#4a2c6a',
                                    'indigo' => '#3730a3', 'green' => 'var(--sage-dark)', 'red' => '#c62828'
                                ][$color] ?? '#333' }};">
                                {{ $order->status_label }}
                            </span>
                        </div>
                    </div>

                    {{-- Items --}}
                    <div style="padding: 1rem 1.25rem; border-bottom: 1px solid var(--cream-dark);">
                        @foreach($order->items as $item)
                        <div style="display: flex; justify-content: space-between; align-items: center; {{ !$loop->last ? 'margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid var(--cream-dark);' : '' }}">
                            <div>
                                <p style="font-size: 14px; color: var(--text-dark);">{{ $item->product_name }}</p>
                                <p style="font-family: Arial; font-size: 12px; color: var(--text-muted);">{{ $item->quantity }} × {{ $item->formattedPrice }}</p>
                            </div>
                            <p style="font-family: Arial; font-size: 14px; font-weight: bold; color: var(--sage-dark);">{{ $item->formattedSubtotal }}</p>
                        </div>
                        @endforeach
                    </div>

                    {{-- Footer --}}
                    <div style="padding: 1rem 1.25rem; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <p style="font-family: Arial; font-size: 12px; color: var(--text-muted);">Total</p>
                            <p style="font-family: Arial; font-size: 16px; font-weight: bold; color: var(--sage-dark);">{{ $order->formattedTotal }}</p>
                        </div>
                        <a href="{{ route('orders.show', $order) }}"
                           style="background: var(--sage-dark); color: white; padding: 8px 20px; text-decoration: none; font-family: Arial; font-size: 12px; letter-spacing: 1px;">
                            DETAIL
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div style="margin-top: 2rem;">{{ $orders->links() }}</div>
        @endif
    </div>
</x-app-layout>