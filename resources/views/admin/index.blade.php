<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard — OU Beauty Bar Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --olive:        #5C6B3A;
      --olive-light:  #7A8C4E;
      --olive-pale:   #E8EDD8;
      --olive-faint:  #f0f3e8;
      --lilac:        #C4B5D4;
      --lilac-deep:   #9B87B0;
      --lilac-pale:   #F0EBF7;
      --cream:        #FAF8F5;
      --bg:           #F2F4EE;
      --dark:         #2C2C2C;
      --gray:         #6B6B6B;
      --sidebar-w:    260px;
      --radius-card:  20px;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideIn {
      from { opacity: 0; transform: translateX(-12px); }
      to   { opacity: 1; transform: translateX(0); }
    }

    body {
      font-family: 'Jost', sans-serif;
      background: var(--bg);
      color: var(--dark);
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ════════════════════════════
       SIDEBAR
    ════════════════════════════ */
    .sidebar {
      width: var(--sidebar-w);
      background: linear-gradient(168deg, #2e3920 0%, #3d4a26 30%, #5C6B3A 70%, #4e5f32 100%);
      color: #fff;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      z-index: 100;
      box-shadow: 6px 0 40px rgba(46,57,32,.35);
    }

    .sidebar::after {
      content: '';
      position: absolute;
      inset: 0;
      background:
        radial-gradient(ellipse 80% 60% at 50% 0%, rgba(196,181,212,.12) 0%, transparent 60%),
        url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.025'%3E%3Ccircle cx='40' cy='40' r='28'/%3E%3C/g%3E%3C/svg%3E");
      pointer-events: none;
    }

    .sidebar-header {
      padding: 2.2rem 1.8rem 1.6rem;
      border-bottom: 1px solid rgba(255,255,255,.08);
      position: relative;
      z-index: 1;
    }

    .sidebar-logo {
      font-family: 'Playfair Display', serif;
      font-size: 1.2rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: .9rem;
      text-decoration: none;
      color: #fff;
      letter-spacing: .01em;
    }

    .logo-badge {
      width: 42px; height: 42px;
      background: linear-gradient(135deg, var(--lilac) 0%, var(--lilac-deep) 100%);
      border-radius: 13px;
      display: flex; align-items: center; justify-content: center;
      color: #fff;
      font-size: .72rem;
      font-weight: 700;
      letter-spacing: .06em;
      box-shadow: 0 6px 18px rgba(155,135,176,.5);
      flex-shrink: 0;
    }

    .sidebar-tagline {
      font-size: .63rem;
      color: rgba(255,255,255,.35);
      letter-spacing: .22em;
      text-transform: uppercase;
      margin-top: .25rem;
      padding-left: 3.3rem;
    }

    .sidebar-nav {
      flex: 1;
      padding: 1.8rem 1rem;
      overflow-y: auto;
      position: relative;
      z-index: 1;
    }

    .nav-section-label {
      font-size: .58rem;
      letter-spacing: .22em;
      text-transform: uppercase;
      color: rgba(255,255,255,.28);
      padding: 0 .9rem;
      margin-bottom: .7rem;
      margin-top: 1.4rem;
    }
    .nav-section-label:first-child { margin-top: 0; }

    .sidebar-menu {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: .18rem;
    }

    .sidebar-menu a {
      display: flex;
      align-items: center;
      gap: .8rem;
      padding: .78rem 1rem;
      font-size: .83rem;
      font-weight: 400;
      text-decoration: none;
      color: rgba(255,255,255,.55);
      border-radius: 11px;
      transition: all .28s ease;
      position: relative;
      letter-spacing: .01em;
    }

    .sidebar-menu a .nav-icon {
      font-size: .95rem;
      width: 22px;
      text-align: center;
      flex-shrink: 0;
      opacity: .7;
      transition: opacity .25s;
    }

    .sidebar-menu a:hover {
      background: rgba(255,255,255,.09);
      color: rgba(255,255,255,.92);
      transform: translateX(4px);
    }
    .sidebar-menu a:hover .nav-icon { opacity: 1; }

    .sidebar-menu a.active {
      background: rgba(255,255,255,.13);
      color: #fff;
      font-weight: 500;
    }

    .sidebar-menu a.active::before {
      content: '';
      position: absolute;
      left: 0; top: 22%; bottom: 22%;
      width: 3px;
      background: linear-gradient(to bottom, var(--lilac), var(--lilac-deep));
      border-radius: 0 3px 3px 0;
    }

    .sidebar-bottom {
      padding: 1.2rem 1rem;
      border-top: 1px solid rgba(255,255,255,.08);
      position: relative;
      z-index: 1;
    }

    .logout-btn {
      display: flex;
      align-items: center;
      gap: .75rem;
      background: none;
      border: none;
      color: rgba(255,255,255,.4);
      font-size: .8rem;
      cursor: pointer;
      font-family: 'Jost', sans-serif;
      padding: .72rem 1rem;
      width: 100%;
      border-radius: 11px;
      transition: all .25s;
    }
    .logout-btn:hover {
      background: rgba(255,255,255,.07);
      color: rgba(255,255,255,.7);
    }

    /* ════════════════════════════
       MAIN LAYOUT
    ════════════════════════════ */
    .main {
      flex: 1;
      margin-left: var(--sidebar-w);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .topbar {
      background: rgba(250,248,245,.9);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid rgba(92,107,58,.09);
      padding: 1.1rem 2.8rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 50;
    }

    .topbar-left { display: flex; flex-direction: column; gap: .1rem; }

    .topbar-greeting {
      font-size: .82rem;
      color: var(--gray);
      font-weight: 300;
    }
    .topbar-greeting strong {
      color: var(--dark);
      font-weight: 500;
    }

    .topbar-date {
      font-size: .74rem;
      color: rgba(107,107,107,.6);
      letter-spacing: .03em;
    }

    .topbar-right {
      display: flex;
      align-items: center;
      gap: .6rem;
    }

    .topbar-avatar {
      width: 34px; height: 34px;
      background: linear-gradient(135deg, var(--olive-pale), var(--lilac-pale));
      border-radius: 50%;
      border: 2px solid rgba(92,107,58,.15);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .8rem;
      color: var(--olive);
      font-weight: 600;
    }

    .content {
      flex: 1;
      padding: 2.8rem;
    }

    /* ════════════════════════════
       PAGE HEADER
    ════════════════════════════ */
    .page-header {
      margin-bottom: 2.8rem;
      animation: fadeUp .5s ease both;
    }

    .page-eyebrow {
      font-size: .62rem;
      letter-spacing: .22em;
      text-transform: uppercase;
      color: var(--lilac-deep);
      margin-bottom: .5rem;
      display: flex;
      align-items: center;
      gap: .5rem;
    }

    .page-eyebrow::before {
      content: '';
      width: 18px; height: 1px;
      background: var(--lilac-deep);
    }

    .page-title {
      font-family: 'Playfair Display', serif;
      font-size: 2.4rem;
      font-weight: 400;
      line-height: 1.15;
      margin-bottom: .4rem;
      color: var(--dark);
    }
    .page-title em { font-style: italic; color: var(--olive); }

    .page-sub {
      font-size: .84rem;
      color: var(--gray);
      font-weight: 300;
      letter-spacing: .01em;
    }

    /* ════════════════════════════
       ALERT
    ════════════════════════════ */
    .alert {
      display: flex;
      align-items: center;
      gap: .8rem;
      padding: 1rem 1.5rem;
      font-size: .84rem;
      margin-bottom: 2.2rem;
      border-radius: 14px;
      background: linear-gradient(135deg, var(--olive-pale) 0%, #eef1e2 100%);
      border: 1px solid rgba(92,107,58,.2);
      color: var(--olive);
      animation: fadeUp .4s ease both;
    }

    .alert-dot {
      width: 6px; height: 6px;
      border-radius: 50%;
      background: var(--olive);
      flex-shrink: 0;
    }

    /* ════════════════════════════
       STATS GRID
    ════════════════════════════ */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.4rem;
      margin-bottom: 2.8rem;
    }

    .stat-card {
      background: #fff;
      padding: 2rem 1.8rem 1.8rem;
      border-radius: var(--radius-card);
      border: 1px solid rgba(92,107,58,.07);
      position: relative;
      overflow: hidden;
      cursor: default;
      transition: transform .32s ease, box-shadow .32s ease;
      animation: fadeUp .55s ease both;
    }

    .stat-card:nth-child(1) { animation-delay: .06s; }
    .stat-card:nth-child(2) { animation-delay: .12s; }
    .stat-card:nth-child(3) { animation-delay: .18s; }
    .stat-card:nth-child(4) { animation-delay: .24s; }

    .stat-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 18px 52px rgba(92,107,58,.13);
    }

    /* Subtle background texture per card */
    .stat-card::before {
      content: '';
      position: absolute;
      bottom: -40px; right: -40px;
      width: 130px; height: 130px;
      border-radius: 50%;
      transition: transform .4s ease;
    }
    .stat-card:hover::before { transform: scale(1.2); }

    .stat-card.olive-card::before   { background: radial-gradient(circle, var(--olive-faint) 0%, transparent 70%); }
    .stat-card.lilac-card::before   { background: radial-gradient(circle, var(--lilac-pale) 0%, transparent 70%); }

    .stat-top {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      margin-bottom: 1.4rem;
    }

    .stat-icon-wrap {
      width: 44px; height: 44px;
      border-radius: 13px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.05rem;
      flex-shrink: 0;
    }
    .olive-card .stat-icon-wrap { background: var(--olive-faint); }
    .lilac-card .stat-icon-wrap { background: var(--lilac-pale); }

    .stat-trend {
      font-size: .65rem;
      letter-spacing: .06em;
      padding: .22rem .6rem;
      border-radius: 20px;
      font-weight: 500;
    }
    .olive-card .stat-trend {
      background: var(--olive-pale);
      color: var(--olive);
    }
    .lilac-card .stat-trend {
      background: var(--lilac-pale);
      color: var(--lilac-deep);
    }

    .stat-num {
      font-family: 'Playfair Display', serif;
      font-size: 3rem;
      line-height: 1;
      font-weight: 400;
      display: block;
      margin-bottom: .3rem;
    }
    .olive-card .stat-num { color: var(--olive); }
    .lilac-card .stat-num { color: var(--lilac-deep); }

    .stat-label {
      font-size: .66rem;
      letter-spacing: .15em;
      text-transform: uppercase;
      color: var(--gray);
      font-weight: 500;
    }

    /* ════════════════════════════
       SECTION DIVIDER
    ════════════════════════════ */
    .section-label {
      font-family: 'Playfair Display', serif;
      font-size: 1.05rem;
      font-weight: 400;
      font-style: italic;
      color: var(--olive);
      margin-bottom: 1.3rem;
      display: flex;
      align-items: center;
      gap: .8rem;
    }

    .section-label::after {
      content: '';
      flex: 1;
      height: 1px;
      background: linear-gradient(to right, rgba(92,107,58,.18), transparent);
    }

    /* ════════════════════════════
       QUICK LINKS
    ════════════════════════════ */
    .quick-links {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.4rem;
    }

    .quick-card {
      background: #fff;
      padding: 2.4rem 2.2rem;
      border-radius: var(--radius-card);
      border: 1px solid rgba(92,107,58,.07);
      text-decoration: none;
      color: var(--dark);
      transition: transform .32s ease, box-shadow .32s ease, border-color .3s ease;
      display: flex;
      flex-direction: column;
      gap: .5rem;
      position: relative;
      overflow: hidden;
      animation: fadeUp .6s ease both;
    }

    .quick-card:nth-child(1) { animation-delay: .32s; }
    .quick-card:nth-child(2) { animation-delay: .4s; }

    /* Decorative radial accent */
    .quick-card::before {
      content: '';
      position: absolute;
      bottom: -50px; right: -50px;
      width: 160px; height: 160px;
      border-radius: 50%;
      background: radial-gradient(circle, var(--olive-faint) 0%, transparent 70%);
      transition: transform .45s ease;
    }
    .quick-card:nth-child(2)::before {
      background: radial-gradient(circle, var(--lilac-pale) 0%, transparent 70%);
    }
    .quick-card:hover::before { transform: scale(1.5); }

    .quick-card:hover {
      transform: translateY(-7px);
      box-shadow: 0 22px 60px rgba(92,107,58,.13);
      border-color: rgba(92,107,58,.2);
    }

    .quick-card-top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: .6rem;
    }

    .quick-icon-wrap {
      width: 52px; height: 52px;
      border-radius: 15px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.4rem;
    }
    .quick-card:nth-child(1) .quick-icon-wrap { background: var(--olive-faint); }
    .quick-card:nth-child(2) .quick-icon-wrap { background: var(--lilac-pale); }

    .quick-arrow-wrap {
      width: 32px; height: 32px;
      border-radius: 50%;
      border: 1.5px solid rgba(92,107,58,.18);
      display: flex; align-items: center; justify-content: center;
      font-size: .75rem;
      color: var(--olive);
      transition: background .25s, transform .25s;
    }
    .quick-card:hover .quick-arrow-wrap {
      background: var(--olive);
      color: #fff;
      border-color: var(--olive);
      transform: rotate(45deg);
    }

    .quick-card h3 {
      font-family: 'Playfair Display', serif;
      font-size: 1.3rem;
      font-weight: 400;
      margin-bottom: .2rem;
    }

    .quick-card p {
      font-size: .82rem;
      color: var(--gray);
      font-weight: 300;
      line-height: 1.6;
    }

    .quick-badge {
      display: inline-block;
      font-size: .62rem;
      letter-spacing: .1em;
      text-transform: uppercase;
      padding: .22rem .7rem;
      border-radius: 20px;
      margin-top: .4rem;
      font-weight: 500;
    }
    .quick-card:nth-child(1) .quick-badge { background: var(--olive-pale); color: var(--olive); }
    .quick-card:nth-child(2) .quick-badge { background: var(--lilac-pale); color: var(--lilac-deep); }

    /* ════════════════════════════
       RESPONSIVE
    ════════════════════════════ */
    @media (max-width: 1200px) {
      .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
      :root { --sidebar-w: 0px; }
      .sidebar { display: none; }
      .main { margin-left: 0; }
      .content { padding: 1.5rem; }
      .topbar { padding: 1rem 1.5rem; }
      .stats-grid { grid-template-columns: 1fr 1fr; gap: 1rem; }
      .quick-links { grid-template-columns: 1fr; }
      .page-title { font-size: 1.8rem; }
    }

    @media (max-width: 480px) {
      .stats-grid { grid-template-columns: 1fr; }
      .content { padding: 1.2rem; }
      .stat-num { font-size: 2.4rem; }
    }
  </style>
</head>
<body>

<!-- ══════════════════════════════
     SIDEBAR
══════════════════════════════ -->
<div class="sidebar">
  <div class="sidebar-header">
    <a class="sidebar-logo" href="/">
      <div class="logo-badge">OU</div>
      Beauty Bar
    </a>
    <div class="sidebar-tagline">Admin Panel</div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section-label">Menu Utama</div>
    <ul class="sidebar-menu">
      <li>
        <a href="{{ route('admin.index') }}" class="active">
          <span class="nav-icon">✦</span> Dashboard
        </a>
      </li>
      <li>
        <a href="{{ route('admin.appointments') }}">
          <span class="nav-icon">◈</span> Appointments
        </a>
      </li>
      <li>
        <a href="{{ route('admin.designs') }}">
          <span class="nav-icon">◇</span> Desain
        </a>
      </li>
    </ul>
  </nav>

  <div class="sidebar-bottom">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button class="logout-btn" type="submit">
        <span>↩</span> Keluar
      </button>
    </form>
  </div>
</div>

<!-- ══════════════════════════════
     MAIN
══════════════════════════════ -->
<div class="main">
  <div class="topbar">
    <div class="topbar-left">
      <div class="topbar-greeting">
        Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>
      </div>
      <div class="topbar-date" id="topbar-date"></div>
    </div>
    <div class="topbar-right">
      <div class="topbar-avatar">
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
      </div>
    </div>
  </div>

  <div class="content">
    <div class="page-header">
      <p class="page-eyebrow">Admin Panel</p>
      <h1 class="page-title">Dashboard <em>Overview</em></h1>
      <p class="page-sub">Ringkasan aktivitas & statistik OU Beauty Bar hari ini</p>
    </div>

    @if(session('success'))
    <div class="alert">
      <div class="alert-dot"></div>
      {{ session('success') }}
    </div>
    @endif

    <!-- STATS -->
    <div class="stats-grid">
      <div class="stat-card olive-card">
        <div class="stat-top">
          <div class="stat-icon-wrap">◈</div>
          <span class="stat-trend">Total</span>
        </div>
        <span class="stat-num">{{ $totalAppointments }}</span>
        <span class="stat-label">Total Appointment</span>
      </div>

      <div class="stat-card lilac-card">
        <div class="stat-top">
          <div class="stat-icon-wrap">⧗</div>
          <span class="stat-trend">Pending</span>
        </div>
        <span class="stat-num">{{ $pendingAppointments }}</span>
        <span class="stat-label">Menunggu Konfirmasi</span>
      </div>

      <div class="stat-card olive-card">
        <div class="stat-top">
          <div class="stat-icon-wrap">◉</div>
          <span class="stat-trend">Member</span>
        </div>
        <span class="stat-num">{{ $totalCustomers }}</span>
        <span class="stat-label">Total Customer</span>
      </div>

      <div class="stat-card lilac-card">
        <div class="stat-top">
          <div class="stat-icon-wrap">◇</div>
          <span class="stat-trend">Katalog</span>
        </div>
        <span class="stat-num">{{ $totalDesigns }}</span>
        <span class="stat-label">Total Desain</span>
      </div>
    </div>

    <!-- QUICK ACCESS -->
    <div class="section-label">Akses Cepat</div>

    <div class="quick-links">
      <a href="{{ route('admin.appointments') }}" class="quick-card">
        <div class="quick-card-top">
          <div class="quick-icon-wrap">◈</div>
          <div class="quick-arrow-wrap">↗</div>
        </div>
        <h3>Kelola Appointment</h3>
        <p>Lihat, konfirmasi, dan kelola seluruh appointment customer dengan mudah dari satu halaman.</p>
        <span class="quick-badge">Lihat Semua →</span>
      </a>

      <a href="{{ route('admin.designs') }}" class="quick-card">
        <div class="quick-card-top">
          <div class="quick-icon-wrap">◇</div>
          <div class="quick-arrow-wrap">↗</div>
        </div>
        <h3>Kelola Desain</h3>
        <p>Tambah dan kelola katalog desain nail art untuk ditampilkan kepada seluruh customer.</p>
        <span class="quick-badge">Lihat Semua →</span>
      </a>
    </div>
  </div>
</div>

<script>
  const d = new Date();
  const opts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  document.getElementById('topbar-date').textContent = d.toLocaleDateString('id-ID', opts);
</script>
</body>
</html>