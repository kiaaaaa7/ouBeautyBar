<x-app-layout>
    <x-slot name="title">{{ $product->name }} — OuBeautyBar</x-slot>

    <div style="max-width: 1200px; margin: 0 auto; padding: 3rem 2rem;">

        {{-- Breadcrumb --}}
        <p style="font-family: Arial; font-size: 13px; color: var(--text-muted); margin-bottom: 2rem;">
            <a href="{{ route('home') }}" style="color: var(--text-muted); text-decoration: none;">Home</a>
            <span style="margin: 0 8px;">›</span>
            <a href="{{ route('products.index') }}" style="color: var(--text-muted); text-decoration: none;">Katalog</a>
            <span style="margin: 0 8px;">›</span>
            {{ $product->name }}
        </p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: start;">

            {{-- FOTO PRODUK --}}
            <div>
                {{-- Foto utama --}}
                <div style="aspect-ratio: 1; overflow: hidden; background: var(--cream); margin-bottom: 1rem;">
                    @if($product->primaryImageUrl)
                        <img id="mainImg" src="{{ $product->primaryImageUrl }}" alt="{{ $product->name }}"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 5rem;">💅</div>
                    @endif
                </div>

                {{-- Thumbnail --}}
                @if($product->images->count() > 1)
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    @foreach($product->images as $img)
                    <div onclick="document.getElementById('mainImg').src='{{ $img->url }}'"
                         style="width: 72px; height: 72px; overflow: hidden; cursor: pointer; border: 2px solid {{ $img->is_primary ? 'var(--sage-dark)' : 'transparent' }};">
                        <img src="{{ $img->url }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- DETAIL PRODUK --}}
            <div>
                <div style="display: flex; gap: 8px; margin-bottom: 1rem;">
                    <span style="background: {{ $product->is_custom ? 'var(--lavender)' : 'var(--sage-pale)' }}; color: {{ $product->is_custom ? '#4a2c6a' : 'var(--sage-dark)' }}; padding: 4px 12px; font-family: Arial; font-size: 11px; letter-spacing: 1px;">
                        {{ $product->is_custom ? 'CUSTOM ORDER' : 'READY STOCK' }}
                    </span>
                    <span style="background: var(--cream-dark); color: var(--text-muted); padding: 4px 12px; font-family: Arial; font-size: 11px; letter-spacing: 1px;">
                        {{ strtoupper($product->category->name ?? '') }}
                    </span>
                </div>

                <h1 style="font-size: 2rem; color: var(--text-dark); margin-bottom: 0.75rem; line-height: 1.2;">{{ $product->name }}</h1>

                <p style="font-size: 1.75rem; font-family: Arial; font-weight: bold; color: var(--sage-dark); margin-bottom: 1.5rem;">
                    {{ $product->formattedPrice }}
                </p>

                @if($product->description)
                <p style="font-family: Arial; font-size: 14px; color: var(--text-muted); line-height: 1.8; margin-bottom: 1.5rem;">
                    {{ $product->description }}
                </p>
                @endif

                {{-- Stok --}}
                @if(!$product->is_custom)
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1.5rem;">
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: {{ $product->stock > 0 ? '#6b7c52' : '#e57373' }};"></div>
                        <span style="font-family: Arial; font-size: 13px; color: var(--text-muted);">
                            {{ $product->stock > 0 ? 'Stok tersedia (' . $product->stock . ' pcs)' : 'Stok habis' }}
                        </span>
                    </div>
                @else
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1.5rem;">
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--lavender);"></div>
                        <span style="font-family: Arial; font-size: 13px; color: var(--text-muted);">Open order — estimasi 7-14 hari kerja</span>
                    </div>
                @endif

                {{-- Tombol Order --}}
                @if($product->isInStock())
                    @auth
                        <a href="{{ route('orders.create') }}?product_id={{ $product->id }}"
                           style="display: block; background: var(--sage-dark); color: white; text-align: center; padding: 16px; text-decoration: none; font-family: Arial; font-size: 13px; letter-spacing: 2px; margin-bottom: 1rem; transition: background 0.2s;"
                           onmouseover="this.style.background='var(--sage)'"
                           onmouseout="this.style.background='var(--sage-dark)'">
                            PESAN SEKARANG
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           style="display: block; background: var(--sage-dark); color: white; text-align: center; padding: 16px; text-decoration: none; font-family: Arial; font-size: 13px; letter-spacing: 2px; margin-bottom: 1rem;">
                            LOGIN UNTUK MEMESAN
                        </a>
                    @endauth
                @else
                    <button disabled style="display: block; width: 100%; background: var(--cream-dark); color: var(--text-muted); padding: 16px; border: none; font-family: Arial; font-size: 13px; letter-spacing: 2px; cursor: not-allowed; margin-bottom: 1rem;">
                        STOK HABIS
                    </button>
                @endif

                {{-- Info tambahan --}}
                <div style="border-top: 1px solid var(--cream-dark); padding-top: 1.5rem; display: flex; flex-direction: column; gap: 10px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 16px;">📦</span>
                        <span style="font-family: Arial; font-size: 13px; color: var(--text-muted);">Pengiriman via kurir atau COD</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 16px;">💳</span>
                        <span style="font-family: Arial; font-size: 13px; color: var(--text-muted);">Transfer Bank, QRIS, atau Bayar di Tempat</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 16px;">💅</span>
                        <span style="font-family: Arial; font-size: 13px; color: var(--text-muted);">Handmade premium quality</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- PRODUK TERKAIT --}}
        @if($related->isNotEmpty())
        <div style="margin-top: 5rem; border-top: 1px solid var(--cream-dark); padding-top: 3rem;">
            <h2 style="font-size: 1.5rem; color: var(--text-dark); margin-bottom: 2rem;">Produk Lainnya</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
                @foreach($related as $rel)
                <a href="{{ route('products.show', $rel->slug) }}" style="text-decoration: none; color: inherit;">
                    <div style="background: white; border: 1px solid var(--cream-dark); overflow: hidden;">
                        <div style="aspect-ratio: 1; overflow: hidden; background: var(--cream);">
                            @if($rel->primaryImageUrl)
                                <img src="{{ $rel->primaryImageUrl }}" alt="{{ $rel->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">💅</div>
                            @endif
                        </div>
                        <div style="padding: 0.75rem 1rem;">
                            <p style="font-size: 13px; color: var(--text-dark); margin-bottom: 4px;">{{ $rel->name }}</p>
                            <p style="font-size: 14px; font-family: Arial; font-weight: bold; color: var(--sage-dark);">{{ $rel->formattedPrice }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-app-layout>