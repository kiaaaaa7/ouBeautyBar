<x-admin-layout>
    <x-slot name="title">Tambah Produk</x-slot>

    <div style="max-width: 760px;">
        <a href="{{ route('admin.products.index') }}"
           style="font-size: 13px; color: var(--text-muted); text-decoration: none; display: inline-block; margin-bottom: 1.5rem;">
            ← Kembali ke Daftar Produk
        </a>

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                {{-- INFO DASAR --}}
                <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                    <h2 style="font-size: 12px; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 1.25rem;">INFORMASI PRODUK</h2>

                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <div>
                            <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">NAMA PRODUK *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
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
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
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
                                onblur="this.style.borderColor='var(--cream-dark)'">{{ old('description') }}</textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div>
                                <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">HARGA (Rp) *</label>
                                <input type="number" name="price" value="{{ old('price') }}" min="0" required
                                    style="width: 100%; padding: 9px 12px; border: 1px solid var(--cream-dark); background: var(--cream); font-size: 14px; outline: none;"
                                    onfocus="this.style.borderColor='var(--sage-dark)'"
                                    onblur="this.style.borderColor='var(--cream-dark)'">
                            </div>
                            <div id="stockField">
                                <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">STOK *</label>
                                <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0"
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
                                {{ old('is_custom') ? 'checked' : '' }}
                                onchange="toggleStock(this)">
                            <span style="font-size: 14px; color: var(--text-dark);">Produk Custom Order</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}>
                            <span style="font-size: 14px; color: var(--text-dark);">Aktif (tampil di toko)</span>
                        </label>
                    </div>

                    <div id="customNote" style="display: {{ old('is_custom') ? 'block' : 'none' }}; margin-top: 1rem; background: var(--lavender-light); border-left: 3px solid var(--lavender); padding: 10px 14px;">
                        <p style="font-size: 12px; color: #6a4c93;">Produk custom tidak memerlukan stok — pembeli bisa order kapan saja.</p>
                    </div>
                </div>

                {{-- FOTO PRODUK --}}
                <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                    <h2 style="font-size: 12px; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 0.5rem;">FOTO PRODUK *</h2>
                    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 1.25rem;">Bisa upload lebih dari 1 foto. Foto pertama otomatis jadi foto utama.</p>

                    <div style="border: 2px dashed var(--sage-light); padding: 2rem; background: var(--cream); text-align: center;">
                        <p style="font-size: 2rem; margin-bottom: 0.5rem;">📸</p>
                        <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 1rem;">JPG, PNG, WEBP — maks. 5MB per foto</p>
                        <input type="file" name="images[]" accept="image/*" multiple required
                            style="font-size: 13px; color: var(--text-dark);"
                            onchange="previewImages(this)">
                    </div>

                    {{-- Preview --}}
                    <div id="imagePreview" style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 1rem;"></div>
                </div>

                {{-- SUBMIT --}}
                <div style="display: flex; gap: 1rem;">
                    <button type="submit"
                        style="background: var(--sage-dark); color: white; padding: 12px 32px; border: none; cursor: pointer; font-size: 13px; letter-spacing: 1px;">
                        SIMPAN PRODUK
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
            Array.from(input.files).forEach((file, i) => {
                const reader = new FileReader();
                reader.onload = e => {
                    const wrapper = document.createElement('div');
                    wrapper.style.cssText = 'position: relative; width: 80px; height: 80px;';
                    wrapper.innerHTML = `
                        <img src="${e.target.result}" style="width:80px;height:80px;object-fit:cover;border:1px solid var(--cream-dark);">
                        ${i === 0 ? '<span style="position:absolute;bottom:0;left:0;right:0;background:var(--sage-dark);color:white;font-size:9px;text-align:center;padding:2px;">UTAMA</span>' : ''}
                    `;
                    preview.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
</x-admin-layout>