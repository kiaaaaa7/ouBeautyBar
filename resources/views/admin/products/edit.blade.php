<x-admin-layout>
    <x-slot name="title">Edit Produk</x-slot>

    <div style="max-width: 760px;">
        <a href="{{ route('admin.products.index') }}"
           style="font-size: 13px; color: var(--text-muted); text-decoration: none; display: inline-block; margin-bottom: 1.5rem;">
            ← Kembali ke Daftar Produk
        </a>

        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                {{-- INFO DASAR --}}
                <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                    <h2 style="font-size: 12px; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 1.25rem;">INFORMASI PRODUK</h2>

                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <div>
                            <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">NAMA PRODUK *</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                                style="width: 100%; padding: 9px 12px; border: 1px solid var(--cream-dark); background: var(--cream); font-size: 14px; outline: none;"
                                onfocus="this.style.borderColor='var(--sage-dark)'"
                                onblur="this.style.borderColor='var(--cream-dark)'">
                        </div>

                        <div>
                            <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">KATEGORI *</label>
                            <select name="category_id" required
                                style="width: 100%; padding: 9px 12px; border: 1px solid var(--cream-dark); background: var(--cream); font-size: 14px; outline: none;">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">DESKRIPSI</label>
                            <textarea name="description" rows="4"
                                style="width: 100%; padding: 9px 12px; border: 1px solid var(--cream-dark); background: var(--cream); font-size: 14px; outline: none; resize: vertical;"
                                onfocus="this.style.borderColor='var(--sage-dark)'"
                                onblur="this.style.borderColor='var(--cream-dark)'">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div>
                                <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">HARGA (Rp) *</label>
                                <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" required
                                    style="width: 100%; padding: 9px 12px; border: 1px solid var(--cream-dark); background: var(--cream); font-size: 14px; outline: none;"
                                    onfocus="this.style.borderColor='var(--sage-dark)'"
                                    onblur="this.style.borderColor='var(--cream-dark)'">
                            </div>
                            <div id="stockField" style="{{ $product->is_custom ? 'opacity:0.4; pointer-events:none;' : '' }}">
                                <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">STOK</label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                                    style="width: 100%; padding: 9px 12px; border: 1px solid var(--cream-dark); background: var(--cream); font-size: 14px; outline: none;"
                                    onfocus="this.style.borderColor='var(--sage-dark)'"
                                    onblur="this.style.borderColor='var(--cream-dark)'">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TIPE & STATUS --}}
                <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                    <h2 style="font-size: 12px; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 1.25rem;">TIPE & STATUS</h2>
                    <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="is_custom" value="1" id="isCustom"
                                {{ old('is_custom', $product->is_custom) ? 'checked' : '' }}
                                onchange="toggleStock(this)">
                            <span style="font-size: 14px; color: var(--text-dark);">Produk Custom Order</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <span style="font-size: 14px; color: var(--text-dark);">Aktif (tampil di toko)</span>
                        </label>
                    </div>
                    <div id="customNote" style="display: {{ $product->is_custom ? 'block' : 'none' }}; margin-top: 1rem; background: var(--lavender-light); border-left: 3px solid var(--lavender); padding: 10px 14px;">
                        <p style="font-size: 12px; color: #6a4c93;">Produk custom tidak memerlukan stok.</p>
                    </div>
                </div>

                {{-- FOTO YANG ADA --}}
                @if($product->images->isNotEmpty())
                <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                    <h2 style="font-size: 12px; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 0.5rem;">FOTO SAAT INI</h2>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 1.25rem;">Klik "Utama" untuk ganti foto utama. Klik "Hapus" untuk menghapus foto.</p>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        @foreach($product->images as $img)
                        <div style="position: relative; width: 100px;">
                            <img src="{{ $img->url }}" alt=""
                                 style="width: 100px; height: 100px; object-fit: cover; border: 2px solid {{ $img->is_primary ? 'var(--sage-dark)' : 'var(--cream-dark)' }};">

                            @if($img->is_primary)
                                <div style="position: absolute; top: 0; left: 0; right: 0; background: var(--sage-dark); color: white; font-size: 9px; text-align: center; padding: 2px; letter-spacing: 0.5px;">UTAMA</div>
                            @endif

                            <div style="display: flex; gap: 4px; margin-top: 4px;">
                                @if(!$img->is_primary)
                                <form method="POST" action="{{ route('admin.product-images.primary', $img) }}" style="flex: 1;">
                                    @csrf
                                    <button type="submit" style="width: 100%; background: var(--sage-pale); border: 1px solid var(--sage-light); color: var(--sage-dark); padding: 3px 0; cursor: pointer; font-size: 10px;">
                                        Utama
                                    </button>
                                </form>
                                @endif
                                <form method="POST" action="{{ route('admin.product-images.destroy', $img) }}"
                                      onsubmit="return confirm('Hapus foto ini?')" style="{{ $img->is_primary ? 'flex: 1;' : '' }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="width: 100%; background: #fde8e8; border: 1px solid #f5c6cb; color: #c62828; padding: 3px 0; cursor: pointer; font-size: 10px;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- TAMBAH FOTO BARU --}}
                <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                    <h2 style="font-size: 12px; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 0.5rem;">TAMBAH FOTO BARU</h2>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 1.25rem;">Opsional — upload foto tambahan untuk produk ini.</p>

                    <div style="border: 2px dashed var(--sage-light); padding: 1.5rem; background: var(--cream); text-align: center;">
                        <input type="file" name="images[]" accept="image/*" multiple
                            style="font-size: 13px; color: var(--text-dark);"
                            onchange="previewImages(this)">
                    </div>
                    <div id="imagePreview" style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 1rem;"></div>
                </div>

                {{-- SUBMIT --}}
                <div style="display: flex; gap: 1rem;">
                    <button type="submit"
                        style="background: var(--sage-dark); color: white; padding: 12px 32px; border: none; cursor: pointer; font-size: 13px; letter-spacing: 1px;">
                        SIMPAN PERUBAHAN
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                       style="padding: 12px 24px; border: 1px solid var(--cream-dark); color: var(--text-muted); text-decoration: none; font-size: 13px;">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script>
        function toggleStock(el) {
            const stockField = document.getElementById('stockField');
            const customNote = document.getElementById('customNote');
            stockField.style.opacity = el.checked ? '0.4' : '1';
            stockField.style.pointerEvents = el.checked ? 'none' : 'auto';
            customNote.style.display = el.checked ? 'block' : 'none';
        }

        function previewImages(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.cssText = 'width:80px;height:80px;object-fit:cover;border:1px solid var(--cream-dark);';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
</x-admin-layout>