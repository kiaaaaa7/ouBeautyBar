<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'OU Beauty Bar') }}</title>

  <!-- OU Beauty Bar Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    /* ══════════════════════════════════════════════
       OU BEAUTY BAR — GLOBAL LAYOUT & NAVBAR STYLES
    ══════════════════════════════════════════════ */

    *, *::before, *::after { box-sizing: border-box; }

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
      --nav-h:       70px;
    }

    @keyframes ouFadeUp {
      from { opacity: 0; transform: translateY(22px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes ouFadeIn {
      from { opacity: 0; }
      to   { opacity: 1; }
    }
    @keyframes ouSlideDown {
      from { opacity: 0; transform: translateY(-10px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'Jost', sans-serif;
      background: var(--bg);
      color: var(--dark);
      min-height: 100vh;
      margin: 0;
      padding: 0;
      -webkit-font-smoothing: antialiased;
      overflow-x: hidden;
    }

    /* ════════════════════════════
       NAVBAR
    ════════════════════════════ */
    .ou-navbar {
      position: sticky;
      top: 0;
      z-index: 500;
      height: var(--nav-h);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 4rem;
      background: rgba(250,248,245,.94);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid rgba(92,107,58,.1);
      transition: box-shadow .3s ease;
    }

    .ou-navbar.scrolled {
      box-shadow: 0 4px 28px rgba(92,107,58,.1);
    }

    /* Logo */
    .ou-nav-logo {
      font-family: 'Playfair Display', serif;
      font-size: 1.4rem;
      font-weight: 600;
      text-decoration: none;
      color: var(--olive);
      display: flex;
      align-items: center;
      gap: .6rem;
      letter-spacing: .01em;
      transition: opacity .2s;
      flex-shrink: 0;
    }
    .ou-nav-logo:hover { opacity: .85; }

    .ou-logo-badge {
      width: 36px; height: 36px;
      background: linear-gradient(135deg, var(--olive) 0%, var(--olive-light) 100%);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: var(--cream); font-size: .7rem; font-weight: 700;
      letter-spacing: .04em;
      flex-shrink: 0;
      box-shadow: 0 4px 12px rgba(92,107,58,.3);
    }

    /* Nav links */
    .ou-nav-links {
      display: flex;
      align-items: center;
      gap: 2.4rem;
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .ou-nav-links a {
      font-size: .82rem;
      font-weight: 400;
      text-decoration: none;
      color: var(--gray);
      letter-spacing: .04em;
      position: relative;
      transition: color .22s;
      padding-bottom: .2rem;
    }

    .ou-nav-links a::after {
      content: '';
      position: absolute;
      bottom: -2px; left: 0;
      width: 0; height: 1.5px;
      background: var(--olive);
      border-radius: 2px;
      transition: width .28s ease;
    }

    .ou-nav-links a:hover { color: var(--olive); }
    .ou-nav-links a:hover::after { width: 100%; }

    .ou-nav-links a.active {
      color: var(--olive);
      font-weight: 500;
    }
    .ou-nav-links a.active::after { width: 100%; }

    /* Nav actions */
    .ou-nav-actions {
      display: flex;
      align-items: center;
      gap: .8rem;
    }

    .ou-btn-outline {
      display: inline-flex; align-items: center; gap: .35rem;
      padding: .52rem 1.25rem;
      font-size: .78rem; letter-spacing: .06em; text-transform: uppercase;
      background: none; border: 1.5px solid rgba(92,107,58,.22); color: var(--olive);
      cursor: pointer; font-family: 'Jost', sans-serif; text-decoration: none;
      border-radius: 8px; font-weight: 500;
      transition: all .22s;
    }
    .ou-btn-outline:hover {
      background: var(--olive-pale);
      border-color: var(--olive);
    }

    .ou-btn-primary {
      display: inline-flex; align-items: center; gap: .35rem;
      padding: .55rem 1.4rem;
      font-size: .78rem; letter-spacing: .06em; text-transform: uppercase;
      background: var(--olive); color: #fff;
      border: none; cursor: pointer; font-family: 'Jost', sans-serif; text-decoration: none;
      border-radius: 8px; font-weight: 500;
      box-shadow: 0 4px 14px rgba(92,107,58,.25);
      transition: all .22s;
    }
    .ou-btn-primary:hover {
      background: var(--olive-light);
      box-shadow: 0 6px 20px rgba(92,107,58,.35);
      transform: translateY(-1px);
    }

    /* User avatar pill */
    .ou-user-pill {
      display: flex; align-items: center; gap: .6rem;
      padding: .38rem .9rem .38rem .38rem;
      border: 1.5px solid rgba(92,107,58,.15);
      border-radius: 20px; cursor: pointer;
      transition: all .22s; background: #fff;
      text-decoration: none; color: var(--dark);
      font-size: .8rem; font-weight: 400;
    }
    .ou-user-pill:hover { border-color: var(--olive); background: var(--olive-faint); }

    .ou-user-avatar {
      width: 28px; height: 28px;
      background: linear-gradient(135deg, var(--olive-pale), var(--lilac-pale));
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: .72rem; font-weight: 600; color: var(--olive);
      flex-shrink: 0;
    }

    /* Mobile hamburger */
    .ou-hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      background: none;
      border: none;
      cursor: pointer;
      padding: .5rem;
    }
    .ou-hamburger span {
      display: block; width: 22px; height: 1.5px;
      background: var(--olive); border-radius: 2px;
      transition: all .28s ease;
    }

    /* Mobile drawer */
    .ou-mobile-menu {
      display: none;
      position: fixed;
      top: var(--nav-h); left: 0; right: 0;
      background: rgba(250,248,245,.98);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid rgba(92,107,58,.1);
      padding: 1.5rem 2rem;
      z-index: 490;
      box-shadow: 0 12px 40px rgba(92,107,58,.12);
      animation: ouSlideDown .25s ease;
    }
    .ou-mobile-menu.open { display: block; }

    .ou-mobile-menu ul {
      list-style: none; padding: 0; margin: 0;
      display: flex; flex-direction: column; gap: .15rem;
    }

    .ou-mobile-menu a {
      display: block; padding: .8rem 1rem;
      font-size: .88rem; text-decoration: none;
      color: var(--gray); border-radius: 9px;
      transition: all .2s;
    }
    .ou-mobile-menu a:hover { background: var(--olive-faint); color: var(--olive); }

    .ou-mobile-divider {
      height: 1px; background: rgba(92,107,58,.1); margin: .8rem 0;
    }

    /* ════════════════════════════
       PAGE TRANSITION
    ════════════════════════════ */
    .ou-page-wrapper {
      animation: ouFadeUp .45s ease both;
    }

    /* ════════════════════════════
       GLOBAL CONTAINER
    ════════════════════════════ */
    .ou-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 2rem;
    }

    .ou-container-sm {
      max-width: 860px;
      margin: 0 auto;
      padding: 0 2rem;
    }

    /* ════════════════════════════
       PAGE SECTION SPACING
    ════════════════════════════ */
    .ou-section { padding: 4rem 0; }
    .ou-section-sm { padding: 2.5rem 0; }

    /* ════════════════════════════
       TYPOGRAPHY HELPERS
    ════════════════════════════ */
    .ou-heading {
      font-family: 'Playfair Display', serif;
      font-weight: 400; line-height: 1.2;
    }
    .ou-heading em { font-style: italic; color: var(--olive); }

    .ou-label {
      font-size: .62rem; letter-spacing: .2em; text-transform: uppercase;
      color: var(--lilac-deep); font-weight: 500;
    }

    /* ════════════════════════════
       CARD BASE
    ════════════════════════════ */
    .ou-card {
      background: #fff;
      border-radius: 18px;
      border: 1px solid rgba(92,107,58,.08);
      box-shadow: 0 4px 24px rgba(92,107,58,.06);
      transition: transform .3s ease, box-shadow .3s ease;
    }
    .ou-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 14px 44px rgba(92,107,58,.12);
    }

    /* ════════════════════════════
       FLASH MESSAGE
    ════════════════════════════ */
    .ou-flash {
      display: flex; align-items: center; gap: .8rem;
      padding: 1rem 1.5rem; margin: 1.2rem 0;
      border-radius: 12px; font-size: .84rem;
      animation: ouFadeUp .4s ease both;
    }
    .ou-flash.success {
      background: linear-gradient(135deg, var(--olive-pale), #eef1e2);
      border: 1px solid rgba(92,107,58,.2); color: var(--olive);
    }
    .ou-flash.error {
      background: #fff5f5; border: 1px solid rgba(229,57,53,.2); color: #c62828;
    }
    .ou-flash-dot {
      width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0;
    }
    .success .ou-flash-dot { background: var(--olive); }
    .error   .ou-flash-dot { background: #e53935; }

    /* ════════════════════════════
       RESPONSIVE
    ════════════════════════════ */
    @media (max-width: 1024px) {
      .ou-navbar { padding: 0 2rem; }
    }

    @media (max-width: 768px) {
      .ou-navbar { padding: 0 1.5rem; }
      .ou-nav-links { display: none; }
      .ou-hamburger { display: flex; }
      .ou-btn-primary,
      .ou-btn-outline { display: none; }
      .ou-user-pill { display: none; }
    }

    @media (max-width: 480px) {
      .ou-container,
      .ou-container-sm { padding: 0 1.2rem; }
    }
  </style>

  @stack('styles')
</head>
<body class="{{ request()->is('admin*') ? 'ou-admin-body' : '' }}">

  {{-- ════════════════════════════
       NAVBAR (non-admin pages)
  ════════════════════════════ --}}
  @unless(request()->is('admin*') || request()->is('login') || request()->is('register'))
  <nav class="ou-navbar" id="ouNavbar">

    {{-- Logo --}}
    <a class="ou-nav-logo" href="{{ url('/') }}">
      <div class="ou-logo-badge">OU</div>
      Beauty Bar
    </a>

    {{-- Desktop Links --}}
    <ul class="ou-nav-links">
      <li><a href="{{ url('/') }}"          class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
      <li><a href="{{ url('/designs') }}"   class="{{ request()->is('designs*') ? 'active' : '' }}">Desain</a></li>
      <li><a href="{{ url('/about') }}"     class="{{ request()->is('about*') ? 'active' : '' }}">Tentang Kami</a></li>
      <li><a href="{{ url('/contact') }}"   class="{{ request()->is('contact*') ? 'active' : '' }}">Kontak</a></li>
    </ul>

    {{-- Nav Actions --}}
    <div class="ou-nav-actions">
      @auth
        <div class="ou-user-pill">
          <div class="ou-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
          {{ Str::words(auth()->user()->name, 1, '') }}
        </div>
        <form action="{{ route('logout') }}" method="POST" style="display:inline">
          @csrf
          <button type="submit" class="ou-btn-outline">Keluar</button>
        </form>
      @else
        <a href="{{ route('login') }}"    class="ou-btn-outline">Masuk</a>
        <a href="{{ route('register') }}" class="ou-btn-primary">Daftar</a>
      @endauth
    </div>

    {{-- Mobile Hamburger --}}
    <button class="ou-hamburger" id="ouHamburger" aria-label="Menu" onclick="toggleMobileMenu()">
      <span></span><span></span><span></span>
    </button>

  </nav>

  {{-- Mobile Menu --}}
  <div class="ou-mobile-menu" id="ouMobileMenu">
    <ul>
      <li><a href="{{ url('/') }}">Beranda</a></li>
      <li><a href="{{ url('/designs') }}">Desain</a></li>
      <li><a href="{{ url('/about') }}">Tentang Kami</a></li>
      <li><a href="{{ url('/contact') }}">Kontak</a></li>
    </ul>
    <div class="ou-mobile-divider"></div>
    @auth
      <ul>
        <li>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="background:none;border:none;font-family:'Jost',sans-serif;font-size:.88rem;color:var(--gray);cursor:pointer;padding:.8rem 1rem;width:100%;text-align:left;border-radius:9px;">Keluar</button>
          </form>
        </li>
      </ul>
    @else
      <ul>
        <li><a href="{{ route('login') }}">Masuk</a></li>
        <li><a href="{{ route('register') }}">Daftar Akun</a></li>
      </ul>
    @endauth
  </div>
  @endunless

  {{-- ════════════════════════════
       FLASH MESSAGES
  ════════════════════════════ --}}
  @if(session('success') || session('error'))
  <div class="ou-container">
    @if(session('success'))
    <div class="ou-flash success">
      <div class="ou-flash-dot"></div>
      {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="ou-flash error">
      <div class="ou-flash-dot"></div>
      {{ session('error') }}
    </div>
    @endif
  </div>
  @endif

  {{-- ════════════════════════════
       PAGE CONTENT
  ════════════════════════════ --}}
  <div class="ou-page-wrapper">
    @if (isset($header))
      <header style="background:#fff; border-bottom:1px solid rgba(92,107,58,.09); padding:1.5rem 4rem;">
        <div class="ou-container" style="max-width:100%;padding:0">
          {{ $header }}
        </div>
      </header>
    @endif

    <main>
      {{ $slot }}
    </main>
  </div>

  {{-- ════════════════════════════
       FOOTER (non-admin)
  ════════════════════════════ --}}
  @unless(request()->is('admin*') || request()->is('login') || request()->is('register'))
  <footer style="
    background: linear-gradient(168deg, #2e3920 0%, #3d4a26 50%, #5C6B3A 100%);
    color: rgba(255,255,255,.55);
    padding: 3rem 4rem 2rem;
    margin-top: auto;
    font-size: .8rem;
    font-family: 'Jost', sans-serif;
  ">
    <div style="
      max-width: 1200px; margin: 0 auto;
      display: flex; justify-content: space-between;
      align-items: center; flex-wrap: wrap; gap: 1rem;
    ">
      <div>
        <div style="
          font-family: 'Playfair Display', serif;
          font-size: 1.1rem; color: #fff; font-weight: 500;
          margin-bottom: .3rem; display: flex; align-items: center; gap: .5rem;
        ">
          <span style="
            width: 26px; height: 26px;
            background: rgba(196,181,212,.3);
            border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: .65rem; font-weight: 700; letter-spacing: .04em;
          ">OU</span>
          Beauty Bar
        </div>
        <p style="font-size:.75rem;">Premium nail art &amp; beauty service</p>
      </div>
      <p style="font-size:.74rem;">&copy; {{ date('Y') }} OU Beauty Bar. All rights reserved.</p>
    </div>
  </footer>
  @endunless

  <script>
    // Navbar scroll shadow
    const navbar = document.getElementById('ouNavbar');
    if (navbar) {
      window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 20);
      }, { passive: true });
    }

    // Mobile menu toggle
    function toggleMobileMenu() {
      const menu = document.getElementById('ouMobileMenu');
      const ham  = document.getElementById('ouHamburger');
      if (!menu) return;
      const open = menu.classList.toggle('open');
      if (ham) {
        const spans = ham.querySelectorAll('span');
        if (open) {
          spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
          spans[1].style.opacity  = '0';
          spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
        } else {
          spans.forEach(s => { s.style.transform = ''; s.style.opacity = ''; });
        }
      }
    }

    // Close mobile menu on outside click
    document.addEventListener('click', e => {
      const menu = document.getElementById('ouMobileMenu');
      const ham  = document.getElementById('ouHamburger');
      if (menu && menu.classList.contains('open')) {
        if (!menu.contains(e.target) && !ham.contains(e.target)) {
          menu.classList.remove('open');
          const spans = ham.querySelectorAll('span');
          spans.forEach(s => { s.style.transform = ''; s.style.opacity = ''; });
        }
      }
    });
  </script>

  @stack('scripts')
</body>
</html>