<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Booking — OU Beauty Bar</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root { --olive:#5C6B3A; --olive-light:#7A8C4E; --olive-pale:#E8EDD8; --lilac:#C4B5D4; --lilac-deep:#9B87B0; --lilac-pale:#F0EBF7; --cream:#FAF8F5; --dark:#2C2C2C; --gray:#6B6B6B; }
    body { font-family: 'Jost', sans-serif; background: var(--cream); color: var(--dark); }
    nav { position: sticky; top: 0; z-index: 100; display: flex; justify-content: space-between; align-items: center; padding: 1.2rem 4rem; background: rgba(250,248,245,.96); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(92,107,58,.12); }
    .logo { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 600; text-decoration: none; color: var(--olive); display: flex; align-items: center; gap: .5rem; }
    .logo-badge { width: 32px; height: 32px; background: var(--olive); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--lilac); font-size: .72rem; font-weight: 700; }
    .btn { display: inline-block; padding: .6rem 1.5rem; font-size: .8rem; letter-spacing: .08em; text-transform: uppercase; text-decoration: none; border: none; cursor: pointer; font-family: 'Jost', sans-serif; transition: all .2s; }
    .btn-olive { background: var(--olive); color: white; }
    .btn-olive:hover { background: var(--olive-light); }
    .btn-lilac { background: var(--lilac-deep); color: white; }
    .btn-lilac:hover { background: var(--olive); }
    .btn-back { background: none; border: 1.5px solid rgba(92,107,58,.3); color: var(--olive); font-size: .78rem; }
    .btn-back:hover { background: var(--olive-pale); }

    .container { max-width: 780px; margin: 0 auto; padding: 3rem 2rem; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 400; margin-bottom: .3rem; }
    .page-title em { font-style: italic; color: var(--olive); }

    /* DESIGN PREVIEW */
    .design-preview {
      display: flex; gap: 1.5rem; align-items: center;
      background: var(--olive-pale); padding: 1.5rem;
      border-left: 3px solid var(--olive); margin-bottom: 2.5rem;
    }
    .preview-img {
      width: 90px; height: 110px; flex-shrink: 0;
      overflow: hidden; border-radius: 2px;
      background: var(--lilac);
      display: flex; align-items: center; justify-content: center; font-size: 2rem;
    }
    .preview-img img { width: 100%; height: 100%; object-fit: cover; }
    .preview-kat { font-size: .68rem; letter-spacing: .15em; text-transform: uppercase; color: var(--olive); margin-bottom: .3rem; }
    .preview-nama { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 400; margin-bottom: .3rem; }
    .preview-harga { color: var(--lilac-deep); font-weight: 500; font-size: .9rem; }

    /* FORM */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; }
    .form-group { display: flex; flex-direction: column; gap: .4rem; }
    .form-group.full { grid-column: 1/-1; }
    label { font-size: .7rem; letter-spacing: .12em; text-transform: uppercase; color: var(--gray); }
    input, select, textarea {
      background: white; border: 1px solid rgba(92,107,58,.2);
      color: var(--dark); padding: .8rem 1rem;
      font-family: 'Jost', sans-serif; font-size: .88rem;
      outline: none; transition: border-color .2s; width: 100%;
    }
    input:focus, select:focus, textarea:focus { border-color: var(--olive); }
    .is-invalid { border-color: #e53935 !important; }
    .invalid-feedback { font-size: .75rem; color: #e53935; }
    textarea { resize: vertical; min-height: 80px; }

    /* PAYMENT */
    .payment-options { display: grid; grid-template-columns: repeat(3,1fr); gap: .8rem; }
    .payment-option input { display: none; }
    .payment-option label {
      display: block; padding: 1.2rem 1rem;
      border: 1.5px solid rgba(92,107,58,.2);
      text-align: center; cursor: pointer;
      font-size: .82rem; transition: all .2s;
      text-transform: none; letter-spacing: 0; color: var(--dark);
    }
    .payment-option label:hover { border-color: var(--olive); background: var(--olive-pale); }
    .payment-option input:checked + label { border-color: var(--olive); background: var(--olive-pale); color: var(--olive); font-weight: 500; }

    /* FOTO UPLOAD */
    .upload-area {
      border: 2px dashed rgba(155,135,176,.4);
      padding: 2rem; text-align: center;
      background: var(--lilac-pale); cursor: pointer;
      transition: border-color .2s;
    }
    .upload-area:hover { border-color: var(--lilac-deep); }
    .upload-area input { display: none; }
    .upload-icon { font-size: 2rem; margin-bottom: .5rem; display: block; }
    .upload-text { font-size: .85rem; color: var(--gray); }
    .upload-hint { font-size: .75rem; color: var(--lilac-deep); margin-top: .3rem; }
    #preview-foto { width: 100%; max-height: 200px; object-fit: cover; margin-top: 1rem; display: none; }
    #preview-kuku { width: 100%; max-height: 200px; object-fit: cover; margin-top: 1rem; display: none; }

    /* ===== CUSTOM NAIL SECTION ===== */
    .section-divider {
      grid-column: 1/-1;
      border: none; border-top: 1px solid rgba(92,107,58,.15);
      margin: .8rem 0;
    }
    .section-label {
      grid-column: 1/-1;
      font-size: .7rem; letter-spacing: .15em; text-transform: uppercase;
      color: var(--olive); padding-bottom: .3rem;
      border-bottom: 1px solid rgba(92,107,58,.2);
    }

    .finger-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: .7rem;
    }
    .finger-item {
      display: flex; flex-direction: column; gap: .35rem;
    }
    .finger-label-name {
      font-size: .65rem; letter-spacing: .1em; text-transform: uppercase;
      color: var(--gray); text-align: center;
    }
    .finger-item select {
      padding: .5rem .4rem; font-size: .75rem; text-align: center;
      border: 1px solid rgba(92,107,58,.2); background: white;
      cursor: pointer;
    }
    .finger-item select:focus { border-color: var(--lilac-deep); }

    /* HAND TABS */
    .hand-tabs { display: flex; gap: 0; margin-bottom: 1rem; }
    .hand-tab {
      flex: 1; padding: .6rem; font-size: .75rem; letter-spacing: .08em;
      text-transform: uppercase; border: 1px solid rgba(92,107,58,.2);
      background: white; cursor: pointer; font-family: 'Jost', sans-serif;
      color: var(--gray); transition: all .2s;
    }
    .hand-tab:first-child { border-right: none; }
    .hand-tab.active { background: var(--olive-pale); color: var(--olive); font-weight: 500; border-color: var(--olive); }
    .hand-panel { display: none; }
    .hand-panel.active { display: block; }

    /* PRICE SUMMARY */
    .price-summary {
      background: var(--lilac-pale); border: 1px solid rgba(155,135,176,.3);
      padding: 1rem 1.2rem; display: flex; justify-content: space-between; align-items: center;
    }
    .price-summary-label { font-size: .7rem; letter-spacing: .12em; text-transform: uppercase; color: var(--gray); }
    .price-summary-amount { font-family: 'Playfair Display', serif; font-size: 1.4rem; color: var(--lilac-deep); font-weight: 600; }
    .price-breakdown { font-size: .75rem; color: var(--gray); margin-top: .25rem; }

    /* COPY HAND */
    .copy-hand-btn {
      background: none; border: 1px dashed rgba(92,107,58,.3);
      color: var(--olive); font-size: .72rem; padding: .4rem .8rem;
      cursor: pointer; font-family: 'Jost', sans-serif; letter-spacing: .06em;
      margin-bottom: .8rem; transition: all .2s;
    }
    .copy-hand-btn:hover { background: var(--olive-pale); border-style: solid; }

    @media(max-width:768px) {
      nav { padding: 1rem 1.5rem; }
      .container { padding: 2rem 1.2rem; }
      .form-grid, .payment-options { grid-template-columns: 1fr; }
      .form-group.full { grid-column: 1; }
      .design-preview { flex-direction: column; }
      .finger-grid { grid-template-columns: repeat(5, 1fr); gap: .4rem; }
      .finger-item select { font-size: .65rem; padding: .4rem .2rem; }
    }
  </style>
</head>
<body>

<nav>
  <a class="logo" href="/">
    <div class="logo-badge">OU</div>
    Beauty Bar
  </a>
  <a href="/" class="btn btn-back">← Kembali</a>
</nav>

<div class="container">
  <h1 class="page-title">Form <em>Booking</em></h1>
  <p style="font-size:.88rem;color:var(--gray);margin-bottom:2rem">Isi detail appointment kamu di bawah ini.</p>

  <!-- PREVIEW -->
  <div class="design-preview">
    <div class="preview-img">
      @if($design->gambar)
        <img src="{{ asset('storage/' . $design->gambar) }}" alt="{{ $design->nama }}"/>
      @else
        💅
      @endif
    </div>
    <div>
      <p class="preview-kat">{{ $design->kategori }}</p>
      <h3 class="preview-nama">{{ $design->nama }}</h3>
      <p style="font-size:.82rem;color:var(--gray);margin-bottom:.5rem">{{ $design->deskripsi }}</p>
      <p class="preview-harga">
        @if($design->harga_min == $design->harga_max)
          Rp {{ number_format($design->harga_min, 0, ',', '.') }}
        @else
          Rp {{ number_format($design->harga_min, 0, ',', '.') }} –
          Rp {{ number_format($design->harga_max, 0, ',', '.') }}
        @endif
      </p>
      <p style="font-size:.75rem;color:var(--gray);margin-top:.3rem">
        Harga per jari: Rp {{ number_format($design->harga_min / 10, 0, ',', '.') }}
        @if($design->harga_min != $design->harga_max)
          – Rp {{ number_format($design->harga_max / 10, 0, ',', '.') }}
        @endif
      </p>
    </div>
  </div>

  <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="design_id" value="{{ $design->id }}"/>
    <input type="hidden" name="total_harga" id="input-total-harga" value="0"/>

    <div class="form-grid">

      <div class="form-group">
        <label>Tanggal Kunjungan</label>
        <input type="date" name="tanggal" value="{{ old('tanggal') }}"
               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
               class="{{ $errors->has('tanggal') ? 'is-invalid' : '' }}"/>
        @error('tanggal') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label>Jam</label>
        <select name="jam" class="{{ $errors->has('jam') ? 'is-invalid' : '' }}">
          <option value="">— Pilih jam —</option>
          @foreach(['09:00','10:00','11:00','13:00','14:00','15:00','16:00'] as $j)
            <option value="{{ $j }}" {{ old('jam') == $j ? 'selected' : '' }}>{{ $j }}</option>
          @endforeach
        </select>
        @error('jam') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label>Panjang Kuku</label>
        <select name="panjang_kuku" class="{{ $errors->has('panjang_kuku') ? 'is-invalid' : '' }}">
          <option value="">— Pilih —</option>
          @foreach(['Pendek','Sedang','Panjang'] as $p)
            <option value="{{ $p }}" {{ old('panjang_kuku') == $p ? 'selected' : '' }}>{{ $p }}</option>
          @endforeach
        </select>
        @error('panjang_kuku') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>

      <hr class="section-divider"/>

      {{-- ===== CUSTOM PER JARI ===== --}}
      <div class="form-group full">
        <p class="section-label">Pilih Model per Jari</p>
        <p style="font-size:.8rem;color:var(--gray);margin-bottom:1rem">
          Kamu bisa pilih model yang berbeda untuk setiap jari.
        </p>

        {{-- Tab tangan --}}
        <div class="hand-tabs">
          <button type="button" class="hand-tab active" onclick="switchHand('kiri', this)">✋ Tangan Kiri</button>
          <button type="button" class="hand-tab" onclick="switchHand('kanan', this)">🤚 Tangan Kanan</button>
        </div>

        {{-- Panel tangan kiri --}}
        <div class="hand-panel active" id="panel-kiri">
          <button type="button" class="copy-hand-btn" onclick="copyToRight()">
            Salin pilihan ke Tangan Kanan →
          </button>
          <div class="finger-grid">
            @php
              $jariKiri = ['Kelingking', 'Manis', 'Tengah', 'Telunjuk', 'Ibu Jari'];
            @endphp
            @foreach($jariKiri as $idx => $nama)
              <div class="finger-item">
                <span class="finger-label-name">{{ $nama }}</span>
                <select name="pilihan_jari[kiri][{{ $idx }}]"
                        class="finger-select"
                        data-harga-min="{{ $design->harga_min }}"
                        data-harga-max="{{ $design->harga_max }}"
                        onchange="hitungTotal()">
                  <option value="{{ $design->id }}" data-harga="{{ $design->harga_min / 10 }}">
                    {{ $design->nama }}
                  </option>
                  @foreach($allDesigns as $d)
                    @if($d->id !== $design->id)
                      <option value="{{ $d->id }}" data-harga="{{ $d->harga_min / 10 }}">
                        {{ $d->nama }}
                      </option>
                    @endif
                  @endforeach
                </select>
              </div>
            @endforeach
          </div>
        </div>

        {{-- Panel tangan kanan --}}
        <div class="hand-panel" id="panel-kanan">
          <div class="finger-grid">
            @php
              $jariKanan = ['Ibu Jari', 'Telunjuk', 'Tengah', 'Manis', 'Kelingking'];
            @endphp
            @foreach($jariKanan as $idx => $nama)
              <div class="finger-item">
                <span class="finger-label-name">{{ $nama }}</span>
                <select name="pilihan_jari[kanan][{{ $idx }}]"
                        class="finger-select"
                        onchange="hitungTotal()">
                  <option value="{{ $design->id }}" data-harga="{{ $design->harga_min / 10 }}">
                    {{ $design->nama }}
                  </option>
                  @foreach($allDesigns as $d)
                    @if($d->id !== $design->id)
                      <option value="{{ $d->id }}" data-harga="{{ $d->harga_min / 10 }}">
                        {{ $d->nama }}
                      </option>
                    @endif
                  @endforeach
                </select>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      {{-- TOTAL HARGA --}}
      <div class="form-group full">
        <div class="price-summary">
          <div>
            <p class="price-summary-label">Estimasi Total Harga</p>
            <p class="price-breakdown" id="price-breakdown">10 jari × model terpilih</p>
          </div>
          <div class="price-summary-amount" id="total-display">Rp 0</div>
        </div>
        <p style="font-size:.72rem;color:var(--gray);margin-top:.5rem">
          * Harga final dikonfirmasi oleh nail artist setelah booking.
        </p>
      </div>

      <div class="form-group full">
        <label>Metode Pembayaran</label>
        <div class="payment-options">
          @foreach(['Transfer Bank','QRIS','Bayar di Tempat'] as $m)
            <div class="payment-option">
              <input type="radio" name="metode_bayar" id="pay{{ $loop->index }}"
                     value="{{ $m }}" {{ old('metode_bayar') == $m ? 'checked' : '' }}/>
              <label for="pay{{ $loop->index }}">
                {{ $m === 'Transfer Bank' ? '🏦' : ($m === 'QRIS' ? '📱' : '💵') }}<br>
                {{ $m }}
              </label>
            </div>
          @endforeach
        </div>
        @error('metode_bayar') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>

      {{-- FOTO UKURAN KUKU --}}
      <div class="form-group full">
        <label>Foto Ukuran Kuku (opsional tapi disarankan)</label>
        <div class="upload-area" onclick="document.getElementById('foto_kuku').click()">
          <input type="file" id="foto_kuku" name="foto_kuku"
                 accept="image/*" onchange="previewImg(this, 'preview-kuku')"/>
          <span class="upload-icon">🖐️</span>
          <p class="upload-text">Upload foto kuku kamu agar ukuran lebih akurat</p>
          <p class="upload-hint">JPG, PNG, max 2MB — foto kedua tangan, pencahayaan terang</p>
          <img id="preview-kuku" src="" alt="Preview Kuku"/>
        </div>
        @error('foto_kuku') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>

      {{-- FOTO REFERENSI --}}
      <div class="form-group full">
        <label>Foto Referensi Desain (opsional)</label>
        <div class="upload-area" onclick="document.getElementById('foto_referensi').click()">
          <input type="file" id="foto_referensi" name="foto_referensi"
                 accept="image/*" onchange="previewImg(this, 'preview-foto')"/>
          <span class="upload-icon">📸</span>
          <p class="upload-text">Klik untuk upload foto referensi desain kamu</p>
          <p class="upload-hint">JPG, PNG, max 2MB</p>
          <img id="preview-foto" src="" alt="Preview"/>
        </div>
        @error('foto_referensi') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>

      <div class="form-group full">
        <label>Catatan Tambahan (opsional)</label>
        <textarea name="catatan" placeholder="Warna khusus, detail tambahan, dll...">{{ old('catatan') }}</textarea>
      </div>

    </div>
    <button type="submit" class="btn btn-olive" style="margin-top:1.5rem">Konfirmasi Booking →</button>
  </form>
</div>

<script>
// ===== DATA HARGA PER DESIGN =====
// Diisi dari PHP ke JS
const designPrices = {
  @foreach($allDesigns as $d)
  {{ $d->id }}: {{ $d->harga_min / 10 }},
  @endforeach
};

// ===== SWITCH TAB TANGAN =====
function switchHand(hand, btn) {
  document.querySelectorAll('.hand-panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.hand-tab').forEach(t => t.classList.remove('active'));
  document.getElementById('panel-' + hand).classList.add('active');
  btn.classList.add('active');
}

// ===== SALIN KE TANGAN KANAN =====
function copyToRight() {
  const kiriSelects = document.querySelectorAll('#panel-kiri .finger-select');
  const kananSelects = document.querySelectorAll('#panel-kanan .finger-select');

  // Kiri: kelingking(0), manis(1), tengah(2), telunjuk(3), ibu jari(4)
  // Kanan: ibu jari(0), telunjuk(1), tengah(2), manis(3), kelingking(4)
  // Mirror: kiri[0] -> kanan[4], kiri[1] -> kanan[3], dst
  kiriSelects.forEach((sel, i) => {
    const mirrorIdx = 4 - i;
    kananSelects[mirrorIdx].value = sel.value;
  });

  hitungTotal();
  switchHand('kanan', document.querySelectorAll('.hand-tab')[1]);
}

// ===== HITUNG TOTAL =====
function hitungTotal() {
  const selects = document.querySelectorAll('.finger-select');
  let total = 0;
  let breakdown = {};

  selects.forEach(sel => {
    const designId = parseInt(sel.value);
    const harga = designPrices[designId] || 0;
    total += harga;

    // Untuk breakdown teks
    const nama = sel.options[sel.selectedIndex].text;
    breakdown[nama] = (breakdown[nama] || 0) + 1;
  });

  // Update display
  document.getElementById('total-display').textContent =
    'Rp ' + total.toLocaleString('id-ID');
  document.getElementById('input-total-harga').value = total;

  // Breakdown teks
  const parts = Object.entries(breakdown).map(([nama, qty]) => `${qty}× ${nama}`);
  document.getElementById('price-breakdown').textContent = parts.join(', ');
}

// ===== PREVIEW FOTO =====
function previewImg(input, previewId) {
  const preview = document.getElementById(previewId);
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      preview.src = e.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
  }
}

// Init hitung saat load
document.addEventListener('DOMContentLoaded', hitungTotal);
</script>

</body>
</html>