<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Appointments — Admin OU Beauty Bar</title>
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
    .page-title { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 400; margin-bottom: 1.5rem; }
    .page-title em { font-style: italic; color: var(--olive); }
    .alert { padding: .9rem 1.2rem; font-size: .85rem; margin-bottom: 1.5rem; border-left: 4px solid var(--olive); background: var(--olive-pale); color: var(--olive); }
    .filter-bar { display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .filter-bar input, .filter-bar select { background: white; border: 1px solid rgba(92,107,58,.2); color: var(--dark); padding: .6rem 1rem; font-family: 'Jost', sans-serif; font-size: .85rem; outline: none; border-radius: 4px; transition: border-color .2s; }
    .filter-bar input:focus, .filter-bar select:focus { border-color: var(--olive); }
    .filter-bar button { background: var(--olive); color: white; border: none; padding: .6rem 1.4rem; cursor: pointer; font-family: inherit; font-size: .82rem; border-radius: 4px; transition: background .2s; }
    .filter-bar button:hover { background: var(--olive-light); }
    .card { background: white; border-radius: 6px; border: 1px solid rgba(92,107,58,.1); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; font-size: .83rem; }
    th { text-align: left; padding: .9rem 1rem; font-size: .68rem; letter-spacing: .1em; text-transform: uppercase; color: var(--gray); border-bottom: 1px solid rgba(92,107,58,.1); background: var(--olive-pale); }
    td { padding: .85rem 1rem; border-bottom: 1px solid rgba(92,107,58,.07); vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #f9faf6; }
    .badge { font-size: .68rem; letter-spacing: .06em; text-transform: uppercase; padding: .3rem .8rem; border-radius: 20px; }
    .badge-pending { background: #fff3e0; color: #e65100; }
    .badge-konfirmasi { background: var(--lilac-pale); color: var(--lilac-deep); }
    .badge-selesai { background: var(--olive-pale); color: var(--olive); }
    .actions { display: flex; gap: .5rem; align-items: center; flex-wrap: wrap; }
    select.status-select { font-size: .78rem; padding: .35rem .6rem; border: 1px solid rgba(92,107,58,.25); border-radius: 4px; background: white; color: var(--dark); font-family: inherit; cursor: pointer; outline: none; }
    .btn-del { background: none; border: 1px solid rgba(155,135,176,.4); padding: .35rem .8rem; font-size: .72rem; cursor: pointer; color: var(--lilac-deep); border-radius: 4px; font-family: inherit; transition: all .2s; }
    .btn-del:hover { background: var(--lilac-deep); color: white; border-color: var(--lilac-deep); }
    .foto-thumb { width: 38px; height: 38px; object-fit: cover; border-radius: 4px; cursor: pointer; border: 1px solid rgba(92,107,58,.2); transition: transform .2s; }
    .foto-thumb:hover { transform: scale(1.1); }
    .empty-state { text-align: center; padding: 3rem; color: var(--gray); }
  </style>
</head>
<body>
<div class="sidebar">
  <a class="sidebar-logo" href="/"><div class="logo-badge">OU</div> Beauty Bar</a>
  <ul class="sidebar-menu">
    <li><a href="{{ route('admin.index') }}">📊 Dashboard</a></li>
    <li><a href="{{ route('admin.appointments') }}" class="active">📅 Appointments</a></li>
    <li><a href="{{ route('admin.designs') }}">💅 Desain</a></li>
  </ul>
  <div class="sidebar-bottom">
    <form action="{{ route('logout') }}" method="POST">
      @csrf <button class="logout-btn" type="submit">🚪 Logout</button>
    </form>
  </div>
</div>
<div class="main">
  <h1 class="page-title">Kelola <em>Appointment</em></h1>
  @if(session('success'))
    <div class="alert">✅ {{ session('success') }}</div>
  @endif
  <form method="GET" action="{{ route('admin.appointments') }}" class="filter-bar">
    <input type="text" name="search" placeholder="Cari nama customer..." value="{{ request('search') }}"/>
    <select name="status">
      <option value="">Semua Status</option>
      @foreach(['Pending','Konfirmasi','Selesai'] as $s)
        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
      @endforeach
    </select>
    <button type="submit">Cari</button>
  </form>
  <div class="card">
    @if($appointments->isEmpty())
      <p class="empty-state">Tidak ada appointment ditemukan.</p>
    @else
      <table>
        <thead>
          <tr><th>#</th><th>Customer</th><th>Desain</th><th>Tanggal</th><th>Jam</th><th>Bayar</th><th>Foto</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
          @foreach($appointments as $i => $appt)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td><strong>{{ $appt->user->name }}</strong><br><small style="color:var(--gray)">{{ $appt->user->email }}</small></td>
            <td>{{ $appt->design->nama }}</td>
            <td>{{ \Carbon\Carbon::parse($appt->tanggal)->format('d M Y') }}</td>
            <td>{{ $appt->jam }}</td>
            <td>{{ $appt->metode_bayar }}</td>
            <td>
              @if($appt->foto_referensi)
                <img src="{{ asset('storage/' . $appt->foto_referensi) }}" class="foto-thumb" onclick="window.open(this.src)" title="Klik untuk lihat"/>
              @else <span style="color:var(--gray);font-size:.78rem">—</span>
              @endif
            </td>
            <td><span class="badge badge-{{ strtolower($appt->status) }}">{{ $appt->status }}</span></td>
            <td>
              <div class="actions">
                <form action="{{ route('admin.appointments.status', $appt->id) }}" method="POST">
                  @csrf @method('PATCH')
                  <select name="status" class="status-select" onchange="this.form.submit()">
                    @foreach(['Pending','Konfirmasi','Selesai'] as $s)
                      <option value="{{ $s }}" {{ $appt->status == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                  </select>
                </form>
                <form action="{{ route('admin.appointments.destroy', $appt->id) }}" method="POST" onsubmit="return confirm('Hapus appointment ini?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-del">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</div>
</body>
</html>