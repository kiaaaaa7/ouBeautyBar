<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin — OU Beauty Bar</title>
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
    .page-title { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 400; margin-bottom: .3rem; }
    .page-title em { font-style: italic; color: var(--olive); }
    .page-sub { font-size: .85rem; color: var(--gray); margin-bottom: 2rem; }
    .alert { padding: .9rem 1.2rem; font-size: .85rem; margin-bottom: 1.5rem; border-left: 4px solid var(--olive); background: var(--olive-pale); color: var(--olive); }
    .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 1.2rem; margin-bottom: 2rem; }
    .stat-card { background: white; padding: 1.8rem; border-radius: 6px; border: 1px solid rgba(92,107,58,.1); }
    .stat-icon { font-size: 1.5rem; margin-bottom: .8rem; display: block; }
    .stat-num { font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--olive); display: block; line-height: 1; }
    .stat-label { font-size: .72rem; letter-spacing: .1em; text-transform: uppercase; color: var(--gray); margin-top: .3rem; display: block; }
    .quick-links { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; }
    .quick-card { background: white; padding: 2rem; border-radius: 6px; border: 1px solid rgba(92,107,58,.1); text-decoration: none; color: var(--dark); transition: transform .2s, box-shadow .2s, border-color .2s; }
    .quick-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(92,107,58,.12); border-color: var(--olive); }
    .quick-icon { font-size: 2rem; margin-bottom: 1rem; display: block; }
    .quick-card h3 { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 400; margin-bottom: .3rem; }
    .quick-card p { font-size: .82rem; color: var(--gray); }
  </style>
</head>
<body>
<div class="sidebar">
  <a class="sidebar-logo" href="/">
    <div class="logo-badge">OU</div> Beauty Bar
  </a>
  <ul class="sidebar-menu">
    <li><a href="{{ route('admin.index') }}" class="active">📊 Dashboard</a></li>
    <li><a href="{{ route('admin.appointments') }}">📅 Appointments</a></li>
    <li><a href="{{ route('admin.designs') }}">💅 Desain</a></li>
  </ul>
  <div class="sidebar-bottom">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button class="logout-btn" type="submit">🚪 Logout</button>
    </form>
  </div>
</div>
<div class="main">
  <h1 class="page-title">Dashboard <em>Admin</em></h1>
  <p class="page-sub">Selamat datang, {{ auth()->user()->name }}!</p>
  @if(session('success'))
    <div class="alert">✅ {{ session('success') }}</div>
  @endif
  <div class="stats-grid">
    <div class="stat-card"><span class="stat-icon">📅</span><span class="stat-num">{{ $totalAppointments }}</span><span class="stat-label">Total Appointment</span></div>
    <div class="stat-card"><span class="stat-icon">⏳</span><span class="stat-num">{{ $pendingAppointments }}</span><span class="stat-label">Menunggu Konfirmasi</span></div>
    <div class="stat-card"><span class="stat-icon">👥</span><span class="stat-num">{{ $totalCustomers }}</span><span class="stat-label">Total Customer</span></div>
    <div class="stat-card"><span class="stat-icon">💅</span><span class="stat-num">{{ $totalDesigns }}</span><span class="stat-label">Total Desain</span></div>
  </div>
  <div class="quick-links">
    <a href="{{ route('admin.appointments') }}" class="quick-card">
      <span class="quick-icon">📅</span>
      <h3>Kelola Appointment</h3>
      <p>Lihat, konfirmasi, dan hapus appointment customer</p>
    </a>
    <a href="{{ route('admin.customers') }}" class="quick-card">
  <span class="quick-icon">👥</span>
  <h3>Data Customer</h3>
  <p>Lihat daftar customer dan hubungi via WhatsApp</p>
</a>
  </div>
</div>
</body>
</html>