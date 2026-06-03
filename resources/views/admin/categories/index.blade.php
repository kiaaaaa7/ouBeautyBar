<x-admin-layout>
    <x-slot name="title">Kelola Kategori</x-slot>

    <div style="display: grid; grid-template-columns: 1fr 360px; gap: 1.5rem; align-items: start;">

        {{-- KIRI: DAFTAR KATEGORI --}}
        <div style="background: white; border: 1px solid var(--cream-dark); overflow: hidden;">
            <div style="padding: 1rem 1.25rem; background: var(--cream); border-bottom: 1px solid var(--cream-dark);">
                <p style="font-size: 12px; letter-spacing: 1px; color: var(--text-muted);">DAFTAR KATEGORI ({{ $categories->count() }})</p>
            </div>

            @forelse($categories as $cat)
            <div style="display: flex; align-items: center; gap: 12px; padding: 1rem 1.25rem; border-bottom: 1px solid var(--cream-dark);"
                 onmouseover="this.style.background='var(--cream)'"
                 onmouseout="this.style.background='white'">

                {{-- Foto kategori --}}
                <div style="width: 48px; height: 48px; flex-shrink: 0; overflow: hidden; background: var(--cream-dark);">
                    @if($cat->image)
                        <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">🗂️</div>
                    @endif
                </div>

                {{-- Info --}}
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 2px;">
                        <p style="font-size: 14px; color: var(--text-dark);">{{ $cat->name }}</p>
                        @if(!$cat->is_active)
                            <span style="background: #fde8e8; color: #c62828; padding: 2px 8px; font-size: 10px; letter-spacing: 0.5px;">NONAKTIF</span>
                        @endif
                    </div>
                    <p style="font-size: 12px; color: var(--text-muted);">{{ $cat->products_count }} produk</p>
                </div>

                {{-- Aksi --}}
                <div style="display: flex; gap: 8px; flex-shrink: 0;">
                    {{-- Tombol edit — isi form edit via JS --}}
                    <button onclick="fillEditForm({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ addslashes($cat->description) }}', {{ $cat->is_active ? 'true' : 'false' }})"
                        style="background: var(--sage-pale); border: 1px solid var(--sage-light); color: var(--sage-dark); padding: 5px 12px; cursor: pointer; font-size: 11px; letter-spacing: 0.5px;">
                        EDIT
                    </button>
                    <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                          onsubmit="return confirm('Hapus kategori {{ $cat->name }}? Tidak bisa dihapus jika masih ada produk.')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background: none; border: 1px solid #e57373; color: #c62828; padding: 5px 10px; cursor: pointer; font-size: 11px;">
                            HAPUS
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div style="padding: 3rem; text-align: center; color: var(--text-muted); font-size: 13px;">
                Belum ada kategori. Tambahkan di sebelah kanan.
            </div>
            @endforelse
        </div>

        {{-- KANAN: FORM TAMBAH / EDIT --}}
        <div style="position: sticky; top: 20px;">

            {{-- FORM TAMBAH --}}
            <div id="formTambah" style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem; margin-bottom: 1.5rem;">
                <h2 style="font-size: 12px; letter-spacing: 1px; color: var(--text-muted); margin-bottom: 1.25rem;">TAMBAH KATEGORI</h2>

                <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <div>
                            <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">NAMA KATEGORI *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                placeholder="cth: Ready Stock, Glitter, Nude..."
                                style="width: 100%; padding: 9px 12px; border: 1px solid var(--cream-dark); background: var(--cream); font-size: 14px; outline: none;"
                                onfocus="this.style.borderColor='var(--sage-dark)'"
                                onblur="this.style.borderColor='var(--cream-dark)'">
                        </div>
                        <div>
                            <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">DESKRIPSI</label>
                            <textarea name="description" rows="2"
                                style="width: 100%; padding: 9px 12px; border: 1px solid var(--cream-dark); background: var(--cream); font-size: 14px; outline: none; resize: vertical;"
                                onfocus="this.style.borderColor='var(--sage-dark)'"
                                onblur="this.style.borderColor='var(--cream-dark)'">{{ old('description') }}</textarea>
                        </div>
                        <div>
                            <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">FOTO BANNER (opsional)</label>
                            <input type="file" name="image" accept="image/*"
                                style="font-size: 13px; color: var(--text-dark);">
                        </div>
                        <button type="submit"
                            style="background: var(--sage-dark); color: white; padding: 10px; border: none; cursor: pointer; font-size: 12px; letter-spacing: 1px;">
                            + TAMBAH KATEGORI
                        </button>
                    </div>
                </form>
            </div>

            {{-- FORM EDIT (tersembunyi, muncul saat klik EDIT) --}}
            <div id="formEdit" style="background: white; border: 2px solid var(--sage-light); padding: 1.5rem; display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                    <h2 style="font-size: 12px; letter-spacing: 1px; color: var(--sage-dark);">EDIT KATEGORI</h2>
                    <button onclick="cancelEdit()" style="background: none; border: none; cursor: pointer; font-size: 12px; color: var(--text-muted);">✕ Batal</button>
                </div>

                <form id="editForm" method="POST" action="" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <div>
                            <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">NAMA KATEGORI *</label>
                            <input type="text" name="name" id="editName" required
                                style="width: 100%; padding: 9px 12px; border: 1px solid var(--cream-dark); background: var(--cream); font-size: 14px; outline: none;"
                                onfocus="this.style.borderColor='var(--sage-dark)'"
                                onblur="this.style.borderColor='var(--cream-dark)'">
                        </div>
                        <div>
                            <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">DESKRIPSI</label>
                            <textarea name="description" id="editDesc" rows="2"
                                style="width: 100%; padding: 9px 12px; border: 1px solid var(--cream-dark); background: var(--cream); font-size: 14px; outline: none; resize: vertical;"
                                onfocus="this.style.borderColor='var(--sage-dark)'"
                                onblur="this.style.borderColor='var(--cream-dark)'"></textarea>
                        </div>
                        <div>
                            <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">GANTI FOTO (opsional)</label>
                            <input type="file" name="image" accept="image/*"
                                style="font-size: 13px; color: var(--text-dark);">
                        </div>
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="is_active" id="editActive" value="1">
                            <span style="font-size: 14px; color: var(--text-dark);">Aktif</span>
                        </label>
                        <button type="submit"
                            style="background: var(--sage-dark); color: white; padding: 10px; border: none; cursor: pointer; font-size: 12px; letter-spacing: 1px;">
                            SIMPAN PERUBAHAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const baseUrl = '{{ url("admin/categories") }}';

        function fillEditForm(id, name, desc, isActive) {
            document.getElementById('editForm').action = baseUrl + '/' + id;
            document.getElementById('editName').value = name;
            document.getElementById('editDesc').value = desc;
            document.getElementById('editActive').checked = isActive;
            document.getElementById('formEdit').style.display = 'block';
            document.getElementById('formTambah').style.display = 'none';
            document.getElementById('formEdit').scrollIntoView({ behavior: 'smooth' });
        }

        function cancelEdit() {
            document.getElementById('formEdit').style.display = 'none';
            document.getElementById('formTambah').style.display = 'block';
        }
    </script>
</x-admin-layout>