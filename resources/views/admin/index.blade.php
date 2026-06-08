<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin — OU Beauty Bar</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --olive:#5C6B3A; --olive-light:#7A8C4E; --olive-pale:#E8EDD8;
      --lilac:#C4B5D4; --lilac-deep:#9B87B0; --lilac-pale:#F0EBF7;
      --cream:#FAF8F5; --dark:#2C2C2C; --gray:#6B6B6B;
      --bg:#F2F4EE; --card:#ffffff;
      --card-border:rgba(92,107,58,.1);
    }

    /* ══ DARK MODE ══ */
    body.dark {
      --bg:#151710; --card:#1E2118; --dark:#EEE8F0; --gray:#8A8A8A;
      --cream:#1E2118; --olive-pale:#2A3020; --lilac-pale:#1E1A24;
      --card-border:rgba(255,255,255,.07);
    }
    body.dark .sidebar { background: #0E100C; }
    body.dark .main { background: var(--bg); }
    body.dark .top-bar { background: rgba(30,33,24,.97); border-color: rgba(255,255,255,.06); }
    body.dark .stat-card,
    body.dark .quick-card,
    body.dark .reminder-card,
    body.dark .welcome-card { background: var(--card); border-color: var(--card-border); }
    body.dark .clock-badge { background: rgba(255,255,255,.07); color: var(--dark); }
    body.dark input { background: #2A3020; color: var(--dark); border-color: rgba(92,107,58,.25); }

    html { scroll-behavior: smooth; }
    body { font-family: 'Jost', sans-serif; background: var(--bg); color: var(--dark); display: flex; min-height: 100vh; transition: background .3s, color .3s; }

    /* ══════════════════════════════════════
       LOADING SCREEN
    ══════════════════════════════════════ */
    #loadingScreen {
      position: fixed; inset: 0; z-index: 9999;
      background: var(--olive);
      display: flex; flex-direction: column; align-items: center; justify-content: center;
      gap: 1rem;
      transition: opacity .6s ease, visibility .6s ease;
    }
    #loadingScreen.hidden { opacity: 0; visibility: hidden; }
    .ls-logo { font-family: 'Playfair Display', serif; font-size: 2.2rem; color: white; font-weight: 400; letter-spacing: .06em; }
    .ls-sub { font-size: .72rem; letter-spacing: .28em; text-transform: uppercase; color: rgba(255,255,255,.6); }
    .ls-bar-wrap { width: 140px; height: 2px; background: rgba(255,255,255,.2); border-radius: 99px; margin-top: .5rem; }
    .ls-bar { height: 100%; width: 0; background: var(--lilac); border-radius: 99px; animation: lsFill 1.3s ease forwards; }
    @keyframes lsFill { to { width: 100%; } }
    .ls-icon { font-size: 2.2rem; animation: lsBounce .55s ease-in-out infinite alternate; }
    @keyframes lsBounce { from { transform: translateY(0) rotate(-6deg); } to { transform: translateY(-8px) rotate(6deg); } }

    /* ══════════════════════════════════════
       SCROLL PROGRESS
    ══════════════════════════════════════ */
    #scrollProg {
      position: fixed; top: 0; left: 240px; right: 0; z-index: 9998;
      height: 3px; width: 0%;
      background: linear-gradient(90deg, var(--olive), var(--lilac-deep));
      transition: width .08s linear;
    }

    /* ══ SIDEBAR ══ */
    .sidebar {
      width: 240px; background: var(--olive); color: white;
      padding: 2rem 1.5rem; flex-shrink: 0;
      display: flex; flex-direction: column;
      position: sticky; top: 0; height: 100vh;
      transition: background .3s;
    }
    .sidebar-logo { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 600; margin-bottom: 2.5rem; display: flex; align-items: center; gap: .6rem; text-decoration: none; color: white; }
    .logo-badge { width: 34px; height: 34px; background: var(--lilac); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--olive); font-size: .72rem; font-weight: 700; }
    .sidebar-menu { list-style: none; display: flex; flex-direction: column; gap: .3rem; }
    .sidebar-menu a { display: block; padding: .75rem 1rem; font-size: .82rem; text-decoration: none; color: rgba(255,255,255,.65); border-radius: 4px; transition: all .2s; position: relative; }
    .sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(255,255,255,.15); color: white; }
    .sidebar-bottom { margin-top: auto; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,.15); }
    .logout-btn { background: none; border: none; color: rgba(255,255,255,.55); font-size: .82rem; cursor: pointer; font-family: inherit; padding: .75rem 1rem; width: 100%; text-align: left; border-radius: 4px; transition: all .2s; }
    .logout-btn:hover { background: rgba(255,255,255,.1); color: white; }

    .notif-badge { display: inline-flex; align-items: center; justify-content: center; background: #e53935; color: white; font-size: .62rem; font-weight: 700; min-width: 18px; height: 18px; border-radius: 9px; padding: 0 5px; position: absolute; right: .8rem; top: 50%; transform: translateY(-50%); animation: pulse 2s infinite; }
    @keyframes pulse { 0%,100%{box-shadow:0 0 0 0 rgba(229,57,53,.4)} 50%{box-shadow:0 0 0 6px rgba(229,57,53,0)} }

    /* Notification popup */
    .notif-popup { position: fixed; top: 1.5rem; right: 1.5rem; z-index: 999; background: white; border-radius: 10px; box-shadow: 0 8px 32px rgba(0,0,0,.15); padding: 1.2rem 1.5rem; max-width: 320px; width: 100%; border-left: 4px solid #e53935; animation: slideIn .4s ease; display: flex; gap: 1rem; align-items: flex-start; }
    .notif-popup.hide { animation: slideOut .3s ease forwards; }
    @keyframes slideIn { from{opacity:0;transform:translateX(100%)} to{opacity:1;transform:translateX(0)} }
    @keyframes slideOut { from{opacity:1;transform:translateX(0)} to{opacity:0;transform:translateX(100%)} }
    .notif-popup-icon { font-size: 1.8rem; flex-shrink: 0; }
    .notif-popup-body h4 { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 600; margin-bottom: .2rem; }
    .notif-popup-body p { font-size: .8rem; color: var(--gray); line-height: 1.5; }
    .notif-popup-body a { font-size: .78rem; color: var(--olive); text-decoration: none; font-weight: 500; margin-top: .5rem; display: inline-block; }
    .notif-popup-close { position: absolute; top: .6rem; right: .8rem; background: none; border: none; cursor: pointer; font-size: 1rem; color: var(--gray); }

    /* ══ MAIN ══ */
    .main { flex: 1; overflow-y: auto; display: flex; flex-direction: column; min-height: 100vh; }

    /* ══ TOP BAR ══ */
    .top-bar {
      position: sticky; top: 0; z-index: 50;
      background: rgba(242,244,238,.97); backdrop-filter: blur(14px);
      border-bottom: 1px solid var(--card-border);
      padding: .9rem 2.5rem;
      display: flex; align-items: center; justify-content: space-between;
      transition: background .3s;
    }
    .top-bar-left { display: flex; align-items: center; gap: 1rem; }
    .top-bar-right { display: flex; align-items: center; gap: 1rem; }
    .clock-badge { display: inline-flex; align-items: center; gap: .5rem; background: rgba(92,107,58,.1); border: 1px solid rgba(92,107,58,.15); border-radius: 4px; padding: .35rem .9rem; font-size: .82rem; color: var(--dark); font-variant-numeric: tabular-nums; }
    .clock-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--olive); animation: blink 1s step-end infinite; }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.2} }
    .dark-toggle { background: none; border: 1.5px solid rgba(92,107,58,.3); color: var(--olive); width: 34px; height: 34px; border-radius: 50%; cursor: pointer; font-size: .9rem; display: flex; align-items: center; justify-content: center; transition: all .2s; }
    .dark-toggle:hover { background: var(--olive); color: white; border-color: var(--olive); }
    /* Floating notif bell */
    .bell-btn { background: none; border: 1.5px solid rgba(92,107,58,.3); color: var(--olive); width: 34px; height: 34px; border-radius: 50%; cursor: pointer; font-size: .9rem; display: flex; align-items: center; justify-content: center; transition: all .2s; position: relative; }
    .bell-btn:hover { background: var(--olive); color: white; }
    .bell-dot { position: absolute; top: -3px; right: -3px; width: 10px; height: 10px; background: #e53935; border-radius: 50%; border: 2px solid var(--bg); animation: pulse 2s infinite; }

    .content { padding: 2rem 2.5rem; flex: 1; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 400; margin-bottom: .3rem; }
    .page-title em { font-style: italic; color: var(--olive); }
    .page-sub { font-size: .85rem; color: var(--gray); margin-bottom: 1.5rem; }
    .alert { padding: .9rem 1.2rem; font-size: .85rem; margin-bottom: 1.5rem; border-left: 4px solid var(--olive); background: var(--olive-pale); color: var(--olive); border-radius: 3px; }

    /* ══════════════════════════════════════
       WELCOME CARD
    ══════════════════════════════════════ */
    .welcome-card {
      background: linear-gradient(135deg, var(--olive), var(--olive-light));
      border-radius: 8px; padding: 1.8rem 2rem;
      color: white; margin-bottom: 1.5rem;
      display: flex; align-items: center; justify-content: space-between;
      flex-wrap: wrap; gap: 1rem;
      position: relative; overflow: hidden;
    }
    .welcome-card::before {
      content: '💅';
      position: absolute; right: 1.5rem; bottom: -1rem;
      font-size: 5rem; opacity: .12; transform: rotate(-12deg);
      pointer-events: none;
    }
    .welcome-title { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 400; margin-bottom: .3rem; }
    .welcome-sub { font-size: .85rem; opacity: .75; line-height: 1.6; }
    .welcome-quote { font-family: 'Playfair Display', serif; font-style: italic; font-size: .82rem; opacity: .7; margin-top: .6rem; padding-left: .8rem; border-left: 2px solid rgba(196,181,212,.5); }
    .welcome-date { text-align: right; }
    .welcome-date-day { font-family: 'Playfair Display', serif; font-size: 2.4rem; line-height: 1; color: var(--lilac); }
    .welcome-date-rest { font-size: .75rem; opacity: .65; letter-spacing: .08em; text-transform: uppercase; }

    /* ══ STATS ══ */
    .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 1.2rem; margin-bottom: 1.5rem; }
    .stat-card {
      background: var(--card); padding: 1.8rem; border-radius: 8px;
      border: 1px solid var(--card-border); position: relative;
      transition: transform .25s, box-shadow .25s, border-color .25s;
    }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 12px 32px rgba(92,107,58,.12); border-color: rgba(92,107,58,.25); }
    .stat-card.has-notif { border-color: rgba(229,57,53,.3); }
    .stat-card.has-notif:hover { box-shadow: 0 12px 32px rgba(229,57,53,.12); }
    .stat-icon { font-size: 1.5rem; margin-bottom: .8rem; display: block; }
    .stat-num { font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--olive); display: block; line-height: 1; }
    .stat-num.red { color: #e53935; }
    .stat-label { font-size: .72rem; letter-spacing: .1em; text-transform: uppercase; color: var(--gray); margin-top: .3rem; display: block; }
    .stat-badge { position: absolute; top: 1rem; right: 1rem; background: #e53935; color: white; font-size: .65rem; font-weight: 700; padding: .2rem .6rem; border-radius: 10px; }
    /* Progress ring */
    .stat-ring { position: absolute; bottom: 1rem; right: 1rem; }
    .stat-ring svg { width: 38px; height: 38px; transform: rotate(-90deg); }
    .ring-bg { fill: none; stroke: var(--olive-pale); stroke-width: 3; }
    .ring-fill { fill: none; stroke: var(--olive); stroke-width: 3; stroke-linecap: round; stroke-dasharray: 100; stroke-dashoffset: 100; transition: stroke-dashoffset 1.2s ease; }
    .ring-fill.red { stroke: #e53935; }

    /* ══ QUICK LINKS ══ */
    .quick-links { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.5rem; }
    .quick-card {
      background: var(--card); padding: 2rem; border-radius: 8px;
      border: 1px solid var(--card-border);
      text-decoration: none; color: var(--dark);
      transition: transform .25s, box-shadow .25s, border-color .25s;
      position: relative; overflow: hidden;
    }
    .quick-card::after { content: '→'; position: absolute; right: 1.5rem; bottom: 1.5rem; font-size: 1.2rem; opacity: .2; transition: opacity .2s, transform .2s; }
    .quick-card:hover { transform: translateY(-5px); box-shadow: 0 12px 32px rgba(92,107,58,.12); border-color: var(--olive); }
    .quick-card:hover::after { opacity: .7; transform: translateX(4px); }
    .quick-icon { font-size: 2rem; margin-bottom: 1rem; display: block; }
    .quick-card h3 { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 400; margin-bottom: .3rem; }
    .quick-card p { font-size: .82rem; color: var(--gray); }

    /* ══ SEARCH ══ */
    .search-wrap { margin-bottom: 1.2rem; position: relative; max-width: 340px; }
    .search-wrap input {
      width: 100%; padding: .6rem 1rem .6rem 2.3rem;
      font-family: 'Jost', sans-serif; font-size: .83rem;
      border: 1.5px solid rgba(92,107,58,.2); border-radius: 4px;
      background: var(--card); color: var(--dark);
      outline: none; transition: border-color .2s, box-shadow .2s;
    }
    .search-wrap input:focus { border-color: var(--olive); box-shadow: 0 0 0 3px rgba(92,107,58,.1); }
    .search-icon { position: absolute; left: .75rem; top: 50%; transform: translateY(-50%); font-size: .85rem; pointer-events: none; }

    /* ══ REMINDER ══ */
    .reminder-card { background: var(--card); border-radius: 8px; padding: 1.8rem; border: 1px solid var(--card-border); }
    .reminder-title { font-family: 'Playfair Display', serif; font-size: 1.3rem; margin-bottom: 1.2rem; color: var(--olive); }
    .reminder-item { display: flex; align-items: flex-start; gap: 1rem; padding: .9rem 0; border-bottom: 1px solid rgba(0,0,0,.05); transition: background .2s; border-radius: 4px; }
    body.dark .reminder-item { border-bottom-color: rgba(255,255,255,.06); }
    .reminder-item:last-child { border-bottom: none; }
    .reminder-item:hover { background: var(--olive-pale); padding-left: .5rem; }
    body.dark .reminder-item:hover { background: rgba(255,255,255,.04); }
    .reminder-icon { width: 40px; height: 40px; border-radius: 50%; background: var(--olive-pale); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .reminder-info { flex: 1; }
    .reminder-name { font-weight: 500; color: var(--dark); }
    .reminder-meta { font-size: .8rem; color: var(--gray); margin-top: 3px; }
    .reminder-badge { background: var(--olive-pale); color: var(--olive); padding: .25rem .7rem; border-radius: 20px; font-size: .7rem; font-weight: 600; white-space: nowrap; }
    .empty-reminder { text-align: center; color: var(--gray); padding: 1.5rem; font-size: .88rem; }

    /* ══ MOTIVATIONAL QUOTE BOTTOM ══ */
    .quote-footer {
      padding: 1.2rem 2.5rem; border-top: 1px solid var(--card-border);
      display: flex; align-items: center; justify-content: space-between;
      font-size: .78rem; color: var(--gray);
      flex-wrap: wrap; gap: .5rem;
    }
    .quote-footer em { font-family: 'Playfair Display', serif; font-style: italic; color: var(--olive); }

    /* ══ ANIMATIONS ══ */
    .fade-up { opacity: 0; transform: translateY(18px); transition: opacity .5s ease, transform .5s ease; }
    .fade-up.show { opacity: 1; transform: translateY(0); }

    /* ══ RESPONSIVE ══ */
    @media(max-width:900px) {
      .stats-grid { grid-template-columns: 1fr 1fr; }
      .quick-links { grid-template-columns: 1fr; }
    }
    @media(max-width:640px) {
      .sidebar { display: none; }
      #scrollProg { left: 0; }
      .stats-grid { grid-template-columns: 1fr 1fr; }
      .content { padding: 1.5rem; }
    }
  </style>
</head>
<body>

{{-- LOADING SCREEN --}}
<div id="loadingScreen">
  <div class="ls-icon">💅</div>
  <div class="ls-logo">OU Beauty Bar</div>
  <div class="ls-sub">Admin Dashboard</div>
  <div class="ls-bar-wrap"><div class="ls-bar"></div></div>
</div>

{{-- SCROLL PROGRESS --}}
<div id="scrollProg"></div>

{{-- NOTIF POPUP --}}
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

{{-- SIDEBAR --}}
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

{{-- MAIN --}}
<div class="main" id="mainScroll">

  {{-- TOP BAR --}}
  <div class="top-bar">
    <div class="top-bar-left">
      <span style="font-size:.82rem;color:var(--gray);">Admin Panel</span>
    </div>
    <div class="top-bar-right">
      {{-- Live Clock --}}
      <div class="clock-badge">
        <span class="clock-dot"></span>
        <span id="liveClock">--:--:--</span>
      </div>
      {{-- Bell --}}
      @if($pendingAppointments > 0)
      <button class="bell-btn" title="Ada {{ $pendingAppointments }} appointment pending" onclick="document.getElementById('notifPopup')?.classList.remove('hide')">
        🔔
        <span class="bell-dot"></span>
      </button>
      @endif
      {{-- Dark mode --}}
      <button class="dark-toggle" id="darkBtn" onclick="toggleDark()" title="Ganti tema">🌙</button>
    </div>
  </div>

  <div class="content">

    {{-- PAGE TITLE --}}
    <h1 class="page-title">Dashboard <em>Admin</em></h1>
    <p class="page-sub">Selamat datang, {{ auth()->user()->name }}!</p>

    @if(session('success'))
      <div class="alert">✅ {{ session('success') }}</div>
    @endif

    {{-- WELCOME CARD --}}
    <div class="welcome-card fade-up">
      <div>
        <div class="welcome-title">Halo, {{ auth()->user()->name }} 👋</div>
        <div class="welcome-sub">Semoga harimu menyenangkan dan semua appointment berjalan lancar.<br>Pantau dashboard untuk update terbaru.</div>
        <div class="welcome-quote" id="adminQuote"></div>
      </div>
      <div class="welcome-date">
        <div class="welcome-date-day" id="welcomeDay">--</div>
        <div class="welcome-date-rest" id="welcomeDate">---</div>
      </div>
    </div>

    {{-- STATS --}}
    <div class="stats-grid">
      <div class="stat-card fade-up">
        <span class="stat-icon">📅</span>
        <span class="stat-num" data-target="{{ $totalAppointments }}">0</span>
        <span class="stat-label">Total Appointment</span>
        <div class="stat-ring">
          <svg viewBox="0 0 36 36">
            <circle class="ring-bg" cx="18" cy="18" r="15.9"/>
            <circle class="ring-fill" cx="18" cy="18" r="15.9"
              data-pct="{{ min(100, ($totalAppointments / max(1, $totalAppointments)) * 100) }}"/>
          </svg>
        </div>
      </div>
      <div class="stat-card fade-up {{ $pendingAppointments > 0 ? 'has-notif' : '' }}">
        @if($pendingAppointments > 0)<span class="stat-badge">Baru!</span>@endif
        <span class="stat-icon">⏳</span>
        <span class="stat-num {{ $pendingAppointments > 0 ? 'red' : '' }}" data-target="{{ $pendingAppointments }}">0</span>
        <span class="stat-label">Menunggu Konfirmasi</span>
        <div class="stat-ring">
          <svg viewBox="0 0 36 36">
            <circle class="ring-bg" cx="18" cy="18" r="15.9"/>
            <circle class="ring-fill {{ $pendingAppointments > 0 ? 'red' : '' }}" cx="18" cy="18" r="15.9"
              data-pct="{{ min(100, ($pendingAppointments / max(1, $totalAppointments)) * 100) }}"/>
          </svg>
        </div>
      </div>
      <div class="stat-card fade-up">
        <span class="stat-icon">👥</span>
        <span class="stat-num" data-target="{{ $totalCustomers }}">0</span>
        <span class="stat-label">Total Customer</span>
        <div class="stat-ring">
          <svg viewBox="0 0 36 36">
            <circle class="ring-bg" cx="18" cy="18" r="15.9"/>
            <circle class="ring-fill" cx="18" cy="18" r="15.9" data-pct="72"/>
          </svg>
        </div>
      </div>
      <div class="stat-card fade-up">
        <span class="stat-icon">💅</span>
        <span class="stat-num" data-target="{{ $totalDesigns }}">0</span>
        <span class="stat-label">Total Desain</span>
        <div class="stat-ring">
          <svg viewBox="0 0 36 36">
            <circle class="ring-bg" cx="18" cy="18" r="15.9"/>
            <circle class="ring-fill" cx="18" cy="18" r="15.9" data-pct="85"/>
          </svg>
        </div>
      </div>
    </div>

    {{-- QUICK LINKS --}}
    <div class="quick-links">
      <a href="{{ route('admin.appointments') }}" class="quick-card fade-up">
        <span class="quick-icon">📅</span>
        <h3>Kelola Appointment</h3>
        <p>Lihat, konfirmasi, dan kelola semua pesanan masuk</p>
      </a>
      <a href="{{ route('admin.customers') }}" class="quick-card fade-up">
        <span class="quick-icon">👥</span>
        <h3>Data Customer</h3>
        <p>Lihat daftar customer dan hubungi via WhatsApp</p>
      </a>
    </div>

    {{-- REMINDER --}}
    <div class="reminder-card fade-up">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.2rem;flex-wrap:wrap;gap:.8rem">
        <h3 class="reminder-title" style="margin-bottom:0">⏰ Reminder Appointment Terdekat</h3>
        {{-- Quick Search --}}
        <div class="search-wrap" style="max-width:220px;margin-bottom:0">
          <span class="search-icon">🔍</span>
          <input type="text" id="reminderSearch" placeholder="Cari nama..." oninput="filterReminder()"/>
        </div>
      </div>
      <div id="reminderList">
        @forelse($upcomingAppointments as $item)
          <div class="reminder-item" data-name="{{ strtolower($item->user->name) }}">
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
          <div class="empty-reminder" id="reminderEmpty">🎉 Tidak ada appointment yang perlu diperhatikan.</div>
        @endforelse
      </div>
      <p id="noReminderResult" style="display:none;text-align:center;padding:1.2rem;color:var(--gray);font-size:.85rem">Tidak ditemukan.</p>
    </div>

  </div><!-- /content -->

  {{-- QUOTE FOOTER --}}
  <div class="quote-footer">
    <em id="footerQuote"></em>
    <span>© {{ date('Y') }} OU Beauty Bar</span>
  </div>

</div><!-- /main -->

<script>
/* ══════════════════════════════
   LOADING SCREEN
══════════════════════════════ */
window.addEventListener('load', () => {
  setTimeout(() => {
    const ls = document.getElementById('loadingScreen');
    if (ls) ls.classList.add('hidden');
    // trigger fade-up after load
    document.querySelectorAll('.fade-up').forEach((el, i) => {
      setTimeout(() => el.classList.add('show'), 100 + i * 80);
    });
    // animate counters + rings after load
    animateCounters();
    animateRings();
  }, 1400);
});

/* ══════════════════════════════
   SCROLL PROGRESS
══════════════════════════════ */
const mainEl = document.getElementById('mainScroll');
mainEl?.addEventListener('scroll', () => {
  const prog = document.getElementById('scrollProg');
  if (!prog) return;
  const scrolled = mainEl.scrollTop;
  const total = mainEl.scrollHeight - mainEl.clientHeight;
  prog.style.width = (total > 0 ? (scrolled / total) * 100 : 0) + '%';
});

/* ══════════════════════════════
   LIVE CLOCK
══════════════════════════════ */
function updateClock() {
  const now = new Date();
  const h = String(now.getHours()).padStart(2,'0');
  const m = String(now.getMinutes()).padStart(2,'0');
  const s = String(now.getSeconds()).padStart(2,'0');
  const el = document.getElementById('liveClock');
  if (el) el.textContent = `${h}:${m}:${s}`;
}
setInterval(updateClock, 1000);
updateClock();

/* ══════════════════════════════
   WELCOME DATE
══════════════════════════════ */
(function setWelcomeDate() {
  const now = new Date();
  const dayEl  = document.getElementById('welcomeDay');
  const dateEl = document.getElementById('welcomeDate');
  if (dayEl)  dayEl.textContent  = now.getDate();
  if (dateEl) {
    const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    dateEl.textContent = `${days[now.getDay()]} · ${months[now.getMonth()]} ${now.getFullYear()}`;
  }
})();

/* ══════════════════════════════
   MOTIVATIONAL QUOTES
══════════════════════════════ */
const adminQuotes = [
  "Success is the sum of small efforts repeated daily.",
  "Great things are done by a series of small things brought together.",
  "The key to success is to focus on goals, not obstacles.",
  "Every day is a new opportunity to grow and improve.",
  "Discipline is the bridge between goals and accomplishment."
];
const aq = adminQuotes[Math.floor(Math.random() * adminQuotes.length)];
const aqEl = document.getElementById('adminQuote');
if (aqEl) aqEl.textContent = `"${aq}"`;
const fqEl = document.getElementById('footerQuote');
if (fqEl) fqEl.textContent = `"${aq}"`;

/* ══════════════════════════════
   ANIMATED COUNTERS
══════════════════════════════ */
function animateCounters() {
  document.querySelectorAll('.stat-num[data-target]').forEach(el => {
    const target = parseInt(el.dataset.target) || 0;
    const dur    = 1200;
    const steps  = 40;
    const inc    = target / steps;
    let cur      = 0;
    const timer  = setInterval(() => {
      cur += inc;
      if (cur >= target) { cur = target; clearInterval(timer); }
      el.textContent = Math.floor(cur);
    }, dur / steps);
  });
}

/* ══════════════════════════════
   PROGRESS RINGS
══════════════════════════════ */
function animateRings() {
  document.querySelectorAll('.ring-fill[data-pct]').forEach(el => {
    const pct = parseFloat(el.dataset.pct) || 0;
    const circumference = 2 * Math.PI * 15.9; // r=15.9
    const offset = circumference - (pct / 100) * circumference;
    el.style.strokeDasharray  = circumference;
    el.style.strokeDashoffset = circumference;
    setTimeout(() => {
      el.style.strokeDashoffset = offset;
    }, 200);
  });
}

/* ══════════════════════════════
   DARK MODE
══════════════════════════════ */
const darkBtn = document.getElementById('darkBtn');
const savedTheme = localStorage.getItem('ou-admin-theme');
if (savedTheme === 'dark') {
  document.body.classList.add('dark');
  if (darkBtn) darkBtn.textContent = '☀️';
}
function toggleDark() {
  document.body.classList.toggle('dark');
  const isDark = document.body.classList.contains('dark');
  localStorage.setItem('ou-admin-theme', isDark ? 'dark' : 'light');
  if (darkBtn) darkBtn.textContent = isDark ? '☀️' : '🌙';
}

/* ══════════════════════════════
   NOTIF POPUP
══════════════════════════════ */
setTimeout(() => {
  const popup = document.getElementById('notifPopup');
  if (popup) { popup.classList.add('hide'); setTimeout(() => popup.remove(), 300); }
}, 6000);
function tutupPopup() {
  const popup = document.getElementById('notifPopup');
  if (popup) { popup.classList.add('hide'); setTimeout(() => popup.remove(), 300); }
}

/* ══════════════════════════════
   QUICK SEARCH REMINDER
══════════════════════════════ */
function filterReminder() {
  const q = (document.getElementById('reminderSearch')?.value || '').toLowerCase().trim();
  const items = document.querySelectorAll('#reminderList .reminder-item');
  let visible = 0;
  items.forEach(item => {
    const match = !q || item.dataset.name.includes(q);
    item.style.display = match ? '' : 'none';
    if (match) visible++;
  });
  const noRes = document.getElementById('noReminderResult');
  const emptyEl = document.getElementById('reminderEmpty');
  if (noRes) noRes.style.display = (visible === 0 && items.length > 0) ? 'block' : 'none';
  if (emptyEl) emptyEl.style.display = (items.length === 0) ? 'block' : 'none';
}
</script>
</body>
</html>