<x-app-layout>
    <x-slot name="title">Checkout — OuBeautyBar</x-slot>

    <div style="max-width: 900px; margin: 0 auto; padding: 3rem 2rem;">
        <h1 style="font-size: 2rem; color: var(--text-dark); margin-bottom: 0.5rem;">Checkout</h1>
        <p style="font-family: Arial; font-size: 14px; color: var(--text-muted); margin-bottom: 3rem;">Lengkapi data pemesananmu di bawah ini</p>

        <form method="POST" action="{{ route('orders.store') }}" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div style="display: grid; grid-template-columns: 1fr 360px; gap: 2rem; align-items: start;">

                {{-- KIRI: FORM --}}
                <div style="display: flex; flex-direction: column; gap: 2rem;">

                    {{-- INFO PRIBADI --}}
                    <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                        <h2 style="font-size: 14px; font-family: Arial; letter-spacing: 1px; color: var(--sage-dark); margin-bottom: 1.25rem;">INFORMASI PRIBADI</h2>

                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div>
                                <label style="display: block; font-family: Arial; font-size: 12px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">NAMA LENGKAP *</label>
                                <input type="text" name="buyer_name" value="{{ old('buyer_name', auth()->user()->name) }}"
                                    style="width: 100%; padding: 10px 12px; border: 1px solid var(--sage-light); background: var(--cream); font-family: Arial; font-size: 14px; outline: none;"
                                    onfocus="this.style.borderColor='var(--sage-dark)'"
                                    onblur="this.style.borderColor='var(--sage-light)'" required>
                            </div>
                            <div>
                                <label style="display: block; font-family: Arial; font-size: 12px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">NO. WHATSAPP *</label>
                                <input type="text" name="buyer_whatsapp" value="{{ old('buyer_whatsapp') }}"
                                    placeholder="08xxxxxxxxxx"
                                    style="width: 100%; padding: 10px 12px; border: 1px solid var(--sage-light); background: var(--cream); font-family: Arial; font-size: 14px; outline: none;"
                                    onfocus="this.style.borderColor='var(--sage-dark)'"
                                    onblur="this.style.borderColor='var(--sage-light)'" required>
                            </div>
                            <div>
                                <label style="display: block; font-family: Arial; font-size: 12px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">ALAMAT LENGKAP *</label>
                                <textarea name="buyer_address" rows="3"
                                    style="width: 100%; padding: 10px 12px; border: 1px solid var(--sage-light); background: var(--cream); font-family: Arial; font-size: 14px; outline: none; resize: vertical;"
                                    onfocus="this.style.borderColor='var(--sage-dark)'"
                                    onblur="this.style.borderColor='var(--sage-light)'" required>{{ old('buyer_address') }}</textarea>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div>
                                    <label style="display: block; font-family: Arial; font-size: 12px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">KOTA *</label>
                                    <input type="text" name="buyer_city" value="{{ old('buyer_city') }}"
                                        style="width: 100%; padding: 10px 12px; border: 1px solid var(--sage-light); background: var(--cream); font-family: Arial; font-size: 14px; outline: none;"
                                        onfocus="this.style.borderColor='var(--sage-dark)'"
                                        onblur="this.style.borderColor='var(--sage-light)'" required>
                                </div>
                                <div>
                                    <label style="display: block; font-family: Arial; font-size: 12px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">KODE POS *</label>
                                    <input type="text" name="buyer_postal_code" value="{{ old('buyer_postal_code') }}"
                                        style="width: 100%; padding: 10px 12px; border: 1px solid var(--sage-light); background: var(--cream); font-family: Arial; font-size: 14px; outline: none;"
                                        onfocus="this.style.borderColor='var(--sage-dark)'"
                                        onblur="this.style.borderColor='var(--sage-light)'" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- FOTO KUKU --}}
                    <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                        <h2 style="font-size: 14px; font-family: Arial; letter-spacing: 1px; color: var(--sage-dark); margin-bottom: 0.5rem;">FOTO KUKU</h2>
                        <p style="font-family: Arial; font-size: 12px; color: var(--text-muted); margin-bottom: 1.25rem; line-height: 1.6;">
                            Upload foto kuku kamu (tangan direntangkan lurus) agar admin bisa menyesuaikan ukuran press on nail yang tepat.
                        </p>
                        <div style="border: 2px dashed var(--sage-light); padding: 2rem; text-align: center; background: var(--cream);">
                            <p style="font-size: 2rem; margin-bottom: 0.5rem;">💅</p>
                            <p style="font-family: Arial; font-size: 13px; color: var(--text-muted); margin-bottom: 1rem;">JPG, PNG — maks. 5MB</p>
                            <input type="file" name="nail_photo" accept="image/*" required
                                style="font-family: Arial; font-size: 13px; color: var(--text-dark);">
                        </div>
                    </div>

                    {{-- CUSTOM ORDER (tampil jika produk custom) --}}
                    @if($product->is_custom)
                    <div style="background: var(--lavender-light); border: 1px solid var(--lavender); padding: 1.5rem;">
                        <h2 style="font-size: 14px; font-family: Arial; letter-spacing: 1px; color: #4a2c6a; margin-bottom: 0.5rem;">DETAIL CUSTOM ORDER</h2>
                        <p style="font-family: Arial; font-size: 12px; color: #6a4c93; margin-bottom: 1.25rem;">Upload foto referensi desain dan tuliskan detail keinginanmu.</p>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div>
                                <label style="display: block; font-family: Arial; font-size: 12px; color: #6a4c93; margin-bottom: 6px; letter-spacing: 0.5px;">FOTO REFERENSI DESAIN (opsional)</label>
                                <input type="file" name="custom_design" accept="image/*"
                                    style="font-family: Arial; font-size: 13px; color: var(--text-dark);">
                            </div>
                            <div>
                                <label style="display: block; font-family: Arial; font-size: 12px; color: #6a4c93; margin-bottom: 6px; letter-spacing: 0.5px;">CATATAN DESAIN</label>
                                <textarea name="custom_notes" rows="3" placeholder="Contoh: warna pink nude, ada glitter di jari manis, ukuran S..."
                                    style="width: 100%; padding: 10px 12px; border: 1px solid var(--lavender); background: white; font-family: Arial; font-size: 14px; outline: none; resize: vertical;">{{ old('custom_notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- PENGIRIMAN --}}
                    <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                        <h2 style="font-size: 14px; font-family: Arial; letter-spacing: 1px; color: var(--sage-dark); margin-bottom: 1.25rem;">PENGIRIMAN</h2>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1rem;">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 12px; border: 1px solid var(--sage-light); background: var(--cream);">
                                <input type="radio" name="shipping_method" value="courier" checked onchange="toggleCourier(this)">
                                <span style="font-family: Arial; font-size: 14px; color: var(--text-dark);">Kurir (JNE / J&T / SiCepat / dll)</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 12px; border: 1px solid var(--sage-light); background: var(--cream);">
                                <input type="radio" name="shipping_method" value="cod" onchange="toggleCourier(this)">
                                <span style="font-family: Arial; font-size: 14px; color: var(--text-dark);">COD / Antar Sendiri</span>
                            </label>
                        </div>
                        <div id="courierField">
                            <label style="display: block; font-family: Arial; font-size: 12px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">PILIH KURIR</label>
                            <select name="courier_name"
                                style="width: 100%; padding: 10px 12px; border: 1px solid var(--sage-light); background: var(--cream); font-family: Arial; font-size: 14px; outline: none;">
                                <option value="">-- Pilih Kurir --</option>
                                <option value="JNE">JNE</option>
                                <option value="J&T">J&T Express</option>
                                <option value="SiCepat">SiCepat</option>
                                <option value="AnterAja">AnterAja</option>
                                <option value="Pos Indonesia">Pos Indonesia</option>
                            </select>
                        </div>
                    </div>

                    {{-- PEMBAYARAN --}}
                    <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                        <h2 style="font-size: 14px; font-family: Arial; letter-spacing: 1px; color: var(--sage-dark); margin-bottom: 1.25rem;">METODE PEMBAYARAN</h2>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 12px; border: 1px solid var(--sage-light); background: var(--cream);">
                                <input type="radio" name="payment_method" value="transfer" checked>
                                <div>
                                    <p style="font-family: Arial; font-size: 14px; color: var(--text-dark); margin-bottom: 2px;">Transfer Bank</p>
                                    <p style="font-family: Arial; font-size: 12px; color: var(--text-muted);">BCA / BNI / Mandiri — konfirmasi via WhatsApp</p>
                                </div>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 12px; border: 1px solid var(--sage-light); background: var(--cream);">
                                <input type="radio" name="payment_method" value="qris">
                                <div>
                                    <p style="font-family: Arial; font-size: 14px; color: var(--text-dark); margin-bottom: 2px;">QRIS</p>
                                    <p style="font-family: Arial; font-size: 12px; color: var(--text-muted);">Scan QR Code — konfirmasi via WhatsApp</p>
                                </div>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 12px; border: 1px solid var(--sage-light); background: var(--cream);">
                                <input type="radio" name="payment_method" value="cod">
                                <div>
                                    <p style="font-family: Arial; font-size: 14px; color: var(--text-dark); margin-bottom: 2px;">Bayar di Tempat (COD)</p>
                                    <p style="font-family: Arial; font-size: 12px; color: var(--text-muted);">Bayar saat barang diterima</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- CATATAN --}}
                    <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                        <h2 style="font-size: 14px; font-family: Arial; letter-spacing: 1px; color: var(--sage-dark); margin-bottom: 1rem;">CATATAN (opsional)</h2>
                        <textarea name="notes" rows="2" placeholder="Ada catatan khusus untuk pesananmu?"
                            style="width: 100%; padding: 10px 12px; border: 1px solid var(--sage-light); background: var(--cream); font-family: Arial; font-size: 14px; outline: none; resize: vertical;">{{ old('notes') }}</textarea>
                    </div>
                </div>

                {{-- KANAN: RINGKASAN PESANAN --}}
                <div style="position: sticky; top: 120px;">
                    <div style="background: white; border: 1px solid var(--cream-dark); padding: 1.5rem;">
                        <h2 style="font-size: 14px; font-family: Arial; letter-spacing: 1px; color: var(--sage-dark); margin-bottom: 1.25rem;">RINGKASAN PESANAN</h2>

                        {{-- Produk --}}
                        <div style="display: flex; gap: 12px; margin-bottom: 1.25rem; padding-bottom: 1.25rem; border-bottom: 1px solid var(--cream-dark);">
                            <div style="width: 72px; height: 72px; flex-shrink: 0; overflow: hidden; background: var(--cream);">
                                @if($product->primaryImageUrl)
                                    <img src="{{ $product->primaryImageUrl }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">💅</div>
                                @endif
                            </div>
                            <div style="flex: 1;">
                                <p style="font-size: 14px; color: var(--text-dark); margin-bottom: 4px; line-height: 1.3;">{{ $product->name }}</p>
                                <p style="font-family: Arial; font-size: 13px; color: var(--text-muted);">{{ $product->formattedPrice }}</p>
                            </div>
                        </div>

                        {{-- Jumlah --}}
                        @if(!$product->is_custom)
                        <div style="margin-bottom: 1.25rem;">
                            <label style="display: block; font-family: Arial; font-size: 12px; color: var(--text-muted); margin-bottom: 6px; letter-spacing: 0.5px;">JUMLAH</label>
                            <input type="number" name="quantity" value="{{ $quantity ?? 1 }}" min="1" max="{{ $product->stock }}"
                                id="qtyInput" onchange="updateTotal()"
                                style="width: 80px; padding: 8px 12px; border: 1px solid var(--sage-light); background: var(--cream); font-family: Arial; font-size: 14px; outline: none; text-align: center;">
                            <span style="font-family: Arial; font-size: 12px; color: var(--text-muted); margin-left: 8px;">maks. {{ $product->stock }}</span>
                        </div>
                        @else
                            <input type="hidden" name="quantity" value="1">
                        @endif

                        {{-- Total --}}
                        <div style="border-top: 1px solid var(--cream-dark); padding-top: 1rem; margin-bottom: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-family: Arial; font-size: 13px; color: var(--text-muted);">Subtotal</span>
                                <span style="font-family: Arial; font-size: 14px; font-weight: bold; color: var(--text-dark);" id="totalDisplay">
                                    {{ $product->formattedPrice }}
                                </span>
                            </div>
                            <p style="font-family: Arial; font-size: 11px; color: var(--text-muted); margin-top: 4px;">+ ongkir menyusul setelah konfirmasi admin</p>
                        </div>

                        <button type="submit"
                            style="width: 100%; background: var(--sage-dark); color: white; padding: 14px; border: none; cursor: pointer; font-family: Arial; font-size: 13px; letter-spacing: 2px; transition: background 0.2s;"
                            onmouseover="this.style.background='var(--sage)'"
                            onmouseout="this.style.background='var(--sage-dark)'">
                            BUAT PESANAN
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        const price = {{ $product->price }};

        function updateTotal() {
            const qty = parseInt(document.getElementById('qtyInput')?.value) || 1;
            const total = price * qty;
            document.getElementById('totalDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        function toggleCourier(el) {
            document.getElementById('courierField').style.display = el.value === 'cod' ? 'none' : 'block';
        }
    </script>
</x-app-layout>