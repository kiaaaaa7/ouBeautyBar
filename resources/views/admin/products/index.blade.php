<x-admin-layout>
    <x-slot name="title">Daftar Produk</x-slot>

    {{-- HEADER --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <div>
            <p style="font-size: 13px; color: var(--text-muted);">Total {{ $products->total() }} produk</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
           style="background: var(--sage-dark); color: white; padding: 9px 20px; text-decoration: none; font-size: 12px; letter-spacing: 1px;">
            + TAMBAH PRODUK
        </a>
    </div>

    {{-- TABEL --}}
    <div style="background: white; border: 1px solid var(--cream-dark); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <thead>
                <tr style="background: var(--cream); border-bottom: 1px solid var(--cream-dark);">
                    <th style="padding: 10px 1rem; text-align: left; font-size: 11px; letter-spacing: 0.5px; color: var(--text-muted); width: 60px;">FOTO</th>
                    <th style="padding: 10px 1rem; text-align: left; font-size: 11px; letter-spacing: 0.5px; color: var(--text-muted);">NAMA PRODUK</th>
                    <th style="padding: 10px 1rem; text-align: left; font-size: 11px; letter-spacing: 0.5px; color: var(--text-muted);">KATEGORI</th>
                    <th style="padding: 10px 1rem; text-align: left; font-size: 11px; letter-spacing: 0.5px; color: var(--text-muted);">HARGA</th>
                    <th style="padding: 10px 1rem; text-align: left; font-size: 11px; letter-spacing: 0.5px; color: var(--text-muted);">STOK</th>
                    <th style="padding: 10px 1rem; text-align: left; font-size: 11px; letter-spacing: 0.5px; color: var(--text-muted);">TIPE</th>
                    <th style="padding: 10px 1rem; text-align: left; font-size: 11px; letter-spacing: 0.5px; color: var(--text-muted);">STATUS</th>
                    <th style="padding: 10px 1rem; text-align: left; font-size: 11px; letter-spacing: 0.5px; color: var(--text-muted);"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr style="border-bottom: 1px solid var(--cream-dark);"
                    onmouseover="this.style.background='var(--cream)'"
                    onmouseout="this.style.background='white'">

                    {{-- Foto --}}
                    <td style="padding: 8px 1rem;">
                        <div style="width: 48px; height: 48px; overflow: hidden; background: var(--cream); flex-shrink: 0;">
                            @if($product->primaryImageUrl)
                                <img src="{{ $product->primaryImageUrl }}" alt="{{ $product->name }}"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">💅</div>
                            @endif
                        </div>
                    </td>

                    {{-- Nama --}}
                    <td style="padding: 8px 1rem;">
                        <p style="font-size: 14px; color: var(--text-dark); margin-bottom: 2px;">{{ $product->name }}</p>
                        <p style="font-size: 11px; color: var(--text-muted);">{{ $product->images->count() }} foto</p>
                    </td>

                    {{-- Kategori --}}
                    <td style="padding: 8px 1rem; color: var(--text-muted); font-size: 13px;">
                        {{ $product->category->name ?? '-' }}
                    </td>

                    {{-- Harga --}}
                    <td style="padding: 8px 1rem; font-weight: bold; color: var(--sage-dark);">
                        {{ $product->formattedPrice }}
                    </td>

                    {{-- Stok --}}
                    <td style="padding: 8px 1rem;">
                        @if($product->is_custom)
                            <span style="font-size: 12px; color: #6a4c93;">—</span>
                        @elseif($product->stock === 0)
                            <span style="color: #c62828; font-size: 13px; font-weight: bold;">Habis</span>
                        @elseif($product->stock <= 3)
                            <span style="color: #856404; font-size: 13px;">{{ $product->stock }} pcs ⚠</span>
                        @else
                            <span style="color: var(--text-dark); font-size: 13px;">{{ $product->stock }} pcs</span>
                        @endif
                    </td>

                    {{-- Tipe --}}
                    <td style="padding: 8px 1rem;">
                        @if($product->is_custom)
                            <span style="background: var(--lavender-light); color: #4a2c6a; padding: 3px 10px; font-size: 11px; letter-spacing: 0.5px;">CUSTOM</span>
                        @else
                            <span style="background: var(--sage-pale); color: var(--sage-dark); padding: 3px 10px; font-size: 11px; letter-spacing: 0.5px;">READY</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td style="padding: 8px 1rem;">
                        @if($product->is_active)
                            <span style="background: #e8f0dc; color: var(--sage-dark); padding: 3px 10px; font-size: 11px;">Aktif</span>
                        @else
                            <span style="background: #fde8e8; color: #c62828; padding: 3px 10px; font-size: 11px;">Nonaktif</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td style="padding: 8px 1rem;">
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               style="background: var(--sage-dark); color: white; padding: 5px 12px; text-decoration: none; font-size: 11px; letter-spacing: 0.5px;">
                                EDIT
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('Hapus produk {{ $product->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: none; border: 1px solid #e57373; color: #c62828; padding: 5px 10px; cursor: pointer; font-size: 11px;">
                                    HAPUS
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 3rem; text-align: center; color: var(--text-muted);">
                        Belum ada produk.
                        <a href="{{ route('admin.products.create') }}" style="color: var(--sage-dark);">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">{{ $products->links() }}</div>
</x-admin-layout>