<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Desain — Admin OU Beauty Bar</title>
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
    .logout-btn { background: none; border: none; color: rgba(255,255,255,.55); font-size: .82rem; cursor: pointer; font-family: inherit; padding: .75rem 1rem; width: 100%; text-align: left; border-radius: 4px; transition: all .2s; }
    .logout-btn:hover { background: rgba(255,255,255,.1); color: white; }
    .main { flex: 1; padding: 2.5rem; overflow-y: auto; }
    .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 400; }
    .page-title em { font-style: italic; color: var(--olive); }
    .btn { display: inline-block; padding: .6rem 1.5rem; font-size: .8rem; letter-spacing: .08em; text-transform: uppercase; text-decoration: none; border: none; cursor: pointer; font-family: 'Jost', sans-serif; transition: all .2s; border-radius: 4px; }
    .btn-olive { background: var(--olive); color: white; }
    .btn-olive:hover { background: var(--olive-light); }
    .alert { padding: .9rem 1.2rem; font-size: .85rem; margin-bottom: 1.5rem; border-left: 4px solid var(--olive); background: var(--olive-pale); color: var(--olive); }
    .designs-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.2rem; }
    .design-card { background: white; border-radius: 6px; border: 1px solid rgba(92,107,58,.1); overflow: hidden; transition: transform .3s, box-shadow .3s; }
    .design-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(92,107,58,.12); }
    .design-img { width: 100%; height: 180px; background: var(--lilac-pale); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; overflow: hidden; }
    .design-img img { width: 100%; height: 100%; object-fit: cover; }
    .design-body { padding: 1.2rem; }
    .design-kat { font-size: .66rem; letter-spacing: .12em; text-transform: uppercase; color: var(--olive); margin-bottom: .3rem; }
    .design-nama { font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 400; margin-bottom: .3rem; }
    .design-harga { font-size: .85rem; color: var(--lilac-deep); font-weight: 500; margin-bottom: 1rem; }
    .btn-del { background: none; border: 1px solid rgba(155,135,176,.3); padding: .35rem .9rem; font-size: .74rem; cursor: pointer; color: var(--lilac-deep); border-radius: 4px; font-family: inherit; transition: all .2s; }
    .btn-del:hover { background: var(--lilac-deep); color: white; border-color: var(--lilac-deep); }
    .btn-edit { display: inline-block; background: var(--olive-pale); border: 1px solid rgba(92,107,58,.3); padding: .35rem .9rem; font-size: .74rem; color: var(--olive); border-radius: 4px; text-decoration: none; transition: all .2s; }
    .btn-edit:hover { background: var(--olive); color: white; }
    .empty-state { text-align: center; padding: 3rem; color: var(--gray); grid-column: 1/-1; }
  </style>
</head>
<body>
<div class="sidebar">
  <a class="sidebar-logo" href="/"><div class="logo-badge">OU</div> Beauty Bar</a>
  <ul class="sidebar-menu">
    <li><a href="{{ route('admin.index') }}">📊 Dashboard</a></li>
    <li><a href="{{ route('admin.appointments') }}">📅 Appointments</a></li>
    <li><a href="{{ route('admin.designs') }}" class="active">💅 Desain</a></li>
    <li><a href="{{ route('admin.customers') }}">👥 Customer</a></li>
  </ul>
  <div class="sidebar-bottom">
    <form action="{{ route('logout') }}" method="POST">
      @csrf <button class="logout-btn" type="submit">🚪 Logout</button>
    </form>
  </div>
</div>
<div class="main">
  <div class="top-bar">
    <h1 class="page-title">Kelola <em>Desain</em></h1>
    <a href="{{ route('admin.designs.create') }}" class="btn btn-olive">+ Tambah Desain</a>
  </div>
  @if(session('success'))
    <div class="alert">✅ {{ session('success') }}</div>
  @endif
  <div class="designs-grid">
    @forelse($designs as $design)
      <div class="design-card">
        <div class="design-img">
          @if($design->gambar)
            <img src="{{ asset('storage/' . $design->gambar) }}" alt="{{ $design->nama }}"/>
          @else 💅
          @endif
        </div>
        <div class="design-body">
          <p class="design-kat">{{ $design->kategori }}</p>
          <h3 class="design-nama">{{ $design->nama }}</h3>
          <p class="design-harga">
            @if($design->harga_type === 'estimasi')
              Rp {{ number_format($design->harga_min,0,',','.') }} – Rp {{ number_format($design->harga_max,0,',','.') }}
            @else
              Rp {{ number_format($design->harga,0,',','.') }}
            @endif
          </p>
          <div style="display:flex;gap:.6rem;flex-wrap:wrap">
            <a href="{{ route('admin.designs.edit', $design->id) }}" class="btn-edit">✏️ Edit</a>
            <form action="{{ route('admin.designs.destroy', $design->id) }}" method="POST"
                  onsubmit="return confirm('Hapus desain ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn-del">🗑️ Hapus</button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <p class="empty-state">Belum ada desain. Tambah sekarang!</p>
    @endforelse
  </div>
</div>
</body>
</html>