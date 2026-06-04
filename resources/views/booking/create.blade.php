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
    .btn-back { background: none; border: 1.5px solid rgba(92,107,58,.3); color: var(--olive); font-size: .78rem; }
    .btn-back:hover { background: var(--olive-pale); }

    .container { max-width: 780px; margin: 0 auto; padding: 3rem 2rem; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 400; margin-bottom: .3rem; }
    .page-title em { font-style: italic; color: var(--olive); }

    /* DESIGN PREVIEW */
    .design-preview { display: flex; gap: 1.5rem; align-items: center; background: var(--olive-pale); padding: 1.5rem; border-left: 3px solid var(--olive); margin-bottom: 2rem; }
    .preview-img { width: 90px; height: 110px; flex-shrink: 0; overflow: hidden; border-radius: 2px; background: var(--lilac); display: flex; align-items: center; justify-content: center; font-size: 2rem; }
    .preview-img img { width: 100%; height: 100%; object-fit: cover; }
    .preview-kat { font-size: .68rem; letter-spacing: .15em; text-transform: uppercase; color: var(--olive); margin-bottom: .3rem; }
    .preview-nama { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 400; margin-bottom: .3rem; }
    .preview-harga { color: var(--lilac-deep); font-weight: 500; font-size: .9rem; }

    /* TIPE ORDER TOGGLE */
    .tipe-toggle { display: grid; grid-template-columns: 1fr 1fr; gap: 0; margin-bottom: 2rem; border: 1.5px solid rgba(92,107,58,.25); overflow: hidden; }
    .tipe-toggle input { display: none; }
    .tipe-toggle label { display: flex; flex-direction: column; align-items: center; gap: .3rem; padding: 1.2rem 1rem; cursor: pointer; transition: all .2s; background: white; color: var(--gray); font-size: .82rem; border-right: 1px solid rgba(92,107,58,.15); text-align: center; line-height: 1.4; }
    .tipe-toggle label:last-of-type { border-right: none; }
    .tipe-toggle label .tipe-icon { font-size: 1.6rem; display: block; }
    .tipe-toggle label .tipe-name { font-size: .85rem; color: var(--dark); font-weight: 500; }
    .tipe-toggle label .tipe-desc { font-size: .72rem; color: var(--gray); }
    .tipe-toggle input:checked + label { background: var(--olive-pale); border-bottom: 2px solid var(--olive); }
    .tipe-toggle input:checked + label .tipe-name { color: var(--olive); }

    /* FORM */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; }
    .form-group { display: flex; flex-direction: column; gap: .4rem; }
    .form-group.full { grid-column: 1/-1; }
    label { font-size: .7rem; letter-spacing: .12em; text-transform: uppercase; color: var(--gray); }
    input[type=text], input[type=date], input[type=tel], select, textarea { background: white; border: 1px solid rgba(92,107,58,.2); color: var(--dark); padding: .8rem 1rem; font-family: 'Jost', sans-serif; font-size: .88rem; outline: none; transition: border-color .2s; width: 100%; }
    input:focus, select:focus, textarea:focus { border-color: var(--olive); }
    .is-invalid { border-color: #e53935 !important; }
    .invalid-feedback { font-size: .75rem; color: #e53935; }
    textarea { resize: vertical; min-height: 80px; }

    /* PAYMENT */
    .payment-options { display: grid; grid-template-columns: repeat(3,1fr); gap: .8rem; }
    .payment-option input { display: none; }
    .payment-option label { display: block; padding: 1.2rem 1rem; border: 1.5px solid rgba(92,107,58,.2); text-align: center; cursor: pointer; font-size: .82rem; transition: all .2s; text-transform: none; letter-spacing: 0; color: var(--dark); }
    .payment-option label:hover { border-color: var(--olive); background: var(--olive-pale); }
    .payment-option input:checked + label { border-color: var(--olive); background: var(--olive-pale); color: var(--olive); font-weight: 500; }

    /* UPLOAD */
    .upload-area { border: 2px dashed rgba(155,135,176,.4); padding: 1.5rem; text-align: center; background: var(--lilac-pale); cursor: pointer; transition: border-color .2s; }
    .upload-area:hover { border-color: var(--lilac-deep); }
    .upload-area input { display: none; }
    .upload-icon { font-size: 1.8rem; margin-bottom: .4rem; display: block; }
    .upload-text { font-size: .82rem; color: var(--gray); }
    .upload-hint { font-size: .72rem; color: var(--lilac-deep); margin-top: .25rem; }
    .preview-single { width: 100%; max-height: 180px; object-fit: cover; margin-top: .8rem; display: none; border-radius: 2px; }
    .preview-multi { display: flex; flex-wrap: wrap; gap: .5rem; margin-top: .8rem; }
    .preview-multi img { width: 70px; height: 70px; object-fit: cover; border-radius: 2px; border: 1px solid rgba(92,107,58,.2); }

    /* INFO BOX */
    .info-box { background: var(--olive-pale); border-left: 3px solid var(--olive); padding: .9rem 1.1rem; font-size: .82rem; color: var(--dark); line-height: 1.6; }
    .info-box strong { color: var(--olive); }

    /* DIVIDER */
    .section-divider { grid-column: 1/-1; border: none; border-top: 1px solid rgba(92,107,58,.15); margin: .4rem 0; }
    .section-label-text { grid-column: 1/-1; font-size: .7rem; letter-spacing: .15em; text-transform: uppercase; color: var(--olive); padding-bottom: .3rem; border-bottom: 1px solid rgba(92,107,58,.2); margin-bottom: -.2rem; }

    /* PANEL */
    .panel { display: none; }
    .panel.active { display: contents; }

    /* ===== PILIH MODEL PER JARI ===== */
    .finger-section { grid-column: 1/-1; }
    .hand-tabs { display: flex; margin-bottom: .8rem; }
    .hand-tab { flex: 1; padding: .6rem; font-size: .75rem; letter-spacing: .08em; text-transform: uppercase; border: 1px solid rgba(92,107,58,.2); background: white; cursor: pointer; font-family: 'Jost', sans-serif; color: var(--gray); transition: all .2s; }
    .hand-tab:first-child { border-right: none; }
    .hand-tab.active { background: var(--olive-pale); color: var(--olive); font-weight: 500; border-color: var(--olive); }
    .hand-panel { display: none; }
    .hand-panel.active { display: block; }
    .finger-grid { display: grid; grid-template-columns: repeat(5,1fr); gap: .6rem; }
    .finger-item { display: flex; flex-direction: column; gap: .3rem; }
    .finger-name { font-size: .62rem; letter-spacing: .08em; text-transform: uppercase; color: var(--gray); text-align: center; }
    .finger-item select { padding: .5rem .3rem; font-size: .72rem; text-align: center; border: 1px solid rgba(92,107,58,.2); background: white; cursor: pointer; width: 100%; }
    .finger-item select:focus { border-color: var(--lilac-deep); outline: none; }
    .copy-btn { background: none; border: 1px dashed rgba(92,107,58,.3); color: var(--olive); font-size: .72rem; padding: .35rem .8rem; cursor: pointer; font-family: 'Jost', sans-serif; letter-spacing: .06em; margin-bottom: .7rem; transition: all .2s; }
    .copy-btn:hover { background: var(--olive-pale); border-style: solid; }

    /* PRICE SUMMARY */
    .price-summary { background: var(--lilac-pale); border: 1px solid rgba(155,135,176,.3); padding: 1rem 1.2rem; }
    .price-row { display: flex; justify-content: space-between; align-items: center; }
    .price-label { font-size: .7rem; letter-spacing: .12em; text-transform: uppercase; color: var(--gray); }
    .price-amount { font-family: 'Playfair Display', serif; font-size: 1.3rem; color: var(--lilac-deep); font-weight: 600; }
    .price-dp { font-size: .82rem; color: var(--olive); font-weight: 500; margin-top: .4rem; padding-top: .4rem; border-top: 1px dashed rgba(92,107,58,.2); }
    .price-breakdown { font-size: .73rem; color: var(--gray); margin-top: .3rem; line-height: 1.6; }

    @media(max-width:768px) {
      nav { padding: 1rem 1.5rem; }
      .container { padding: 2rem 1.2rem; }
      .form-grid, .payment-options { grid-template-columns: 1fr; }
      .form-group.full, .section-divider, .section-label-text, .finger-section { grid-column: 1; }
      .design-preview { flex-direction: column; }
      .panel.active { display: block; }
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
  <p style="font-size:.88rem;color:var(--gray);margin-bottom:1.5rem">Isi detail pesanan kamu di bawah ini.</p>

  <!-- PREVIEW KATALOG -->
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
          Rp {{ number_format($design->harga_min, 0, ',', '.') }} – Rp {{ number_format($design->harga_max, 0, ',', '.') }}
        @endif
      </p>
    </div>
  </div>

  <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="design_id" value="{{ $design->id }}"/>
    <input type="hidden" name="total_harga" id="input-total-harga" value="0"/>

    <!-- PILIH TIPE ORDER -->
    <div class="tipe-toggle">
      <input type="radio" name="tipe_order" id="tipe-nail-art" value="nail_art"
             {{ old('tipe_order', 'nail_art') === 'nail_art' ? 'checked' : '' }}
             onchange="switchTipe('nail_art')"/>
      <label for="tipe-nail-art">
        <span class="tipe-icon">💅</span>
        <span class="tipe-name">Nail Art</span>
        <span class="tipe-desc">Langsung di tempat<br>oleh nail artist kami</span>
      </label>
      <input type="radio" name="tipe_order" id="tipe-press-on" value="press_on"
             {{ old('tipe_order') === 'press_on' ? 'checked' : '' }}
             onchange="switchTipe('press_on')"/>
      <label for="tipe-press-on">
        <span class="tipe-icon">📦</span>
        <span class="tipe-name">Press On Nail</span>
        <span class="tipe-desc">Dikirim via kurir<br>pasang sendiri di rumah</span>
      </label>
    </div>

    <div class="form-grid">

      {{-- FIELD BERSAMA --}}
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

      <div class="form-group">
        <label>Bentuk Kuku</label>
        <select name="bentuk_kuku" class="{{ $errors->has('bentuk_kuku') ? 'is-invalid' : '' }}">
          <option value="">— Pilih —</option>
          @foreach(['Almond','Square','Oval','Coffin','Stiletto','Rounded Square','Squoval'] as $b)
            <option value="{{ $b }}" {{ old('bentuk_kuku') == $b ? 'selected' : '' }}>{{ $b }}</option>
          @endforeach
        </select>
        @error('bentuk_kuku') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>

      <div class="form-group full">
        <label>Nomor WhatsApp</label>
        <input type="tel" name="no_wa" placeholder="Contoh: 08123456789"
               value="{{ old('no_wa') }}"
               class="{{ $errors->has('no_wa') ? 'is-invalid' : '' }}"/>
        <span style="font-size:.72rem;color:var(--gray)">Admin akan menghubungi kamu di nomor ini.</span>
        @error('no_wa') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>

      <hr class="section-divider"/>
      <p class="section-label-text">Pilih Model per Jari</p>

      {{-- PILIH MODEL PER JARI (shared, selalu tampil) --}}
      <div class="finger-section">
        <div class="hand-tabs">
          <button type="button" class="hand-tab active" onclick="switchHand('kiri', this)">✋ Tangan Kiri</button>
          <button type="button" class="hand-tab" onclick="switchHand('kanan', this)">🤚 Tangan Kanan</button>
        </div>

        {{-- Tangan Kiri --}}
        <div class="hand-panel active" id="hand-kiri">
          <button type="button" class="copy-btn" onclick="copyToRight()">Salin ke Tangan Kanan →</button>
          <div class="finger-grid">
            @php $jariKiri = ['Kelingking','Manis','Tengah','Telunjuk','Ibu Jari']; @endphp
            @foreach($jariKiri as $idx => $nama)
              <div class="finger-item">
                <span class="finger-name">{{ $nama }}</span>
                <select name="pilihan_jari[kiri][{{ $idx }}]" class="finger-select" onchange="hitungTotal()">
                  @foreach($allDesigns as $d)
                    <option value="{{ $d->id }}"
                            data-harga="{{ $d->harga_min / 10 }}"
                            {{ $d->id == $design->id ? 'selected' : '' }}>
                      {{ $d->nama }}
                    </option>
                  @endforeach
                </select>
              </div>
            @endforeach
          </div>
        </div>

        {{-- Tangan Kanan --}}
        <div class="hand-panel" id="hand-kanan">
          <div class="finger-grid">
            @php $jariKanan = ['Ibu Jari','Telunjuk','Tengah','Manis','Kelingking']; @endphp
            @foreach($jariKanan as $idx => $nama)
              <div class="finger-item">
                <span class="finger-name">{{ $nama }}</span>
                <select name="pilihan_jari[kanan][{{ $idx }}]" class="finger-select" onchange="hitungTotal()">
                  @foreach($allDesigns as $d)
                    <option value="{{ $d->id }}"
                            data-harga="{{ $d->harga_min / 10 }}"
                            {{ $d->id == $design->id ? 'selected' : '' }}>
                      {{ $d->nama }}
                    </option>
                  @endforeach
                </select>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      {{-- PRICE SUMMARY --}}
      <div class="form-group full">
        <div class="price-summary">
          <div class="price-row">
            <div>
              <p class="price-label">Estimasi Total Harga</p>
              <p class="price-breakdown" id="price-breakdown">—</p>
            </div>
            <p class="price-amount" id="total-display">Rp 0</p>
          </div>
          <p class="price-dp" id="dp-display">DP 50%: Rp 0</p>
        </div>
        <p style="font-size:.72rem;color:var(--gray);margin-top:.4rem">
          * Harga final dikonfirmasi admin via WhatsApp. Nail Art bayar DP 50%, Press On bayar lunas.
        </p>
      </div>

      <hr class="section-divider"/>

      {{-- ===== PANEL NAIL ART ===== --}}
      <div class="panel {{ old('tipe_order', 'nail_art') === 'nail_art' ? 'active' : '' }}" id="panel-nail-art">

        <div class="form-group full">
          <div class="info-box">
            💳 <strong>Nail Art — Bayar DP 50%.</strong>
            Admin akan menghubungi kamu via WhatsApp untuk konfirmasi jadwal dan nominal DP.
          </div>
        </div>

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

        <div class="form-group full">
          <label>Metode Pembayaran DP</label>
          <div class="payment-options">
            @foreach(['Transfer Bank','QRIS','Bayar di Tempat'] as $m)
              <div class="payment-option">
                <input type="radio" name="metode_bayar" id="pay{{ $loop->index }}"
                       value="{{ $m }}" {{ old('metode_bayar') == $m ? 'checked' : '' }}/>
                <label for="pay{{ $loop->index }}">
                  {{ $m === 'Transfer Bank' ? '🏦' : ($m === 'QRIS' ? '📱' : '💵') }}<br>{{ $m }}
                </label>
              </div>
            @endforeach
          </div>
          @error('metode_bayar') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="form-group full">
          <label>Foto Referensi Desain (opsional)</label>
          <div class="upload-area" onclick="document.getElementById('foto-ref-single').click()">
            <input type="file" id="foto-ref-single" name="foto_referensi"
                   accept="image/*" onchange="previewSingle(this,'prev-ref-single')"/>
            <span class="upload-icon">📸</span>
            <p class="upload-text">Klik untuk upload foto referensi</p>
            <p class="upload-hint">JPG, PNG, maks. 2MB</p>
            <img id="prev-ref-single" class="preview-single" src="" alt="Preview"/>
          </div>
          @error('foto_referensi') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

      </div>{{-- end panel nail art --}}

      {{-- ===== PANEL PRESS ON ===== --}}
      <div class="panel {{ old('tipe_order') === 'press_on' ? 'active' : '' }}" id="panel-press-on">

        <div class="form-group full">
          <div class="info-box">
            💳 <strong>Press On Nail — Bayar lunas.</strong>
            Admin akan menghubungi kamu via WhatsApp untuk info rekening dan ongkir.
          </div>
        </div>

        <div class="form-group full">
          <label>Foto Jari Bersama Koin 500 Perak <span style="color:#e53935">*</span></label>
          <div class="upload-area" onclick="document.getElementById('foto-jari-koin').click()">
            <input type="file" id="foto-jari-koin" name="foto_jari_koin"
                   accept="image/*" onchange="previewSingle(this,'prev-jari-koin')"/>
            <span class="upload-icon">🖐️</span>
            <p class="upload-text">Upload foto semua jari bersisian dengan koin 500 perak</p>
            <p class="upload-hint">Untuk akurasi ukuran kuku — JPG, PNG, maks. 2MB</p>
            <img id="prev-jari-koin" class="preview-single" src="" alt="Preview Jari"/>
          </div>
          @error('foto_jari_koin') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="form-group full">
          <label>Foto Referensi Desain (bisa lebih dari 1, opsional)</label>
          <div class="upload-area" onclick="document.getElementById('foto-ref-multi').click()">
            <input type="file" id="foto-ref-multi" name="foto_referensi[]"
                   accept="image/*" multiple onchange="previewMulti(this)"/>
            <span class="upload-icon">📸</span>
            <p class="upload-text">Klik untuk upload foto referensi (bisa pilih banyak)</p>
            <p class="upload-hint">JPG, PNG, maks. 2MB per foto</p>
            <div class="preview-multi" id="prev-ref-multi"></div>
          </div>
          @error('foto_referensi.*') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

      </div>{{-- end panel press on --}}

      <div class="form-group full">
        <label>Catatan Tambahan (opsional)</label>
        <textarea name="catatan" placeholder="Warna khusus, detail tambahan, dll...">{{ old('catatan') }}</textarea>
      </div>

    </div>

    <button type="submit" class="btn btn-olive" style="margin-top:1.5rem">Konfirmasi Pesanan →</button>
  </form>
</div>

<script>
// Harga per jari dari PHP
const designPrices = {
  @foreach($allDesigns as $d)
  {{ $d->id }}: {{ $d->harga_min / 10 }},
  @endforeach
};
const designNames = {
  @foreach($allDesigns as $d)
  {{ $d->id }}: "{{ addslashes($d->nama) }}",
  @endforeach
};

// Tipe order aktif
let tipeAktif = '{{ old('tipe_order', 'nail_art') }}';

function switchTipe(tipe) {
  tipeAktif = tipe;
  document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
  document.getElementById('panel-' + tipe.replace('_', '-')).classList.add('active');
  updateDpLabel();
}

function switchHand(hand, btn) {
  document.querySelectorAll('.hand-panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.hand-tab').forEach(t => t.classList.remove('active'));
  document.getElementById('hand-' + hand).classList.add('active');
  btn.classList.add('active');
}

function copyToRight() {
  const kiri  = document.querySelectorAll('#hand-kiri .finger-select');
  const kanan = document.querySelectorAll('#hand-kanan .finger-select');
  // mirror: kiri[0]=kelingking -> kanan[4]=kelingking
  kiri.forEach((sel, i) => { kanan[4 - i].value = sel.value; });
  hitungTotal();
  switchHand('kanan', document.querySelectorAll('.hand-tab')[1]);
}

function hitungTotal() {
  const selects = document.querySelectorAll('.finger-select');
  let total = 0;
  let breakdown = {};

  selects.forEach(sel => {
    const id    = parseInt(sel.value);
    const harga = designPrices[id] || 0;
    const nama  = designNames[id] || '—';
    total += harga;
    breakdown[nama] = (breakdown[nama] || 0) + 1;
  });

  document.getElementById('total-display').textContent =
    'Rp ' + total.toLocaleString('id-ID');
  document.getElementById('input-total-harga').value = total;

  const parts = Object.entries(breakdown).map(([n, q]) => q + '× ' + n);
  document.getElementById('price-breakdown').textContent = parts.join(', ');

  updateDpLabel(total);
}

function updateDpLabel(total) {
  const t = total !== undefined
    ? total
    : parseInt(document.getElementById('input-total-harga').value) || 0;

  const dpEl = document.getElementById('dp-display');
  if (tipeAktif === 'nail_art') {
    const dp = Math.ceil(t * 0.5);
    dpEl.textContent = 'DP 50%: Rp ' + dp.toLocaleString('id-ID');
    dpEl.style.display = 'block';
  } else {
    dpEl.textContent = 'Bayar lunas: Rp ' + t.toLocaleString('id-ID');
    dpEl.style.display = 'block';
  }
}

function previewSingle(input, id) {
  const img = document.getElementById(id);
  if (input.files && input.files[0]) {
    const r = new FileReader();
    r.onload = e => { img.src = e.target.result; img.style.display = 'block'; };
    r.readAsDataURL(input.files[0]);
  }
}

function previewMulti(input) {
  const c = document.getElementById('prev-ref-multi');
  c.innerHTML = '';
  Array.from(input.files).forEach(file => {
    const r = new FileReader();
    r.onload = e => {
      const img = document.createElement('img');
      img.src = e.target.result;
      c.appendChild(img);
    };
    r.readAsDataURL(file);
  });
}

document.addEventListener('DOMContentLoaded', hitungTotal);
</script>

</body>
</html>