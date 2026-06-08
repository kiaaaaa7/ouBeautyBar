<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>OU Beauty Bar</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400;1,600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --olive:#5C6B3A; --olive-light:#7A8C4E; --olive-pale:#E8EDD8;
      --lilac:#C4B5D4; --lilac-deep:#9B87B0; --lilac-pale:#F0EBF7;
      --cream:#FAF8F5; --dark:#2C2C2C; --gray:#6B6B6B;
      --wa:#25D366; --wa-dark:#1da851;
    }

    /* DARK MODE */
    body.dark {
      --cream:#1A1C17; --dark:#F0EBF7; --gray:#A8A8A8;
      --olive-pale:#2A3020; --lilac-pale:#1E1A24;
    }
    body.dark nav { background: rgba(26,28,23,.97); }
    body.dark .hero-left { background: linear-gradient(rgba(30,34,20,.88),rgba(30,34,20,.88)); }
    body.dark .design-card-placeholder { background: linear-gradient(135deg,#3D3448,#2A3020); }
    body.dark .clock-box { background: rgba(255,255,255,.06); color: var(--dark); }
    body.dark footer { background: #0D0E0B; }

    html { scroll-behavior: smooth; }
    body { font-family: 'Jost', sans-serif; background: var(--cream); color: var(--dark); transition: background .3s, color .3s; }

    /* ── NAV ── */
    nav {
      position: sticky; top: 0; z-index: 100;
      display: flex; justify-content: space-between; align-items: center;
      padding: 1.1rem 3.5rem;
      background: rgba(250,248,245,.97); backdrop-filter: blur(14px);
      border-bottom: 1px solid rgba(92,107,58,.12);
      transition: background .3s;
    }
    .logo { font-family:'Playfair Display',serif; font-size:1.45rem; font-weight:600; text-decoration:none; color:var(--olive); display:flex; align-items:center; gap:.5rem; }
    .logo-badge { width:34px; height:34px; background:var(--olive); border-radius:50%; display:flex; align-items:center; justify-content:center; color:var(--lilac); font-size:.75rem; font-weight:700; }
    .nav-links { display:flex; gap:1.8rem; align-items:center; }
    .nav-links a { text-decoration:none; font-size:.83rem; letter-spacing:.06em; color:var(--dark); opacity:.65; transition:opacity .2s,color .2s; }
    .nav-links a:hover { opacity:1; color:var(--olive); }
    .theme-toggle { background:none; border:1.5px solid rgba(92,107,58,.3); color:var(--olive); width:34px; height:34px; border-radius:50%; cursor:pointer; font-size:.95rem; display:flex; align-items:center; justify-content:center; transition:all .2s; }
    .theme-toggle:hover { background:var(--olive); color:white; border-color:var(--olive); }

    /* ── BUTTONS ── */
    .btn { display:inline-block; padding:.6rem 1.6rem; font-size:.78rem; letter-spacing:.08em; text-transform:uppercase; text-decoration:none; border:none; cursor:pointer; font-family:'Jost',sans-serif; transition:all .25s; border-radius:3px; }
    .btn-olive { background:var(--olive); color:white; }
    .btn-olive:hover { background:var(--olive-light); transform:translateY(-1px); }
    .btn-outline { border:1.5px solid var(--olive); color:var(--olive); background:transparent; }
    .btn-outline:hover { background:var(--olive); color:white; transform:translateY(-1px); }

    /* ── ALERT ── */
    .alert { padding:.85rem 3.5rem; font-size:.86rem; display:flex; align-items:center; gap:.8rem; border-left:3px solid var(--olive); background:var(--olive-pale); color:var(--olive); animation:slideIn .3s ease; }
    @keyframes slideIn { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:translateY(0)} }

    /* ── HERO ── */
    .hero { min-height:92vh; display:grid; grid-template-columns:1fr 1fr; align-items:center; }
    .hero-left { padding:5rem 3.5rem; background:linear-gradient(rgba(232,237,216,.72),rgba(232,237,216,.72)), url('/images/cream_strip.jpg') center/cover no-repeat; }
    .hero-eyebrow { font-size:.7rem; letter-spacing:.25em; text-transform:uppercase; color:var(--olive); margin-bottom:1.4rem; display:flex; align-items:center; gap:.6rem; }
    .hero-eyebrow::before { content:''; display:block; width:28px; height:1px; background:var(--olive); }
    h1 { font-family:'Playfair Display',serif; font-size:clamp(2.6rem,5vw,4.3rem); font-weight:400; line-height:1.15; margin-bottom:1.3rem; color:var(--dark); }
    h1 em { font-style:italic; color:var(--olive); }
    .hero-sub { font-size:.92rem; line-height:1.95; color:var(--gray); margin-bottom:.8rem; max-width:370px; }
    .hero-btns { display:flex; gap:1rem; flex-wrap:wrap; margin-top:2rem; }

    /* Clock & quote dalam hero */
    .clock-box { display:inline-flex; align-items:center; gap:.6rem; background:rgba(255,255,255,.7); backdrop-filter:blur(6px); border:1px solid rgba(92,107,58,.15); border-radius:4px; padding:.45rem 1rem; font-size:.82rem; color:var(--dark); margin-bottom:1.2rem; }
    .clock-dot { width:7px; height:7px; border-radius:50%; background:var(--olive); animation:blink 1s step-end infinite; }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.2} }
    .hero-quote { font-family:'Playfair Display',serif; font-style:italic; font-size:.88rem; color:var(--gray); margin-top:1.5rem; padding-left:1rem; border-left:2px solid var(--lilac); line-height:1.7; max-width:340px; }

    /* Hero right mosaic */
    .hero-right { height:92vh; background:var(--lilac-pale); display:grid; grid-template-columns:1fr 1fr; grid-template-rows:1fr 1fr; overflow:hidden; }
    .hero-img-cell { overflow:hidden; position:relative; cursor:default; }
    .hero-img-cell:nth-child(1) { background:linear-gradient(135deg,#C4B5D4,#9B87B0); }
    .hero-img-cell:nth-child(2) { background:linear-gradient(135deg,#7A8C4E,#5C6B3A); }
    .hero-img-cell:nth-child(3) { background:linear-gradient(135deg,#5C6B3A,#3D4A28); }
    .hero-img-cell:nth-child(4) { background:linear-gradient(135deg,#E8EDD8,#C4B5D4); }
    .nail-shape { width:55%; aspect-ratio:1/1.8; border-radius:50% 50% 40% 40%/55% 55% 45% 45%; background:rgba(255,255,255,.22); position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); transition:transform .4s ease; }
    .hero-img-cell:hover .nail-shape { transform:translate(-50%,-50%) scale(1.08); }
    .hero-tag { position:absolute; bottom:1rem; left:1rem; font-size:.63rem; letter-spacing:.1em; text-transform:uppercase; color:rgba(255,255,255,.8); }

    /* ── PROMO BANNER ── */
    .promo-banner { background:linear-gradient(90deg,var(--olive),var(--olive-light)); color:white; text-align:center; padding:.75rem 2rem; font-size:.82rem; letter-spacing:.04em; display:flex; justify-content:center; align-items:center; gap:1.2rem; }
    .promo-countdown { font-family:'Playfair Display',serif; font-size:1rem; letter-spacing:.02em; }
    #promo-timer { font-weight:600; color:var(--lilac); }

    /* ── SECTION BASE ── */
    section { padding:5.5rem 3.5rem; }
    .section-label { display:flex; align-items:center; gap:.7rem; font-size:.68rem; letter-spacing:.22em; text-transform:uppercase; color:var(--olive); margin-bottom:.9rem; }
    .section-label::before { content:'✦'; }
    h2 { font-family:'Playfair Display',serif; font-size:clamp(1.9rem,3.2vw,2.8rem); font-weight:400; margin-bottom:2.5rem; line-height:1.2; }
    h2 em { font-style:italic; color:var(--olive); }

    /* ── KATALOG ── */
    #katalog { background:linear-gradient(rgba(240,235,247,.55),rgba(240,235,247,.55)), url('/images/lilac_gradient.jpg') center/cover no-repeat; }
    .katalog-header { display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:1.8rem; gap:1rem; flex-wrap:wrap; }
    .katalog-header h2 { margin-bottom:0; }
    .slider-nav { display:flex; gap:.5rem; }
    .slider-btn { width:38px; height:38px; border-radius:50%; border:1.5px solid rgba(92,107,58,.3); background:white; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:.95rem; color:var(--olive); transition:all .2s; }
    .slider-btn:hover { background:var(--olive); color:white; border-color:var(--olive); }
    .designs-track-wrap { overflow:hidden; }
    .designs-track { display:flex; gap:1.1rem; transition:transform .42s ease; }
    .design-card { position:relative; overflow:hidden; flex:0 0 calc(33.33% - .74rem); aspect-ratio:3/4; cursor:pointer; border-radius:5px; }
    .design-card img { width:100%; height:100%; object-fit:cover; transition:transform .55s ease; }
    .design-card:hover img { transform:scale(1.07); }
    .design-card-placeholder { width:100%; height:100%; background:linear-gradient(135deg,var(--lilac),var(--lilac-deep)); display:flex; align-items:center; justify-content:center; font-size:3.5rem; }
    .design-overlay { position:absolute; inset:0; background:linear-gradient(to top,rgba(44,44,44,.9) 0%,rgba(44,44,44,.04) 55%,transparent 100%); display:flex; flex-direction:column; justify-content:flex-end; padding:1.3rem; }
    .design-kat { font-size:.62rem; letter-spacing:.14em; text-transform:uppercase; color:var(--lilac); margin-bottom:.25rem; }
    .design-nama { font-family:'Playfair Display',serif; font-size:1.2rem; color:white; font-weight:400; margin-bottom:.25rem; }
    .design-desc { font-size:.74rem; color:rgba(255,255,255,.72); margin-bottom:.7rem; line-height:1.55; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
    .design-bottom { display:flex; justify-content:space-between; align-items:center; }
    .design-harga { font-size:.8rem; color:var(--lilac); font-weight:500; }
    .btn-card { background:var(--olive); color:white; padding:.38rem 1rem; font-size:.7rem; letter-spacing:.09em; text-transform:uppercase; text-decoration:none; font-family:'Jost',sans-serif; transition:background .2s; border-radius:2px; }
    .btn-card:hover { background:var(--lilac-deep); }
    .empty-state { text-align:center; padding:3rem; opacity:.45; }

    /* ── GALERI ── */
    #galeri { background:var(--cream); }
    .galeri-track-wrap { overflow:hidden; }
    .galeri-track { display:flex; gap:.9rem; transition:transform .42s ease; }
    .galeri-item { position:relative; flex:0 0 calc(25% - .68rem); aspect-ratio:3/4; overflow:hidden; border-radius:5px; cursor:pointer; }
    .galeri-item img { width:100%; height:100%; object-fit:cover; transition:transform .5s ease; }
    .galeri-item:hover img { transform:scale(1.06); }
    .galeri-overlay { position:absolute; inset:0; background:linear-gradient(to top,rgba(44,44,44,.9) 0%,transparent 55%); opacity:0; transition:opacity .3s; display:flex; flex-direction:column; justify-content:flex-end; padding:1rem; }
    .galeri-item:hover .galeri-overlay { opacity:1; }
    .galeri-design { font-family:'Playfair Display',serif; font-size:.92rem; color:white; margin-bottom:.18rem; }
    .galeri-sub { font-size:.68rem; color:rgba(255,255,255,.75); margin-bottom:.55rem; }
    .btn-pesan { display:inline-block; background:var(--olive); color:white; padding:.32rem .85rem; font-size:.68rem; letter-spacing:.08em; text-transform:uppercase; text-decoration:none; border-radius:2px; font-family:'Jost',sans-serif; }
    .btn-pesan:hover { background:var(--lilac-deep); }

    /* ── TESTIMONI ── */
    #testimoni { background:linear-gradient(rgba(250,248,245,.18),rgba(250,248,245,.18)), url('/images/red_kotak3.jpg') center/cover no-repeat; }
    .testi-track-wrap { overflow:hidden; }
    .testi-track { display:flex; gap:1.3rem; transition:transform .42s ease; }
    .testi-card { flex:0 0 calc(25% - .975rem); background:rgba(255,255,255,.62); backdrop-filter:blur(6px); border:1px solid rgba(255,255,255,.45); padding:1.8rem; border-radius:5px; transition:transform .25s; }
    .testi-card:hover { transform:translateY(-3px); }
    .testi-stars { color:#5C6B3A; font-size:1.05rem; letter-spacing:.05em; }
    .testi-isi { font-family:'Playfair Display',serif; font-size:.92rem; line-height:1.85; font-style:italic; color:#333; margin:.75rem 0 .9rem; }
    .testi-nama { font-size:.7rem; letter-spacing:.15em; text-transform:uppercase; color:#555; }
    .testi-foto { display:flex; gap:.35rem; flex-wrap:wrap; margin-top:.75rem; }
    .testi-foto img { width:50px; height:50px; object-fit:cover; border-radius:3px; cursor:pointer; border:1px solid rgba(255,255,255,.5); transition:transform .2s; }
    .testi-foto img:hover { transform:scale(1.07); }
    .testi-nav { display:flex; justify-content:center; align-items:center; gap:.9rem; margin-top:2rem; }
    .testi-btn { width:38px; height:38px; border-radius:50%; border:1.5px solid rgba(0,0,0,.3); background:rgba(255,255,255,.72); cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:.95rem; color:#333; transition:all .2s; }
    .testi-btn:hover { background:var(--olive); color:white; border-color:var(--olive); }

    /* ── ABOUT ── */
    #about { background:linear-gradient(rgba(92,107,58,.93),rgba(92,107,58,.93)), url('/images/NAMA_FILE_KAMU.jpg') center/cover no-repeat fixed; color:white; }
    #about .section-label { color:var(--lilac); }
    #about h2 { color:white; }
    #about h2 em { color:var(--lilac); }
    .about-grid { display:grid; grid-template-columns:1fr 1fr; gap:5rem; align-items:center; }
    .about-text p { font-size:.9rem; line-height:2; opacity:.75; margin-bottom:1.4rem; }
    .about-info { display:flex; flex-direction:column; gap:.7rem; font-size:.84rem; opacity:.8; }
    .about-info span { display:flex; align-items:center; gap:.8rem; }
    .about-stats { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .about-stat { border:1px solid rgba(255,255,255,.15); padding:1.6rem; border-radius:3px; background:rgba(255,255,255,.06); transition:background .2s; }
    .about-stat:hover { background:rgba(255,255,255,.12); }
    .about-stat-num { font-family:'Playfair Display',serif; font-size:2.6rem; color:var(--lilac); display:block; line-height:1; }
    .about-stat-label { font-size:.7rem; letter-spacing:.1em; text-transform:uppercase; opacity:.5; margin-top:.35rem; display:block; }

    /* ── WA FLOAT BUTTON ── */
    .wa-float { position:fixed; bottom:1.8rem; right:1.8rem; z-index:500; background:var(--wa); color:white; border-radius:50px; padding:.7rem 1.2rem; text-decoration:none; font-size:.82rem; font-family:'Jost',sans-serif; display:flex; align-items:center; gap:.5rem; box-shadow:0 4px 16px rgba(37,211,102,.35); transition:all .25s; }
    .wa-float:hover { background:var(--wa-dark); transform:translateY(-2px) scale(1.03); box-shadow:0 6px 20px rgba(37,211,102,.45); }

    /* ── SCROLL REVEAL ── */
    .reveal { opacity:0; transform:translateY(28px); transition:opacity .55s ease, transform .55s ease; }
    .reveal.show { opacity:1; transform:translateY(0); }

    /* ── FOOTER ── */
    footer { background:#1E2018; color:rgba(255,255,255,.35); text-align:center; padding:1.8rem 3.5rem; font-size:.76rem; letter-spacing:.05em; display:flex; justify-content:center; align-items:center; gap:2rem; flex-wrap:wrap; }
    footer span { color:var(--lilac); }
    .footer-wa { color:var(--wa); text-decoration:none; font-size:.76rem; }
    .footer-wa:hover { opacity:.8; }

    /* ── RESPONSIVE ── */
    @media(max-width:900px) {
      nav { padding:1rem 1.5rem; }
      .hero { grid-template-columns:1fr; }
      .hero-left { padding:3.5rem 1.5rem; }
      .hero-right { height:50vw; }
      section, #katalog, #galeri { padding:4rem 1.5rem; }
      .design-card { flex:0 0 calc(50% - .55rem); }
      .galeri-item { flex:0 0 calc(50% - .45rem); }
      .testi-card { flex:0 0 calc(100% - 1.3rem); }
      .about-grid { grid-template-columns:1fr; gap:2.5rem; }
    }
    @media(max-width:480px) {
      h1 { font-size:2.2rem; }
      .hero-btns { flex-direction:column; }
      .design-card { flex:0 0 calc(100% - .55rem); }
    }
  </style>
</head>
<body>

{{-- WA FLOAT --}}
<a class="wa-float" href="https://wa.me/6282216672840?text=Halo+OU+Beauty+Bar!+Saya+ingin+tanya-tanya+😊" target="_blank">
  💬 WhatsApp Kami
</a>

{{-- NAV --}}
<nav>
  <a class="logo" href="/"><div class="logo-badge">OU</div> Beauty Bar</a>
  <div class="nav-links">
    <a href="#katalog">Katalog</a>
    @php $adaGaleri = $testimonials->filter(fn($t) => !empty($t->foto_hasil))->isNotEmpty(); @endphp
    @if($adaGaleri)<a href="#galeri">Galeri</a>@endif
    <a href="#testimoni">Testimoni</a>
    <a href="#about">About</a>
    @auth
      <a href="{{ route('dashboard') }}" class="btn btn-outline" style="padding:.42rem 1.1rem;font-size:.75rem">Dashboard</a>
      @if(auth()->user()->is_admin)
        <a href="{{ route('admin.index') }}" class="btn btn-olive" style="padding:.42rem 1.1rem;font-size:.75rem">Admin</a>
      @endif
    @else
      <a href="{{ route('login') }}">Login</a>
      <a href="{{ route('register') }}" class="btn btn-olive" style="padding:.42rem 1.1rem;font-size:.75rem">Daftar</a>
    @endauth
    <button class="theme-toggle" onclick="toggleTheme()" title="Ganti tema" id="themeBtn">🌙</button>
  </div>
</nav>

{{-- PROMO BANNER --}}
<div class="promo-banner">
  ✨ Promo spesial berakhir dalam &nbsp;<span class="promo-countdown"><span id="promo-timer">00:00:00</span></span>&nbsp; — Booking sekarang!
</div>

@if(session('success'))
  <div class="alert">✅ {{ session('success') }}</div>
@endif

{{-- HERO --}}
<div class="hero">
  <div class="hero-left">
    <p class="hero-eyebrow">Nail Art Studio · Bandung</p>

    {{-- JAM REAL TIME --}}
    <div class="clock-box">
      <span class="clock-dot"></span>
      <span id="live-clock">--:--:--</span>
      &nbsp;·&nbsp; Buka 09.00–17.00
    </div>

    <h1>Tiny Touch,<br><em>Feel the</em><br>Magic ✨</h1>
    <p class="hero-sub">Senin–Minggu, 09.00–17.00<br>Jl. Kalimantan No 2, Bandung<br><br>Nail art premium dengan teknik terkini. Dari gel classic hingga 3D nail art, semua tersedia untuk kamu.</p>
    <div class="hero-btns">
      <a href="#katalog" class="btn btn-olive">Lihat Katalog</a>
      @auth
        <a href="{{ route('dashboard') }}" class="btn btn-outline">Dashboard</a>
      @else
        <a href="{{ route('register') }}" class="btn btn-outline">Daftar Sekarang</a>
      @endauth
    </div>

    {{-- QUOTE RANDOM --}}
    <p class="hero-quote" id="beauty-quote"></p>
  </div>
  <div class="hero-right">
    <div class="hero-img-cell"><div class="nail-shape"></div><span class="hero-tag">3D Art</span></div>
    <div class="hero-img-cell"><div class="nail-shape"></div><span class="hero-tag">Gel</span></div>
    <div class="hero-img-cell"><div class="nail-shape"></div><span class="hero-tag">Extension</span></div>
    <div class="hero-img-cell"><div class="nail-shape"></div><span class="hero-tag">Stamping</span></div>
  </div>
</div>

{{-- KATALOG --}}
<section id="katalog" class="reveal">
  <div class="katalog-header">
    <div>
      <span class="section-label">Katalog Desain</span>
      <h2>Pilih <em>Desain</em> Favoritmu</h2>
    </div>
    <div class="slider-nav">
      <button class="slider-btn" onclick="slideKatalog(-1)">←</button>
      <button class="slider-btn" onclick="slideKatalog(1)">→</button>
    </div>
  </div>
  <div class="designs-track-wrap">
    <div class="designs-track" id="designsTrack">
      @forelse($designs as $design)
        <div class="design-card">
          @if($design->gambar)
            <img src="{{ asset('storage/' . $design->gambar) }}" alt="{{ $design->nama }}" loading="lazy"/>
          @else
            <div class="design-card-placeholder">💅</div>
          @endif
          <div class="design-overlay">
            <p class="design-kat">{{ $design->kategori }}</p>
            <h3 class="design-nama">{{ $design->nama }}</h3>
            <p class="design-desc">{{ $design->deskripsi }}</p>
            <div class="design-bottom">
              <span class="design-harga">
                @if($design->harga_type === 'estimasi')
                  Rp {{ number_format($design->harga_min,0,',','.') }} – Rp {{ number_format($design->harga_max,0,',','.') }}
                @else
                  Rp {{ number_format($design->harga,0,',','.') }}
                @endif
              </span>
              @auth
                <a href="{{ route('booking.create', $design->id) }}" class="btn-card">Booking</a>
              @else
                <a href="{{ route('login') }}" class="btn-card">Login dulu</a>
              @endauth
            </div>
          </div>
        </div>
      @empty
        <p class="empty-state">Belum ada desain tersedia. 💅</p>
      @endforelse
    </div>
  </div>
</section>

{{-- GALERI --}}
@php $galeriItems = $testimonials->filter(fn($t) => !empty($t->foto_hasil)); @endphp
@if($galeriItems->isNotEmpty())
<section id="galeri" class="reveal">
  <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:1.6rem;flex-wrap:wrap;gap:1rem">
    <div>
      <span class="section-label">Hasil Karya</span>
      <h2 style="margin-bottom:0">Inspirasi <em>dari Pelanggan Kami</em></h2>
    </div>
    <div class="slider-nav">
      <button class="slider-btn" onclick="slideGaleri(-1)">←</button>
      <button class="slider-btn" onclick="slideGaleri(1)">→</button>
    </div>
  </div>
  <div class="galeri-track-wrap">
    <div class="galeri-track" id="galeriTrack">
      @foreach($galeriItems as $testi)
        @foreach($testi->foto_hasil as $foto)
          <div class="galeri-item">
            <img src="{{ asset('storage/' . $foto) }}" alt="Hasil nail art" loading="lazy"/>
            <div class="galeri-overlay">
              @if($testi->design)
                <p class="galeri-design">{{ $testi->design->nama }}</p>
                <p class="galeri-sub">{{ $testi->panjang_kuku }}{{ $testi->bentuk_kuku ? ' · '.$testi->bentuk_kuku : '' }}</p>
              @endif
              @auth
                @if($testi->design)
                  <a href="{{ route('booking.create', $testi->design_id) }}" class="btn-pesan">Pesan ini! →</a>
                @endif
              @else
                <a href="{{ route('login') }}" class="btn-pesan">Login untuk pesan →</a>
              @endauth
            </div>
          </div>
        @endforeach
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- TESTIMONI --}}
<section id="testimoni" class="reveal">
  <span class="section-label">Testimoni</span>
  <h2>Kata Mereka <em>tentang Kami</em></h2>
  <div class="testi-track-wrap">
    <div class="testi-track" id="testiTrack">
      @forelse($testimonials as $testi)
        <div class="testi-card">
          <div class="testi-stars">
            {{ str_repeat('★', $testi->rating) }}{{ str_repeat('☆', 5 - $testi->rating) }}
          </div>
          <p class="testi-isi">"{{ $testi->isi }}"</p>
          <p class="testi-nama">— {{ $testi->user->name }}</p>
          @if(!empty($testi->foto_hasil))
            <div class="testi-foto">
              @foreach($testi->foto_hasil as $foto)
                <img src="{{ asset('storage/' . $foto) }}" alt="Foto testimoni" onclick="window.open(this.src)" loading="lazy"/>
              @endforeach
            </div>
          @endif
        </div>
      @empty
        <div class="testi-card">
          <p style="color:rgba(255,255,255,.82);font-size:.88rem">Belum ada testimoni.</p>
        </div>
      @endforelse
    </div>
  </div>
  <div class="testi-nav">
    <button class="testi-btn" onclick="slideTesti(-1)">←</button>
    <button class="testi-btn" onclick="slideTesti(1)">→</button>
  </div>
</section>

{{-- ABOUT --}}
<section id="about" class="reveal">
  <div class="about-grid">
    <div class="about-text">
      <span class="section-label">Tentang Kami</span>
      <h2>Studio <em>Nail Art</em><br>Terpercaya</h2>
      <p>OU Beauty Bar hadir untuk memberikan pengalaman nail art terbaik di Bandung. Kami menggunakan bahan-bahan berkualitas tinggi yang aman untuk kuku dan kulit kamu.</p>
      <div class="about-info">
        <span>📅 Senin – Minggu</span>
        <span>🕘 09.00 – 17.00 WIB</span>
        <span>📍 Jl. Kalimantan No 2, Bandung</span>
        <span>📸 @ou.beautybar</span>
        <span>💬 0822-1667-2840</span>
      </div>
    </div>
    <div class="about-stats">
      <div class="about-stat"><span class="about-stat-num">500+</span><span class="about-stat-label">Klien Puas</span></div>
      <div class="about-stat"><span class="about-stat-num">50+</span><span class="about-stat-label">Desain</span></div>
      <div class="about-stat"><span class="about-stat-num">3+</span><span class="about-stat-label">Tahun</span></div>
      <div class="about-stat"><span class="about-stat-num">5★</span><span class="about-stat-label">Rating</span></div>
    </div>
  </div>
</section>

<footer>
  <p>© 2024 <span>OU Beauty Bar</span> · Jl. Kalimantan No 2, Bandung 💅</p>
  <a class="footer-wa" href="https://wa.me/6282216672840" target="_blank">💬 WhatsApp Kami</a>
  <p style="opacity:.4">Made with ♥ in Bandung</p>
</footer>

<script>
/* ── JAM REAL TIME ── */
function updateClock() {
  const now = new Date();
  const h = String(now.getHours()).padStart(2,'0');
  const m = String(now.getMinutes()).padStart(2,'0');
  const s = String(now.getSeconds()).padStart(2,'0');
  const el = document.getElementById('live-clock');
  if (el) el.textContent = `${h}:${m}:${s}`;
}
setInterval(updateClock, 1000);
updateClock();

/* ── PROMO COUNTDOWN (reset tiap tengah malam) ── */
function updatePromo() {
  const now = new Date();
  const midnight = new Date(now);
  midnight.setHours(23, 59, 59, 999);
  const diff = Math.max(0, midnight - now);
  const h = String(Math.floor(diff / 3600000)).padStart(2,'0');
  const m = String(Math.floor((diff % 3600000) / 60000)).padStart(2,'0');
  const s = String(Math.floor((diff % 60000) / 1000)).padStart(2,'0');
  const el = document.getElementById('promo-timer');
  if (el) el.textContent = `${h}:${m}:${s}`;
}
setInterval(updatePromo, 1000);
updatePromo();

/* ── QUOTE RANDOM ── */
const quotes = [
  "Life is too short for boring nails.",
  "Your nails are a canvas — paint them beautifully.",
  "Beauty begins the moment you decide to be yourself.",
  "Tiny details make the biggest statement.",
  "Confidence starts with self-care. 💅"
];
const qEl = document.getElementById('beauty-quote');
if (qEl) qEl.textContent = quotes[Math.floor(Math.random() * quotes.length)];

/* ── DARK MODE ── */
const btn = document.getElementById('themeBtn');
const saved = localStorage.getItem('ou-theme');
if (saved === 'dark') { document.body.classList.add('dark'); if(btn) btn.textContent = '☀️'; }
function toggleTheme() {
  document.body.classList.toggle('dark');
  const isDark = document.body.classList.contains('dark');
  localStorage.setItem('ou-theme', isDark ? 'dark' : 'light');
  if (btn) btn.textContent = isDark ? '☀️' : '🌙';
}

/* ── KATALOG SLIDER (auto + manual) ── */
let katalogIdx = 0, katalogAuto;
function slideKatalog(dir) {
  const track = document.getElementById('designsTrack');
  const cards = track ? track.children : [];
  if (!cards.length) return;
  const vw = window.innerWidth;
  const visCount = vw <= 480 ? 1 : vw <= 900 ? 2 : 3;
  const cardW = cards[0].offsetWidth + (vw <= 480 ? 8 : 18);
  const maxIdx = Math.max(0, cards.length - visCount);
  katalogIdx = Math.min(Math.max(katalogIdx + dir, 0), maxIdx);
  if (katalogIdx >= maxIdx && dir > 0) katalogIdx = 0;
  track.style.transform = `translateX(-${katalogIdx * cardW}px)`;
}
katalogAuto = setInterval(() => slideKatalog(1), 4000);
document.querySelector('.designs-track-wrap')?.addEventListener('mouseenter', () => clearInterval(katalogAuto));
document.querySelector('.designs-track-wrap')?.addEventListener('mouseleave', () => {
  katalogAuto = setInterval(() => slideKatalog(1), 4000);
});

/* ── GALERI SLIDER ── */
let galeriIdx = 0;
function slideGaleri(dir) {
  const track = document.getElementById('galeriTrack');
  if (!track) return;
  const cards = track.children;
  if (!cards.length) return;
  const vw = window.innerWidth;
  const visCount = vw <= 900 ? 2 : 4;
  const cardW = cards[0].offsetWidth + 14;
  const maxIdx = Math.max(0, cards.length - visCount);
  galeriIdx = Math.min(Math.max(galeriIdx + dir, 0), maxIdx);
  track.style.transform = `translateX(-${galeriIdx * cardW}px)`;
}

/* ── TESTIMONI SLIDER ── */
let testiIdx = 0;
function slideTesti(dir) {
  const track = document.getElementById('testiTrack');
  const cards = track ? track.children : [];
  if (!cards.length) return;
  const vw = window.innerWidth;
  const visCount = vw <= 900 ? 1 : 4;
  const cardW = cards[0].offsetWidth + 21;
  const maxIdx = Math.max(0, cards.length - visCount);
  testiIdx = Math.min(Math.max(testiIdx + dir, 0), maxIdx);
  track.style.transform = `translateX(-${testiIdx * cardW}px)`;
}

/* ── SCROLL REVEAL ── */
const revealEls = document.querySelectorAll('.reveal');
const io = new IntersectionObserver(entries => {
  entries.forEach(e => { if(e.isIntersecting) { e.target.classList.add('show'); io.unobserve(e.target); } });
}, { threshold: 0.12 });
revealEls.forEach(el => io.observe(el));
</script>
</body>
</html>