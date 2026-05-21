<x-app-layout>
    <x-slot name="title">Katalog — OuBeautyBar</x-slot>

    {{-- HERO --}}
    <section style="background: linear-gradient(135deg, var(--sage-pale) 0%, var(--cream) 60%, var(--lavender-light) 100%); padding: 5rem 2rem 4rem;">
        <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
            <p style="font-family: Arial; font-size: 12px; letter-spacing: 2px; color: var(--sage); margin-bottom: 1rem;">✦ PRESS ON NAIL PREMIUM</p>
            <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); color: var(--text-dark); line-height: 1.1; margin-bottom: 1rem;">
                Pilih <em style="color: var(--sage);">Desain</em> Favoritmu
            </h1>
            <p style="font-family: Arial; font-size: 15px; color: var(--text-muted); max-width: 480px; margin: 0 auto 2rem; line-height: 1.7;">
                Ready stock & custom order. Handmade dengan bahan premium, tahan lama dan nyaman dipakai.
            </p>

            {{-- Search --}}
            <form method="GET" action="{{ route('products.index') }}" style="display: flex; gap: 0; max-width: 420px; margin: 0 auto;">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari produk..."
                    style="flex: 1; padding: 12px 16px; border: 1px solid var(--sage-light); background: white; font-family: Arial; font-size: 14px; outline: none;">
                <button type="submit"
                    style="background: var(--sage-dark); color: white; padding: 12px 20px; border: none; cursor: pointer; font-family: Arial; font-size: 13px; letter-spacing: 1px;">
                    CARI
                </button>
            </form>
        </div>
    </section>

    {{-- FILTER KATEGORI --}}
    <section style="background: white; border-bottom: 1px solid var(--cream-dark); padding: 1rem 2rem; position: sticky; top: 64px; z-index: 40;">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
            <a href="{{ route('products.index') }}"
               style="padding: 6px 16px; font-family: Arial; font-size: 13px; text-decoration: none; border: 1px solid {{ !request('type') && !request('category') ? 'var(--sage-dark)' : 'var(--sage-light)' }}; color: {{ !request('type') && !request('category') ? 'var(--sage-dark)' : 'var(--text-muted)' }}; background: {{ !request('type') && !request('category') ? 'var(--sage-pale)' : 'white' }};">
                Semua
            </a>
            <a href="{{ route('products.index') }}?type=ready"
               style="padding: 6px 16px; font-family: Arial; font-size: 13px; text-decoration: none; border: 1px solid {{ request('type') === 'ready' ? 'var(--sage-dark)' : 'var(--sage-light)' }}; color: {{ request('type') === 'ready' ? 'var(--sage-dark)' : 'var(--text-muted)' }}; background: {{ request('type') === 'ready' ? 'var(--sage-pale)' : 'white' }};">
                Ready Stock
            </a>
            <a href="{{ route('products.index') }}?type=custom"
               style="padding: 6px 16px; font-family: Arial; font-size: 13px; text-decoration: none; border: 1px solid {{ request('type') === 'custom' ? 'var(--sage-dark)' : 'var(--sage-light)' }}; color: {{ request('type') === 'custom' ? 'var(--sage-dark)' : 'var(--text-muted)' }}; background: {{ request('type') === 'custom' ? 'var(--sage-pale)' : 'white' }};">
                Custom Order
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('products.index') }}?category={{ $cat->slug }}"
               style="padding: 6px 16px; font-family: Arial; font-size: 13px; text-decoration: none; border: 1px solid {{ request('category') === $cat->slug ? 'var(--lavender)' : 'var(--sage-light)' }}; color: {{ request('category') === $cat->slug ? '#6a4c93' : 'var(--text-muted)' }}; background: {{ request('category') === $cat->slug ? 'var(--lavender-light)' : 'white' }};">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>
    </section>

    {{-- PRODUCT GRID --}}
    <section style="max-width: 1200px; margin: 0 auto; padding: 3rem 2rem;">
        @if($products->isEmpty())
            <div style="text-align: center; padding: 5rem 0; color: var(--text-muted);">
                <p style="font-size: 3rem; margin-bottom: 1rem;">🌸</p>
                <p style="font-family: Arial; font-size: 16px;">Produk tidak ditemukan.</p>
                <a href="{{ route('products.index') }}" style="color: var(--sage); font-family: Arial; font-size: 14px;">Lihat semua produk</a>
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.5rem;">
                @foreach($products as $product)
                <a href="{{ route('products.show', $product->slug) }}" style="text-decoration: none; color: inherit;">
                    <div style="background: white; border: 1px solid var(--cream-dark); overflow: hidden; transition: transform 0.2s, box-shadow 0.2s;"
                         onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 24px rgba(74,90,58,0.12)'"
                         onmouseout="this.style.transform=''; this.style.boxShadow=''">

                        {{-- Foto Produk --}}
                        <div style="aspect-ratio: 1; overflow: hidden; background: var(--cream); position: relative;">
                            @if($product->primaryImageUrl)
                                <img src="{{ $product->primaryImageUrl }}" alt="{{ $product->name }}"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--sage-light); font-size: 3rem;">💅</div>
                            @endif

                            {{-- Badge --}}
                            <div style="position: absolute; top: 10px; left: 10px;">
                                @if($product->is_custom)
                                    <span style="background: var(--lavender); color: #4a2c6a; padding: 3px 10px; font-family: Arial; font-size: 11px; letter-spacing: 1px;">CUSTOM</span>
                                @else
                                    <span style="background: var(--sage-pale); color: var(--sage-dark); padding: 3px 10px; font-family: Arial; font-size: 11px; letter-spacing: 1px;">READY</span>
                                @endif
                            </div>

                            @if(!$product->is_custom && $product->stock <= 3 && $product->stock > 0)
                                <div style="position: absolute; top: 10px; right: 10px;">
                                    <span style="background: #fff3cd; color: #856404; padding: 3px 8px; font-family: Arial; font-size: 11px;">Sisa {{ $product->stock }}</span>
                                </div>
                            @endif
                            @if(!$product->is_custom && $product->stock === 0)
                                <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center;">
                                    <span style="background: white; color: var(--text-dark); padding: 6px 16px; font-family: Arial; font-size: 12px; letter-spacing: 1px;">HABIS</span>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div style="padding: 1rem 1.2rem 1.2rem;">
                            <p style="font-size: 11px; font-family: Arial; color: var(--sage); letter-spacing: 1px; margin-bottom: 4px;">{{ strtoupper($product->category->name ?? '') }}</p>
                            <h3 style="font-size: 16px; color: var(--text-dark); margin-bottom: 8px; line-height: 1.3;">{{ $product->name }}</h3>
                            <p style="font-size: 16px; font-family: Arial; font-weight: bold; color: var(--sage-dark);">{{ $product->formattedPrice }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div style="margin-top: 3rem; display: flex; justify-content: center;">
                {{ $products->links() }}
            </div>
        @endif
    </section>
</x-app-layout>