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
    .sidebar-menu a { display: block; padding: .75rem 1rem; font-size: .82rem; text-decoration: none; color: rgba(255,255,255,.65); border-radius: 4px; transition: all .2s; position: relative; }
    .sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(255,255,255,.15); color: white; }
    .sidebar-bottom { margin-top: auto; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,.15); }
    .logout-btn { background: none; border: none; color: rgba(255,255,255,.55); font-size: .82rem; cursor: pointer; font-family: inherit; padding: .75rem 1rem; width: 100%; text-align: left; border-radius: 4px; transition: all .2s; }
    .logout-btn:hover { background: rgba(255,255,255,.1); color: white; }

    .notif-badge { display: inline-flex; align-items: center; justify-content: center; background: #e53935; color: white; font-size: .62rem; font-weight: 700; min-width: 18px; height: 18px; border-radius: 9px; padding: 0 5px; position: absolute; right: .8rem; top: 50%; transform: translateY(-50%); animation: pulse 2s infinite; }
    @keyframes pulse { 0%, 100% { box-shadow: 0 0 0 0 rgba(229,57,53,.4); } 50% { box-shadow: 0 0 0 6px rgba(229,57,53,0); } }

    .notif-popup { position: fixed; top: 1.5rem; right: 1.5rem; z-index: 999; background: white; border-radius: 10px; box-shadow: 0 8px 32px rgba(0,0,0,.15); padding: 1.2rem 1.5rem; max-width: 320px; width: 100%; border-left: 4px solid #e53935; animation: slideIn .4s ease; display: flex; gap: 1rem; align-items: flex-start; }
    .notif-popup.hide { animation: slideOut .3s ease forwards; }
    @keyframes slideIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }
    @keyframes slideOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100%); } }
    .notif-popup-icon { font-size: 1.8rem; flex-shrink: 0; }
    .notif-popup-body h4 { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 600; margin-bottom: .2rem; }
    .notif-popup-body p { font-size: .8rem; color: var(--gray); line-height: 1.5; }
    .notif-popup-body a { font-size: .78rem; color: var(--olive); text-decoration: none; font-weight: 500; margin-top: .5rem; display: inline-block; }
    .notif-popup-close { position: absolute; top: .6rem; right: .8rem; background: none; border: none; cursor: pointer; font-size: 1rem; color: var(--gray); }

    .main { flex: 1; padding: 2.5rem; overflow-y: auto; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 400; margin-bottom: .3rem; }
    .page-title em { font-style: italic; color: var(--olive); }
    .page-sub { font-size: .85rem; color: var(--gray); margin-bottom: 2rem; }
    .alert { padding: .9rem 1.2rem; font-size: .85rem; margin-bottom: 1.5rem; border-left: 4px solid var(--olive); background: var(--olive-pale); color: var(--olive); }
    .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 1.2rem; margin-bottom: 2rem; }
    .stat-card { background: white; padding: 1.8rem; border-radius: 6px; border: 1px solid rgba(92,107,58,.1); position: relative; }
    .stat-card.has-notif { border-color: rgba(229,57,53,.3); }
    .stat-icon { font-size: 1.5rem; margin-bottom: .8rem; display: block; }
    .stat-num { font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--olive); display: block; line-height: 1; }
    .stat-num.red { color: #e53935; }
    .stat-label { font-size: .72rem; letter-spacing: .1em; text-transform: uppercase; color: var(--gray); margin-top: .3rem; display: block; }
    .stat-badge { position: absolute; top: 1rem; right: 1rem; background: #e53935; color: white; font-size: .65rem; font-weight: 700; padding: .2rem .6rem; border-radius: 10px; }
    .quick-links { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 2rem; }
    .quick-card { background: white; padding: 2rem; border-radius: 6px; border: 1px solid rgba(92,107,58,.1); text-decoration: none; color: var(--dark); transition: transform .2s, box-shadow .2s, border-color .2s; position: relative; }
    .quick-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(92,107,58,.12); border-color: var(--olive); }
    .quick-icon { font-size: 2rem; margin-bottom: 1rem; display: block; }
    .quick-card h3 { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 400; margin-bottom: .3rem; }
    .quick-card p { font-size: .82rem; color: var(--gray); }

    .reminder-card { background: white; border-radius: 8px; padding: 24px; border: 1px solid rgba(92,107,58,.1); }
    .reminder-title { font-family: 'Playfair Display', serif; font-size: 1.4rem; margin-bottom: 18px; color: var(--olive); }
    .reminder-item { display: flex; align-items: flex-start; gap: 15px; padding: 12px 0; border-bottom: 1px solid rgba(0,0,0,.06); }
    .reminder-item:last-child { border-bottom: none; }
    .reminder-icon { width: 40px; height: 40px; border-radius: 50%; background: var(--olive-pale); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .reminder-info { flex: 1; }
    .reminder-name { font-weight: 600; color: var(--dark); }
    .reminder-meta { font-size: .82rem; color: var(--gray); margin-top: 4px; }
    .reminder-badge { background: #E8EDD8; color: var(--olive); padding: 4px 10px; border-radius: 20px; font-size: .72rem; font-weight: 600; }
    .empty-reminder { text-align: center; color: var(--gray); padding: 20px; }
  </style>
</head>
<body>

@if($pendingAppointments > 0)
<div class="notif-popup" id="notifPopup">
  <div class="notif-popup-icon">🔔</div>
  <div class="notif-popup-body">
    <h4>Ada Appointment Baru!</h4>
    <p>Terdapat <strong>{{ $pendingAppointments }} appointment</strong> yang menunggu konfirmasimu.</p>
    <a href="{{ route('admin.appointments') }}">Lihat sekarang →</a>
  </div>
  <button class="notif-popup-close" onclick="tutupPopup()">×</button>
</div>
@endif

<div class="sidebar">
  <a class="sidebar-logo" href="/"><div class="logo-badge">OU</div> Beauty Bar</a>
  <ul class="sidebar-menu">
    <li><a href="{{ route('admin.index') }}" class="active">📊 Dashboard</a></li>
    <li>
      <a href="{{ route('admin.appointments') }}">
        📅 Appointments
        @if($pendingAppointments > 0)
          <span class="notif-badge">{{ $pendingAppointments }}</span>
        @endif
      </a>
    </li>
    <li><a href="{{ route('admin.designs') }}">💅 Desain</a></li>
    <li><a href="{{ route('admin.customers') }}">👥 Customer</a></li>
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
    <div class="stat-card">
      <span class="stat-icon">📅</span>
      <span class="stat-num">{{ $totalAppointments }}</span>
      <span class="stat-label">Total Appointment</span>
    </div>
    <div class="stat-card {{ $pendingAppointments > 0 ? 'has-notif' : '' }}">
      @if($pendingAppointments > 0)<span class="stat-badge">Baru!</span>@endif
      <span class="stat-icon">⏳</span>
      <span class="stat-num {{ $pendingAppointments > 0 ? 'red' : '' }}">{{ $pendingAppointments }}</span>
      <span class="stat-label">Menunggu Konfirmasi</span>
    </div>
    <div class="stat-card">
      <span class="stat-icon">👥</span>
      <span class="stat-num">{{ $totalCustomers }}</span>
      <span class="stat-label">Total Customer</span>
    </div>
    <div class="stat-card">
      <span class="stat-icon">💅</span>
      <span class="stat-num">{{ $totalDesigns }}</span>
      <span class="stat-label">Total Desain</span>
    </div>
  </div>

  <div class="quick-links">
    <a href="{{ route('admin.appointments') }}" class="quick-card">
      <span class="quick-icon">📅</span>
      <h3>Kelola Appointment</h3>
      <p>Lihat, konfirmasi, dan kelola semua pesanan masuk</p>
    </a>
    <a href="{{ route('admin.customers') }}" class="quick-card">
      <span class="quick-icon">👥</span>
      <h3>Data Customer</h3>
      <p>Lihat daftar customer dan hubungi via WhatsApp</p>
    </a>
  </div>

  <div class="reminder-card">
    <h3 class="reminder-title">⏰ Reminder Appointment Terdekat</h3>
    @forelse($upcomingAppointments as $item)
      <div class="reminder-item">
        <div class="reminder-icon">{{ $item->tipe_order === 'press_on' ? '📦' : '💅' }}</div>
        <div class="reminder-info">
          <div class="reminder-name">{{ $item->user->name }}</div>
          <div class="reminder-meta">
            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
            @if($item->jam) • {{ $item->jam }} @endif
            <br>
            {{ $item->tipe_order === 'press_on' ? 'Press On Nail' : 'Nail Art Appointment' }}
          </div>
        </div>
        <span class="reminder-badge">{{ $item->status }}</span>
      </div>
    @empty
      <div class="empty-reminder">🎉 Tidak ada appointment yang perlu diperhatikan.</div>
    @endforelse
  </div>
</div>

<script>
  setTimeout(() => {
    const popup = document.getElementById('notifPopup');
    if (popup) { popup.classList.add('hide'); setTimeout(() => popup.remove(), 300); }
  }, 6000);
  function tutupPopup() {
    const popup = document.getElementById('notifPopup');
    if (popup) { popup.classList.add('hide'); setTimeout(() => popup.remove(), 300); }
  }
</script>
</body>
</html>