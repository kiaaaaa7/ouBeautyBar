<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Desain — Admin OU Beauty Bar</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root { --olive:#5C6B3A; --olive-light:#7A8C4E; --olive-pale:#E8EDD8; --lilac:#C4B5D4; --lilac-deep:#9B87B0; --lilac-pale:#F0EBF7; --cream:#FAF8F5; --dark:#2C2C2C; --gray:#6B6B6B; }
    body { font-family: 'Jost', sans-serif; background: #F2F4EE; color: var(--dark); display: flex; min-height: 100vh; }
    .sidebar { width: 240px; background: var(--olive); color: white; padding: 2rem 1.5rem; flex-shrink: 0; display: flex; flex-direction: column; }
    .sidebar-logo { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 600; margin-bottom: 2.5rem; display: flex; align-items: center; gap: .6rem; text-decoration: none; color: white; }
    .logo-badge { width: 34px; height: 34px; background: var(--lilac); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--olive); font-size: .72rem; font-weight: 700; }
    .sidebar-menu { list-style: none; display: flex; flex-direction: column; gap: .3rem; }
    .sidebar-menu a { display: block; padding: .75rem 1rem; font-size: .82rem; text-decoration: none; color: rgba(255,255,255,.65); border-radius: 4px; transition: all .2s; }
    .sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(255,255,255,.15); color: white; }
    .sidebar-bottom { margin-top: auto; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,.15); }
    .logout-btn { background: none; border: none; color: rgba(255,255,255,.55); font-size: .82rem; cursor: pointer; font-family: inherit; padding: .75rem 1rem; width: 100%; text-align: left; border-radius: 4px; }
    .logout-btn:hover { background: rgba(255,255,255,.1); color: white; }
    .main { flex: 1; padding: 2.5rem; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 400; margin-bottom: 2rem; }
    .page-title em { font-style: italic; color: var(--olive); }
    .form-card { background: white; padding: 2.5rem; border-radius: 6px; border: 1px solid rgba(92,107,58,.1); max-width: 600px; }
    .form-group { margin-bottom: 1.3rem; }
    label { display: block; font-size: .7rem; letter-spacing: .12em; text-transform: uppercase; color: var(--gray); margin-bottom: .45rem; }
    input, select, textarea { width: 100%; background: white; border: 1px solid rgba(92,107,58,.2); color: var(--dark); padding: .78rem 1rem; font-family: 'Jost', sans-serif; font-size: .88rem; outline: none; border-radius: 4px; transition: border-color .2s; }
    input:focus, select:focus, textarea:focus { border-color: var(--olive); }
    .is-invalid { border-color: #e53935 !important; }
    .invalid-feedback { font-size: .75rem; color: #e53935; margin-top: .3rem; display: block; }
    textarea { resize: vertical; min-height: 80px; }
    .harga-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .harga-section { display: none; }
    .harga-section.active { display: block; }
    .radio-group { display: flex; gap: 1rem; }
    .radio-option input { display: none; }
    .radio-option label {
      display: block; padding: .7rem 1.5rem;
      border: 1.5px solid rgba(92,107,58,.2);
      border-radius: 4px; cursor: pointer;
      font-size: .82rem; transition: all .2s;
      text-transform: none; letter-spacing: 0; color: var(--dark);
    }
    .radio-option input:checked + label { border-color: var(--olive); background: var(--olive-pale); color: var(--olive); font-weight: 500; }
    .btn { display: inline-block; padding: .7rem 1.8rem; font-size: .8rem; letter-spacing: .08em; text-transform: uppercase; border: none; cursor: pointer; font-family: 'Jost', sans-serif; transition: all .2s; border-radius: 4px; text-decoration: none; }
    .btn-olive { background: var(--olive); color: white; }
    .btn-olive:hover { background: var(--olive-light); }
    .btn-outline { background: none; border: 1.5px solid rgba(92,107,58,.3); color: var(--olive); margin-left: .8rem; }
    .btn-outline:hover { background: var(--olive-pale); }
    .current-img { width: 100%; max-height: 160px; object-fit: cover; border-radius: 4px; margin-bottom: .8rem; }
    .upload-area { border: 2px dashed rgba(92,107,58,.25); padding: 1.2rem; text-align: center; background: var(--olive-pale); cursor: pointer; border-radius: 4px; }
    .upload-area:hover { border-color: var(--olive); }
    #preview-img { width: 100%; max-height: 160px; object-fit: cover; margin-top: .8rem; display: none; border-radius: 4px; }
  </style>
</head>
<body>
<div class="sidebar">
  <a class="sidebar-logo" href="/"><div class="logo-badge">OU</div> Beauty Bar</a>
  <ul class="sidebar-menu">
    <li><a href="{{ route('admin.index') }}">📊 Dashboard</a></li>
    <li><a href="{{ route('admin.appointments') }}">📅 Appointments</a></li>
    <li><a href="{{ route('admin.designs') }}" class="active">💅 Desain</a></li>
  </ul>
  <div class="sidebar-bottom">
    <form action="{{ route('logout') }}" method="POST">
      @csrf <button class="logout-btn" type="submit">🚪 Logout</button>
    </form>
  </div>
</div>
<div class="main">
  <h1 class="page-title">Edit <em>Desain</em></h1>
  <div class="form-card">
    <form action="{{ route('admin.designs.update', $design->id) }}" method="POST" enctype="multipart/form-data">
      @csrf @method('PUT')

      <div class="form-group">
        <label>Nama Desain</label>
        <input type="text" name="nama" value="{{ old('nama', $design->nama) }}"
               class="{{ $errors->has('nama') ? 'is-invalid' : '' }}"/>
        @error('nama') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label>Kategori</label>
        <select name="kategori" class="{{ $errors->has('kategori') ? 'is-invalid' : '' }}">
          @foreach(['Gel Classic','Nail Art 2D','3D Nail Art','Soft Gel Extension','Manicure','Nail Stamping'] as $k)
            <option value="{{ $k }}" {{ old('kategori', $design->kategori) == $k ? 'selected' : '' }}>{{ $k }}</option>
          @endforeach
        </select>
        @error('kategori') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="{{ $errors->has('deskripsi') ? 'is-invalid' : '' }}">{{ old('deskripsi', $design->deskripsi) }}</textarea>
        @error('deskripsi') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label>Tipe Harga</label>
        <div class="radio-group">
          <div class="radio-option">
            <input type="radio" name="harga_type" id="type_tetap" value="tetap"
                   {{ old('harga_type', $design->harga_type) == 'tetap' ? 'checked' : '' }}
                   onchange="toggleHarga()"/>
            <label for="type_tetap">💰 Harga Tetap</label>
          </div>
          <div class="radio-option">
            <input type="radio" name="harga_type" id="type_estimasi" value="estimasi"
                   {{ old('harga_type', $design->harga_type) == 'estimasi' ? 'checked' : '' }}
                   onchange="toggleHarga()"/>
            <label for="type_estimasi">📊 Estimasi Range</label>
          </div>
        </div>
      </div>

      <div class="form-group harga-section" id="harga_tetap">
        <label>Harga (Rp)</label>
        <input type="number" name="harga" value="{{ old('harga', $design->harga) }}" placeholder="85000"/>
        @error('harga') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>

      <div class="form-group harga-section" id="harga_estimasi">
        <label>Estimasi Harga (Rp)</label>
        <div class="harga-grid">
          <div>
            <input type="number" name="harga_min" value="{{ old('harga_min', $design->harga_min) }}" placeholder="Min"/>
            @error('harga_min') <span class="invalid-feedback">{{ $message }}</span> @enderror
          </div>
          <div>
            <input type="number" name="harga_max" value="{{ old('harga_max', $design->harga_max) }}" placeholder="Max"/>
            @error('harga_max') <span class="invalid-feedback">{{ $message }}</span> @enderror
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Foto Desain</label>
        @if($design->gambar)
          <img src="{{ asset('storage/' . $design->gambar) }}" class="current-img" alt="Foto saat ini"/>
          <p style="font-size:.75rem;color:var(--gray);margin-bottom:.5rem">Upload foto baru untuk mengganti</p>
        @endif
        <div class="upload-area" onclick="document.getElementById('gambar').click()">
          <input type="file" id="gambar" name="gambar" accept="image/*"
                 onchange="previewImg(this)" style="display:none"/>
          <p style="font-size:.82rem;color:var(--gray)">📷 Klik untuk ganti foto</p>
          <img id="preview-img" src="" alt="Preview"/>
        </div>
        @error('gambar') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>

      <div style="margin-top:1.5rem">
        <button type="submit" class="btn btn-olive">Simpan Perubahan</button>
        <a href="{{ route('admin.designs') }}" class="btn btn-outline">Batal</a>
      </div>
    </form>
  </div>
</div>
<script>
function toggleHarga() {
  const type = document.querySelector('input[name="harga_type"]:checked')?.value;
  document.getElementById('harga_tetap').classList.toggle('active', type === 'tetap');
  document.getElementById('harga_estimasi').classList.toggle('active', type === 'estimasi');
}
function previewImg(input) {
  const preview = document.getElementById('preview-img');
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
    reader.readAsDataURL(input.files[0]);
  }
}
window.addEventListener('load', toggleHarga);
</script>
</body>
</html>