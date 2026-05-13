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

    @media(max-width:768px) {
      nav { padding: 1rem 1.5rem; }
      .container { padding: 2rem 1.2rem; }
      .form-grid, .payment-options { grid-template-columns: 1fr; }
      .form-group.full { grid-column: 1; }
      .design-preview { flex-direction: column; }
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
        Rp {{ number_format($design->harga_min, 0, ',', '.') }} –
        Rp {{ number_format($design->harga_max, 0, ',', '.') }}
      </p>
    </div>
  </div>

  <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="design_id" value="{{ $design->id }}"/>
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

      <!-- FOTO REFERENSI -->
      <div class="form-group full">
        <label>Foto Referensi Desain (opsional)</label>
        <div class="upload-area" onclick="document.getElementById('foto_referensi').click()">
          <input type="file" id="foto_referensi" name="foto_referensi"
                 accept="image/*" onchange="previewFoto(this)"/>
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
function previewFoto(input) {
  const preview = document.getElementById('preview-foto');
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      preview.src = e.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>

</body>
</html>