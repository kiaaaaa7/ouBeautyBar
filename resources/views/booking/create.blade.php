<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Booking — OU Beauty Bar</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --olive:       #5C6B3A;
      --olive-light: #7A8C4E;
      --olive-pale:  #E8EDD8;
      --olive-faint: #f0f3e8;
      --lilac:       #C4B5D4;
      --lilac-deep:  #9B87B0;
      --lilac-pale:  #F0EBF7;
      --cream:       #FAF8F5;
      --bg:          #F2F4EE;
      --dark:        #2C2C2C;
      --gray:        #6B6B6B;
      --border:      rgba(92,107,58,.16);
      --r:           14px;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(18px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(8px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'Jost', sans-serif;
      background: var(--cream);
      color: var(--dark);
      min-height: 100vh;
    }

    /* ════════════════════════════
       NAV
    ════════════════════════════ */
    nav {
      position: sticky; top: 0; z-index: 100;
      display: flex; justify-content: space-between; align-items: center;
      padding: 1.2rem 4rem;
      background: rgba(250,248,245,.95);
      backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px);
      border-bottom: 1px solid var(--border);
    }

    .logo {
      font-family: 'Playfair Display', serif; font-size: 1.35rem; font-weight: 600;
      text-decoration: none; color: var(--olive);
      display: flex; align-items: center; gap: .55rem;
    }

    .logo-badge {
      width: 33px; height: 33px;
      background: linear-gradient(135deg, var(--olive) 0%, var(--olive-light) 100%);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: var(--cream); font-size: .68rem; font-weight: 700;
      letter-spacing: .04em;
    }

    .btn-back {
      display: inline-flex; align-items: center; gap: .4rem;
      padding: .52rem 1.3rem; font-size: .76rem;
      letter-spacing: .08em; text-transform: uppercase;
      background: none; border: 1.5px solid var(--border); color: var(--olive);
      cursor: pointer; font-family: 'Jost', sans-serif; text-decoration: none;
      border-radius: 8px; transition: all .22s;
    }
    .btn-back:hover { background: var(--olive-pale); border-color: var(--olive); }

    /* ════════════════════════════
       CONTAINER
    ════════════════════════════ */
    .container { max-width: 840px; margin: 0 auto; padding: 3rem 2rem 5rem; }

    .page-eyebrow {
      font-size: .65rem; letter-spacing: .22em; text-transform: uppercase;
      color: var(--lilac-deep); margin-bottom: .55rem;
      display: flex; align-items: center; gap: .5rem;
    }
    .page-eyebrow::before { content: ''; width: 16px; height: 1px; background: var(--lilac-deep); }

    .page-title {
      font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 400;
      margin-bottom: .35rem; animation: fadeUp .5s ease both;
    }
    .page-title em { font-style: italic; color: var(--olive); }

    .page-sub {
      font-size: .87rem; color: var(--gray); margin-bottom: 2.8rem;
      font-weight: 300; animation: fadeUp .55s ease .06s both;
    }

    /* ════════════════════════════
       DESIGN PREVIEW
    ════════════════════════════ */
    .design-preview {
      display: flex; gap: 1.8rem; align-items: center;
      background: linear-gradient(135deg, var(--olive-pale) 0%, var(--lilac-pale) 100%);
      padding: 1.8rem 2rem; border-radius: 18px;
      border: 1px solid rgba(92,107,58,.12);
      margin-bottom: 2.5rem;
      box-shadow: 0 6px 32px rgba(92,107,58,.09);
      animation: fadeUp .55s ease .1s both;
    }

    .preview-img {
      width: 100px; height: 120px; flex-shrink: 0;
      overflow: hidden; border-radius: 10px;
      background: linear-gradient(135deg, var(--lilac) 0%, var(--lilac-deep) 100%);
      display: flex; align-items: center; justify-content: center; font-size: 2.4rem;
      box-shadow: 0 8px 24px rgba(155,135,176,.3);
    }
    .preview-img img { width: 100%; height: 100%; object-fit: cover; }

    .preview-kat {
      font-size: .62rem; letter-spacing: .2em; text-transform: uppercase;
      color: var(--olive); margin-bottom: .4rem;
    }
    .preview-nama {
      font-family: 'Playfair Display', serif; font-size: 1.35rem; font-weight: 400;
      margin-bottom: .3rem; color: var(--dark);
    }
    .preview-desc { font-size: .8rem; color: var(--gray); margin-bottom: .6rem; line-height: 1.5; }
    .preview-harga { color: var(--lilac-deep); font-weight: 500; font-size: .92rem; margin-bottom: .4rem; }
    .preview-total {
      display: inline-block;
      background: var(--olive); color: #fff;
      font-size: .75rem; letter-spacing: .08em; text-transform: uppercase;
      padding: .38rem 1rem; border-radius: 20px; font-weight: 500;
    }

    /* ════════════════════════════
       SECTION CARD
    ════════════════════════════ */
    .section-card {
      background: #fff; border-radius: 18px;
      border: 1px solid rgba(92,107,58,.08);
      padding: 2rem 2.2rem;
      margin-bottom: 1.4rem;
      box-shadow: 0 4px 24px rgba(92,107,58,.06);
      animation: fadeUp .55s ease both;
    }

    .section-card:nth-of-type(2) { animation-delay: .06s; }
    .section-card:nth-of-type(3) { animation-delay: .12s; }
    .section-card:nth-of-type(4) { animation-delay: .18s; }
    .section-card:nth-of-type(5) { animation-delay: .24s; }

    .section-top {
      display: flex; align-items: center; gap: .7rem;
      margin-bottom: 1.6rem; padding-bottom: 1rem;
      border-bottom: 1px solid rgba(92,107,58,.07);
    }

    .section-num {
      width: 28px; height: 28px;
      background: var(--olive-faint);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-size: .72rem; color: var(--olive); font-weight: 600;
      flex-shrink: 0;
    }

    .section-title {
      font-family: 'Playfair Display', serif;
      font-size: .95rem; font-weight: 500; color: var(--dark);
    }

    /* ════════════════════════════
       FORM FIELDS
    ════════════════════════════ */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; }
    .form-group { display: flex; flex-direction: column; gap: .45rem; }
    .form-group.full { grid-column: 1/-1; }

    .field-label {
      font-size: .65rem; letter-spacing: .16em; text-transform: uppercase;
      color: var(--gray); font-weight: 500;
    }

    input, select, textarea {
      background: var(--bg);
      border: 1.5px solid rgba(92,107,58,.13);
      color: var(--dark);
      padding: .82rem 1.1rem;
      font-family: 'Jost', sans-serif; font-size: .88rem;
      outline: none; border-radius: 10px;
      transition: border-color .22s, box-shadow .22s, background .22s;
      width: 100%;
    }
    input:focus, select:focus, textarea:focus {
      border-color: var(--olive);
      box-shadow: 0 0 0 3px rgba(92,107,58,.1);
      background: #fff;
    }
    .is-invalid { border-color: #e53935 !important; }
    .invalid-feedback { font-size: .75rem; color: #e53935; }
    textarea { resize: vertical; min-height: 85px; }

    /* ════════════════════════════
       PAYMENT METHOD TABS
    ════════════════════════════ */
    .payment-tabs {
      display: flex; gap: .8rem; flex-wrap: wrap; margin-bottom: 1.6rem;
    }

    .payment-tab-btn {
      display: flex; align-items: center; gap: .55rem;
      padding: .78rem 1.4rem;
      border: 2px solid var(--border); border-radius: 11px;
      background: var(--bg); cursor: pointer;
      font-family: 'Jost', sans-serif; font-size: .86rem; color: var(--dark);
      transition: all .25s; font-weight: 400;
    }
    .payment-tab-btn .tab-icon { font-size: 1.1rem; }

    .payment-tab-btn:hover {
      border-color: var(--olive); background: var(--olive-faint); color: var(--olive);
    }
    .payment-tab-btn.active {
      border-color: var(--olive); background: var(--olive-pale);
      color: var(--olive); font-weight: 500;
      box-shadow: 0 4px 14px rgba(92,107,58,.15);
    }
    .payment-tab-btn.active-lilac {
      border-color: var(--lilac-deep); background: var(--lilac-pale);
      color: var(--lilac-deep); font-weight: 500;
      box-shadow: 0 4px 14px rgba(155,135,176,.2);
    }

    input[type="radio"].pay-radio { display: none; }

    /* ── Payment Boxes ── */
    .payment-box { display: none; animation: fadeIn .32s ease; }
    .payment-box.show { display: block; }

    /* QRIS */
    .qris-box {
      background: linear-gradient(135deg, #fff 0%, var(--lilac-pale) 100%);
      border: 1.5px solid rgba(155,135,176,.28);
      border-radius: 16px; padding: 2.2rem;
      text-align: center;
    }
    .qris-title {
      font-family: 'Playfair Display', serif; font-size: 1.25rem;
      font-weight: 400; margin-bottom: .3rem; color: var(--dark);
    }
    .qris-sub { font-size: .8rem; color: var(--gray); margin-bottom: 1.4rem; }
    .qris-total-label { font-size: .65rem; letter-spacing: .16em; text-transform: uppercase; color: var(--gray); }
    .qris-total-amount {
      font-family: 'Playfair Display', serif; font-size: 1.9rem;
      color: var(--olive); font-weight: 400; margin: .2rem 0 1.4rem;
    }
    .qris-img-wrap {
      display: inline-flex; padding: 1.1rem; background: #fff;
      border: 1.5px solid rgba(155,135,176,.22); border-radius: 12px;
      margin-bottom: 1.3rem; box-shadow: 0 6px 20px rgba(155,135,176,.12);
    }
    .qris-img-wrap img { width: 220px; height: 220px; object-fit: contain; display: block; }
    .qris-apps {
      display: flex; justify-content: center; gap: .55rem; flex-wrap: wrap; margin-bottom: .9rem;
    }
    .app-badge {
      font-size: .72rem; padding: .28rem .8rem;
      border: 1px solid rgba(155,135,176,.38); border-radius: 20px;
      color: var(--lilac-deep); background: #fff;
    }
    .qris-note { font-size: .79rem; color: var(--gray); }

    /* BANK */
    .bank-box {
      background: linear-gradient(135deg, #fff 0%, var(--olive-faint) 100%);
      border: 1.5px solid rgba(92,107,58,.18);
      border-radius: 16px; padding: 2rem;
    }
    .bank-header {
      display: flex; justify-content: space-between; align-items: flex-start;
      margin-bottom: 1.5rem; flex-wrap: wrap; gap: .8rem;
    }
    .bank-logo {
      font-family: 'Playfair Display', serif; font-size: 1.25rem;
      font-weight: 600; color: var(--olive);
    }
    .bank-logo span { font-style: italic; }
    .bank-field-label {
      font-size: .62rem; letter-spacing: .16em; text-transform: uppercase;
      color: var(--gray); margin-bottom: .28rem;
    }
    .bank-field-value { font-size: .92rem; font-weight: 500; color: var(--dark); }
    .bank-rekening {
      font-family: 'Playfair Display', serif; font-size: 1.5rem;
      letter-spacing: .1em; color: var(--olive); margin-bottom: .4rem;
    }
    .copy-btn {
      display: inline-flex; align-items: center; gap: .35rem;
      font-size: .72rem; color: var(--olive); background: none;
      border: 1.5px solid rgba(92,107,58,.2); border-radius: 7px;
      padding: .3rem .75rem; cursor: pointer;
      font-family: 'Jost', sans-serif; transition: all .22s;
    }
    .copy-btn:hover { background: var(--olive-pale); border-color: var(--olive); }
    .bank-divider { height: 1px; background: rgba(92,107,58,.1); margin: 1.3rem 0; }
    .bank-total-row { display: flex; justify-content: space-between; align-items: center; }
    .bank-total-label { font-size: .78rem; color: var(--gray); }
    .bank-total-amount {
      font-family: 'Playfair Display', serif; font-size: 1.7rem;
      color: var(--olive); font-weight: 400;
    }

    /* COD */
    .cod-box {
      background: var(--olive-faint);
      border: 1.5px solid rgba(92,107,58,.18);
      border-radius: 16px; padding: 1.6rem 1.8rem;
      display: flex; align-items: center; gap: 1.2rem;
    }
    .cod-icon-wrap {
      width: 56px; height: 56px;
      background: rgba(255,255,255,.7);
      border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.8rem; flex-shrink: 0;
    }
    .cod-title { font-size: .95rem; font-weight: 500; margin-bottom: .25rem; color: var(--dark); }
    .cod-desc { font-size: .82rem; color: var(--gray); line-height: 1.5; }

    /* ════════════════════════════
       UPLOAD AREAS
    ════════════════════════════ */
    .upload-wrapper {
      border: 2px dashed rgba(155,135,176,.35);
      border-radius: 12px; padding: 2rem;
      text-align: center; background: var(--lilac-pale);
      cursor: pointer;
      transition: border-color .25s, background .25s, transform .25s;
    }
    .upload-wrapper:hover {
      border-color: var(--lilac-deep);
      background: #ebe3f5;
      transform: translateY(-2px);
    }
    .upload-wrapper input { display: none; }
    .upload-icon { font-size: 2.2rem; margin-bottom: .65rem; display: block; }
    .upload-text { font-size: .87rem; color: var(--dark); margin-bottom: .25rem; font-weight: 400; }
    .upload-hint { font-size: .75rem; color: var(--lilac-deep); }

    .upload-preview {
      width: 100%; max-height: 220px; object-fit: cover;
      margin-top: 1.2rem; border-radius: 10px; display: none;
      border: 1.5px solid rgba(155,135,176,.25);
      box-shadow: 0 6px 20px rgba(0,0,0,.08);
    }

    /* ════════════════════════════
       SUBMIT
    ════════════════════════════ */
    .submit-section {
      display: flex; align-items: center; gap: 1.4rem;
      margin-top: .5rem; flex-wrap: wrap;
      padding: 1.5rem 2.2rem;
      background: #fff;
      border-radius: 18px;
      border: 1px solid rgba(92,107,58,.08);
      box-shadow: 0 4px 24px rgba(92,107,58,.06);
    }

    .btn-submit {
      display: inline-flex; align-items: center; gap: .5rem;
      padding: 1rem 2.6rem;
      background: linear-gradient(135deg, var(--olive) 0%, var(--olive-light) 100%);
      color: #fff; font-family: 'Jost', sans-serif;
      font-size: .84rem; letter-spacing: .1em; text-transform: uppercase;
      border: none; cursor: pointer; border-radius: 12px; font-weight: 500;
      box-shadow: 0 6px 22px rgba(92,107,58,.3);
      transition: all .25s ease;
    }
    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(92,107,58,.35);
    }
    .btn-submit:active { transform: translateY(0); }

    .submit-note { font-size: .78rem; color: var(--gray); line-height: 1.5; font-weight: 300; }

    /* ════════════════════════════
       RESPONSIVE
    ════════════════════════════ */
    @media (max-width: 768px) {
      nav { padding: 1rem 1.5rem; }
      .container { padding: 2rem 1.2rem 4rem; }
      .form-grid { grid-template-columns: 1fr; }
      .form-group.full { grid-column: 1; }
      .design-preview { flex-direction: column; align-items: flex-start; }
      .bank-header { flex-direction: column; }
      .section-card { padding: 1.5rem; }
      .submit-section { flex-direction: column; align-items: flex-start; }
    }
  </style>
</head>
<body>

<nav>
  <a class="logo" href="/">
    <div class="logo-badge">OU</div>
    Beauty Bar
  </a>
  <a href="/" class="btn-back">← Kembali</a>
</nav>

<div class="container">
  <p class="page-eyebrow">Booking Online</p>
  <h1 class="page-title">Form <em>Booking</em></h1>
  <p class="page-sub">Isi detail appointment kamu dengan lengkap di bawah ini.</p>

  <!-- DESIGN PREVIEW -->
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
      <p class="preview-desc">{{ $design->deskripsi }}</p>
      <p class="preview-harga">
        @if($design->harga)
          Rp {{ number_format($design->harga, 0, ',', '.') }}
        @else
          Rp {{ number_format($design->harga_min, 0, ',', '.') }} –
          Rp {{ number_format($design->harga_max, 0, ',', '.') }}
        @endif
      </p>
      @php $harga = $design->harga ?? $design->harga_min ?? 0; @endphp
      <span class="preview-total">Total: Rp {{ number_format($harga, 0, ',', '.') }}</span>
    </div>
  </div>

  @php $hargaFormatted = 'Rp ' . number_format($harga, 0, ',', '.'); @endphp

  <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="design_id" value="{{ $design->id }}"/>
    <input type="hidden" name="total_harga" value="{{ $harga }}"/>

    <!-- ── JADWAL ── -->
    <div class="section-card">
      <div class="section-top">
        <div class="section-num">1</div>
        <div class="section-title">Jadwal &amp; Detail Kunjungan</div>
      </div>
      <div class="form-grid">
        <div class="form-group">
          <label class="field-label">Tanggal Kunjungan</label>
          <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                 min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                 class="{{ $errors->has('tanggal') ? 'is-invalid' : '' }}"/>
          @error('tanggal') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
          <label class="field-label">Jam Kunjungan</label>
          <select name="jam" class="{{ $errors->has('jam') ? 'is-invalid' : '' }}">
            <option value="">— Pilih jam —</option>
            @foreach(['09:00','10:00','11:00','13:00','14:00','15:00','16:00'] as $j)
              <option value="{{ $j }}" {{ old('jam') == $j ? 'selected' : '' }}>{{ $j }}</option>
            @endforeach
          </select>
          @error('jam') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
          <label class="field-label">Panjang Kuku</label>
          <select name="panjang_kuku" class="{{ $errors->has('panjang_kuku') ? 'is-invalid' : '' }}">
            <option value="">— Pilih —</option>
            @foreach(['Pendek','Sedang','Panjang'] as $p)
              <option value="{{ $p }}" {{ old('panjang_kuku') == $p ? 'selected' : '' }}>{{ $p }}</option>
            @endforeach
          </select>
          @error('panjang_kuku') <span class="invalid-feedback">{{ $message }}</span> @enderror
        </div>

        <div class="form-group full">
          <label class="field-label">Catatan Tambahan (opsional)</label>
          <textarea name="catatan" placeholder="Warna khusus, detail tambahan, dll...">{{ old('catatan') }}</textarea>
        </div>
      </div>
    </div>

    <!-- ── FOTO REFERENSI ── -->
    <div class="section-card">
      <div class="section-top">
        <div class="section-num">2</div>
        <div class="section-title">Foto Referensi Desain <span style="font-weight:300;color:var(--gray);font-size:.85em">(opsional)</span></div>
      </div>
      <div class="upload-wrapper" onclick="document.getElementById('foto_referensi').click()">
        <input type="file" id="foto_referensi" name="foto_referensi"
               accept="image/*" onchange="previewFoto(this, 'preview-ref')"/>
        <span class="upload-icon">📸</span>
        <p class="upload-text">Klik untuk upload foto referensi desain</p>
        <p class="upload-hint">JPG, PNG — maks. 2MB</p>
        <img id="preview-ref" class="upload-preview" src="" alt="Preview"/>
      </div>
      @error('foto_referensi')
        <span class="invalid-feedback" style="margin-top:.4rem;display:block">{{ $message }}</span>
      @enderror
    </div>

    <!-- ── METODE PEMBAYARAN ── -->
    <div class="section-card">
      <div class="section-top">
        <div class="section-num">3</div>
        <div class="section-title">Metode Pembayaran</div>
      </div>

      <div class="payment-tabs">
        <button type="button"
                class="payment-tab-btn {{ old('metode_bayar') == 'QRIS' ? 'active-lilac' : '' }}"
                id="tabQRIS"
                onclick="pilihPembayaran('QRIS')">
          <span class="tab-icon">📱</span> QRIS
        </button>
        <button type="button"
                class="payment-tab-btn {{ old('metode_bayar') == 'Transfer Bank' ? 'active' : '' }}"
                id="tabBank"
                onclick="pilihPembayaran('Transfer Bank')">
          <span class="tab-icon">🏦</span> Transfer Bank
        </button>
        <button type="button"
                class="payment-tab-btn {{ old('metode_bayar') == 'Bayar di Tempat' ? 'active' : '' }}"
                id="tabCOD"
                onclick="pilihPembayaran('Bayar di Tempat')">
          <span class="tab-icon">💵</span> Bayar di Tempat
        </button>
      </div>

      <input type="radio" class="pay-radio" name="metode_bayar" value="QRIS"         id="payQRIS" {{ old('metode_bayar')=='QRIS' ? 'checked' : '' }}/>
      <input type="radio" class="pay-radio" name="metode_bayar" value="Transfer Bank" id="payBank" {{ old('metode_bayar')=='Transfer Bank' ? 'checked' : '' }}/>
      <input type="radio" class="pay-radio" name="metode_bayar" value="Bayar di Tempat" id="payCOD" {{ old('metode_bayar')=='Bayar di Tempat' ? 'checked' : '' }}/>

      @error('metode_bayar')
        <span class="invalid-feedback" style="margin-bottom:.9rem;display:block">{{ $message }}</span>
      @enderror

      <!-- QRIS -->
      <div class="payment-box {{ old('metode_bayar')=='QRIS' ? 'show' : '' }}" id="boxQRIS">
        <div class="qris-box">
          <h3 class="qris-title">QRIS Payment</h3>
          <p class="qris-sub">Scan sekali, bayar pakai aplikasi apapun</p>
          <p class="qris-total-label">Total Pembayaran</p>
          <p class="qris-total-amount">{{ $hargaFormatted }}</p>
          <div class="qris-img-wrap">
            <img src="{{ asset('images/qris.jpg') }}" alt="QRIS OU Beauty Bar"
                 onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22220%22 height=%22220%22><rect width=%22220%22 height=%22220%22 fill=%22%23f0ebf7%22/><text x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-size=%2214%22 fill=%22%239b87b0%22>QR Code</text></svg>'"/>
          </div>
          <div class="qris-apps">
            <span class="app-badge">DANA</span>
            <span class="app-badge">OVO</span>
            <span class="app-badge">GoPay</span>
            <span class="app-badge">ShopeePay</span>
            <span class="app-badge">M-Banking</span>
          </div>
          <p class="qris-note">Setelah scan, upload bukti pembayaran di bawah ya ✨</p>
        </div>
      </div>

      <!-- TRANSFER BANK -->
      <div class="payment-box {{ old('metode_bayar')=='Transfer Bank' ? 'show' : '' }}" id="boxBank">
        <div class="bank-box">
          <div class="bank-header">
            <div>
              <p class="bank-field-label">Bank</p>
              <p class="bank-logo">BCA <span>/ KlikBCA</span></p>
            </div>
            <div>
              <p class="bank-field-label">Atas Nama</p>
              <p class="bank-field-value">OU Beauty Bar</p>
            </div>
          </div>
          <div>
            <p class="bank-field-label">Nomor Rekening</p>
            <p class="bank-rekening" id="norek">1234 5678 90</p>
            <button type="button" class="copy-btn" onclick="copyRekening()">
              📋 Salin Nomor
            </button>
          </div>
          <div class="bank-divider"></div>
          <div class="bank-total-row">
            <div>
              <p class="bank-field-label">Total Transfer</p>
              <p style="font-size:.76rem;color:var(--gray)">Nominal harus tepat</p>
            </div>
            <p class="bank-total-amount">{{ $hargaFormatted }}</p>
          </div>
        </div>
      </div>

      <!-- BAYAR DI TEMPAT -->
      <div class="payment-box {{ old('metode_bayar')=='Bayar di Tempat' ? 'show' : '' }}" id="boxCOD">
        <div class="cod-box">
          <div class="cod-icon-wrap">💵</div>
          <div>
            <p class="cod-title">Bayar di Tempat (Cash)</p>
            <p class="cod-desc">
              Siapkan uang tunai sebesar <strong>{{ $hargaFormatted }}</strong> saat datang ke salon.<br>
              Tidak perlu upload bukti pembayaran.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- ── UPLOAD BUKTI PEMBAYARAN ── -->
    <div class="section-card" id="sectionBukti"
         style="{{ old('metode_bayar') == 'Bayar di Tempat' ? 'display:none' : '' }}">
      <div class="section-top">
        <div class="section-num">4</div>
        <div class="section-title">Bukti Pembayaran</div>
      </div>
      <div class="upload-wrapper" onclick="document.getElementById('bukti_pembayaran').click()">
        <input type="file" id="bukti_pembayaran" name="bukti_pembayaran"
               accept=".jpg,.jpeg,.png" onchange="previewFoto(this, 'preview-bukti')"/>
        <span class="upload-icon">🧾</span>
        <p class="upload-text">Upload bukti transfer atau screenshot pembayaran</p>
        <p class="upload-hint">JPG, JPEG, PNG — maks. 4MB</p>
        <img id="preview-bukti" class="upload-preview" src="" alt="Preview bukti"/>
      </div>
      @error('bukti_pembayaran')
        <span class="invalid-feedback" style="margin-top:.4rem;display:block">{{ $message }}</span>
      @enderror
    </div>

    <!-- ── SUBMIT ── -->
    <div class="submit-section">
      <button type="submit" class="btn-submit">Konfirmasi Booking →</button>
      <p class="submit-note">
        Booking akan dikonfirmasi oleh tim kami<br>
        dalam 1×24 jam kerja.
      </p>
    </div>

  </form>
</div>

<script>
function previewFoto(input, previewId) {
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

function pilihPembayaran(metode) {
  ['boxQRIS','boxBank','boxCOD'].forEach(id => {
    document.getElementById(id).classList.remove('show');
  });
  ['tabQRIS','tabBank','tabCOD'].forEach(id => {
    document.getElementById(id).classList.remove('active','active-lilac');
  });

  if (metode === 'QRIS') {
    document.getElementById('boxQRIS').classList.add('show');
    document.getElementById('tabQRIS').classList.add('active-lilac');
    document.getElementById('payQRIS').checked = true;
    document.getElementById('sectionBukti').style.display = '';
  } else if (metode === 'Transfer Bank') {
    document.getElementById('boxBank').classList.add('show');
    document.getElementById('tabBank').classList.add('active');
    document.getElementById('payBank').checked = true;
    document.getElementById('sectionBukti').style.display = '';
  } else if (metode === 'Bayar di Tempat') {
    document.getElementById('boxCOD').classList.add('show');
    document.getElementById('tabCOD').classList.add('active');
    document.getElementById('payCOD').checked = true;
    document.getElementById('sectionBukti').style.display = 'none';
  }
}

function copyRekening() {
  const norek = document.getElementById('norek').textContent.replace(/\s/g,'');
  navigator.clipboard.writeText(norek).then(() => {
    const btn = document.querySelector('.copy-btn');
    btn.textContent = '✅ Tersalin!';
    setTimeout(() => { btn.textContent = '📋 Salin Nomor'; }, 2000);
  });
}

(function() {
  const old = '{{ old("metode_bayar") }}';
  if (old) pilihPembayaran(old);
})();
</script>
</body>
</html>