<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>OU Beauty Bar</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400;1,600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root { --olive:#5C6B3A; --olive-light:#7A8C4E; --olive-pale:#E8EDD8; --lilac:#C4B5D4; --lilac-deep:#9B87B0; --lilac-pale:#F0EBF7; --cream:#FAF8F5; --dark:#2C2C2C; --gray:#6B6B6B; }
    html { scroll-behavior: smooth; }
    body { font-family: 'Jost', sans-serif; background: var(--cream); color: var(--dark); }

    nav { position: sticky; top: 0; z-index: 100; display: flex; justify-content: space-between; align-items: center; padding: 1.2rem 4rem; background: rgba(250,248,245,.96); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(92,107,58,.12); }
    .logo { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 600; text-decoration: none; color: var(--olive); display: flex; align-items: center; gap: .5rem; }
    .logo-badge { width: 36px; height: 36px; background: var(--olive); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--lilac); font-size: .8rem; font-weight: 700; }
    .nav-links { display: flex; gap: 2rem; align-items: center; }
    .nav-links a { text-decoration: none; font-size: .85rem; letter-spacing: .06em; color: var(--dark); opacity: .65; transition: opacity .2s, color .2s; }
    .nav-links a:hover { opacity: 1; color: var(--olive); }
    .btn { display: inline-block; padding: .6rem 1.6rem; font-size: .8rem; letter-spacing: .08em; text-transform: uppercase; text-decoration: none; border: none; cursor: pointer; font-family: 'Jost', sans-serif; transition: all .25s; }
    .btn-olive { background: var(--olive); color: white; }
    .btn-olive:hover { background: var(--olive-light); }
    .btn-outline { border: 1.5px solid var(--olive); color: var(--olive); background: transparent; }
    .btn-outline:hover { background: var(--olive); color: white; }
    .alert { padding: .9rem 4rem; font-size: .88rem; display: flex; align-items: center; gap: .8rem; }
    .alert-success { background: #f0f4e8; color: var(--olive); border-left: 4px solid var(--olive); }

    /* HERO */
    .hero { min-height: 92vh; display: grid; grid-template-columns: 1fr 1fr; align-items: center; }
    .hero-left { padding: 5rem 4rem; background: linear-gradient(rgba(232,237,216,.70), rgba(232,237,216,.70)), url('/images/cream_strip.jpg') center/cover no-repeat; }
    .hero-eyebrow { font-size: .72rem; letter-spacing: .25em; text-transform: uppercase; color: var(--olive); margin-bottom: 1.5rem; display: flex; align-items: center; gap: .5rem; }
    .hero-eyebrow::before { content: ''; display: block; width: 30px; height: 1px; background: var(--olive); }
    h1 { font-family: 'Playfair Display', serif; font-size: clamp(2.8rem, 5vw, 4.5rem); font-weight: 400; line-height: 1.15; margin-bottom: 1.5rem; color: var(--dark); }
    h1 em { font-style: italic; color: var(--olive); }
    .hero-sub { font-size: .95rem; line-height: 1.9; color: var(--gray); margin-bottom: 2.5rem; max-width: 380px; }
    .hero-btns { display: flex; gap: 1rem; flex-wrap: wrap; }
    .hero-right { height: 92vh; background: var(--lilac-pale); display: grid; grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr; overflow: hidden; }
    .hero-img-cell { overflow: hidden; position: relative; }
    .hero-img-cell:nth-child(1) { background: linear-gradient(135deg, #C4B5D4, #9B87B0); }
    .hero-img-cell:nth-child(2) { background: linear-gradient(135deg, #7A8C4E, #5C6B3A); }
    .hero-img-cell:nth-child(3) { background: linear-gradient(135deg, #5C6B3A, #3D4A28); }
    .hero-img-cell:nth-child(4) { background: linear-gradient(135deg, #E8EDD8, #C4B5D4); }
    .nail-shape { width: 60%; margin: auto; aspect-ratio: 1/1.8; border-radius: 50% 50% 40% 40%/55% 55% 45% 45%; background: rgba(255,255,255,.25); position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); }
    .hero-tag { position: absolute; bottom: 1rem; left: 1rem; font-size: .65rem; letter-spacing: .1em; text-transform: uppercase; color: rgba(255,255,255,.8); }

    section { padding: 6rem 4rem; }
    .section-label { display: flex; align-items: center; gap: .8rem; font-size: .7rem; letter-spacing: .22em; text-transform: uppercase; color: var(--olive); margin-bottom: 1rem; }
    .section-label::before { content: '✦'; }
    h2 { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 3.5vw, 3rem); font-weight: 400; margin-bottom: 3rem; line-height: 1.2; }
    h2 em { font-style: italic; color: var(--olive); }

    /* KATALOG */
    #katalog { padding: 6rem 4rem; background: linear-gradient(rgba(240,235,247,.50), rgba(240,235,247,.50)), url('/images/lilac_gradient.jpg') center/cover no-repeat; }
    .katalog-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; }
    .katalog-header h2 { margin-bottom: 0; }
    .slider-nav { display: flex; gap: .6rem; }
    .slider-btn { width: 40px; height: 40px; border-radius: 50%; border: 1.5px solid rgba(92,107,58,.3); background: white; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1rem; color: var(--olive); transition: all .2s; }
    .slider-btn:hover { background: var(--olive); color: white; border-color: var(--olive); }
    .designs-track-wrap { overflow: hidden; }
    .designs-track { display: flex; gap: 1.2rem; transition: transform .4s ease; }
    .design-card { position: relative; overflow: hidden; flex: 0 0 calc(33.33% - .8rem); aspect-ratio: 3/4; cursor: pointer; border-radius: 4px; }
    .design-card img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s ease; }
    .design-card:hover img { transform: scale(1.08); }
    .design-card-placeholder { width: 100%; height: 100%; background: linear-gradient(135deg, var(--lilac), var(--lilac-deep)); display: flex; align-items: center; justify-content: center; font-size: 4rem; }
    .design-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(44,44,44,.88) 0%, rgba(44,44,44,.05) 55%, transparent 100%); display: flex; flex-direction: column; justify-content: flex-end; padding: 1.5rem; }
    .design-kat { font-size: .63rem; letter-spacing: .15em; text-transform: uppercase; color: var(--lilac); margin-bottom: .3rem; }
    .design-nama { font-family: 'Playfair Display', serif; font-size: 1.25rem; color: white; font-weight: 400; margin-bottom: .3rem; }
    .design-desc { font-size: .76rem; color: rgba(255,255,255,.7); margin-bottom: .8rem; line-height: 1.5; }
    .design-bottom { display: flex; justify-content: space-between; align-items: center; }
    .design-harga { font-size: .82rem; color: var(--lilac); font-weight: 500; }
    .btn-card { background: var(--olive); color: white; padding: .4rem 1.1rem; font-size: .72rem; letter-spacing: .1em; text-transform: uppercase; text-decoration: none; font-family: 'Jost', sans-serif; transition: background .2s; border-radius: 2px; }
    .btn-card:hover { background: var(--lilac-deep); }
    .empty-state { text-align: center; padding: 3rem; opacity: .45; }

    /* GALERI */
    #galeri { background: var(--cream); padding: 6rem 4rem; }
    .galeri-track-wrap { overflow: hidden; }
    .galeri-track { display: flex; gap: 1rem; transition: transform .4s ease; }
    .galeri-item { position: relative; flex: 0 0 calc(25% - .75rem); aspect-ratio: 3/4; overflow: hidden; border-radius: 4px; cursor: pointer; }
    .galeri-item img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
    .galeri-item:hover img { transform: scale(1.06); }
    .galeri-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(44,44,44,.9) 0%, transparent 55%); opacity: 0; transition: opacity .3s; display: flex; flex-direction: column; justify-content: flex-end; padding: 1rem; }
    .galeri-item:hover .galeri-overlay { opacity: 1; }
    .galeri-design { font-family: 'Playfair Display', serif; font-size: .95rem; color: white; margin-bottom: .2rem; }
    .galeri-sub { font-size: .7rem; color: rgba(255,255,255,.75); margin-bottom: .6rem; }
    .btn-pesan { display: inline-block; background: var(--olive); color: white; padding: .35rem .9rem; font-size: .7rem; letter-spacing: .08em; text-transform: uppercase; text-decoration: none; border-radius: 2px; font-family: 'Jost', sans-serif; }
    .btn-pesan:hover { background: var(--lilac-deep); }
    .galeri-nav { display: flex; justify-content: flex-end; gap: .6rem; margin-bottom: 1.5rem; }

    /* TESTIMONI */
    #testimoni { background: linear-gradient(rgba(250,248,245,.15), rgba(250,248,245,.15)), url('/images/red_kotak3.jpg') center/cover no-repeat; }
    .testi-track-wrap { overflow: hidden; }
    .testi-track { display: flex; gap: 1.5rem; transition: transform .4s ease; }
    .testi-card { flex: 0 0 calc(25% - 1.125rem); background: rgba(255,255,255,.6); backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,.4); padding: 2rem; border-radius: 4px; }
    .testi-rating span { color: #444; font-size: 1.1rem; }
    .testi-isi { font-family: 'Playfair Display', serif; font-size: .95rem; line-height: 1.8; font-style: italic; color: #333; margin: .8rem 0 1rem; }
    .testi-nama { font-size: .72rem; letter-spacing: .15em; text-transform: uppercase; color: #555; }
    .testi-foto { display: flex; gap: .4rem; flex-wrap: wrap; margin-top: .8rem; }
    .testi-foto img { width: 52px; height: 52px; object-fit: cover; border-radius: 3px; cursor: pointer; border: 1px solid rgba(255,255,255,.5); }
    .testi-nav { display: flex; justify-content: center; align-items: center; gap: 1rem; margin-top: 2rem; }
    .testi-btn { width: 40px; height: 40px; border-radius: 50%; border: 1.5px solid rgba(0,0,0,.3); background: rgba(255,255,255,.7); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1rem; color: #333; transition: all .2s; }

    /* ABOUT */
    #about { background: linear-gradient(rgba(92,107,58,.92), rgba(92,107,58,.92)), url('/images/NAMA_FILE_KAMU.jpg') center/cover no-repeat fixed; color: white; }
    #about .section-label { color: var(--lilac); }
    #about h2 { color: white; }
    #about h2 em { color: var(--lilac); }
    .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center; }
    .about-text p { font-size: .92rem; line-height: 2; opacity: .75; margin-bottom: 1.5rem; }
    .about-info { display: flex; flex-direction: column; gap: .8rem; font-size: .85rem; opacity: .8; }
    .about-info span { display: flex; align-items: center; gap: .8rem; }
    .about-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .about-stat { border: 1px solid rgba(255,255,255,.15); padding: 1.8rem; border-radius: 2px; background: rgba(255,255,255,.05); }
    .about-stat-num { font-family: 'Playfair Display', serif; font-size: 2.8rem; color: var(--lilac); display: block; line-height: 1; }
    .about-stat-label { font-size: .72rem; letter-spacing: .1em; text-transform: uppercase; opacity: .5; margin-top: .4rem; display: block; }

    footer { background: #1E2018; color: rgba(255,255,255,.35); text-align: center; padding: 2rem 4rem; font-size: .78rem; letter-spacing: .05em; }
    footer span { color: var(--lilac); }

    @media(max-width:768px) {
      nav { padding: 1rem 1.5rem; }
      .hero { grid-template-columns: 1fr; }
      .hero-right { height: 50vw; }
      section, .hero-left, #katalog, #galeri { padding: 4rem 1.5rem; }
      .galeri-item { flex: 0 0 calc(50% - .5rem); }
      .testi-card { flex: 0 0 calc(100% - 1.5rem); }
      .about-grid { grid-template-columns: 1fr; gap: 2rem; }
    }
  </style>
</head>
<body>

<nav>
  <a class="logo" href="/"><div class="logo-badge">OU</div> Beauty Bar</a>
  <div class="nav-links">
    <a href="#katalog">Katalog</a>
    @php $adaGaleri = $testimonials->filter(fn($t) => !empty($t->foto_hasil))->isNotEmpty(); @endphp
    @if($adaGaleri)<a href="#galeri">Galeri</a>@endif
    <a href="#testimoni">Testimoni</a>
    <a href="#about">About</a>
    @auth
      <a href="{{ route('dashboard') }}" class="btn btn-outline">Dashboard</a>
      @if(auth()->user()->is_admin)
        <a href="{{ route('admin.index') }}" class="btn btn-olive">Admin</a>
      @endif
    @else
      <a href="{{ route('login') }}">Login</a>
      <a href="{{ route('register') }}" class="btn btn-olive">Daftar</a>
    @endauth
  </div>
</nav>

@if(session('success'))
  <div class="alert alert-success">✅ {{ session('success') }}</div>
@endif

<!-- HERO -->
<div class="hero">
  <div class="hero-left">
    <p class="hero-eyebrow">Nail Art Studio · Bandung</p>
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
  </div>
  <div class="hero-right">
    <div class="hero-img-cell"><div class="nail-shape"></div><span class="hero-tag">3D Art</span></div>
    <div class="hero-img-cell"><div class="nail-shape"></div><span class="hero-tag">Gel</span></div>
    <div class="hero-img-cell"><div class="nail-shape"></div><span class="hero-tag">Extension</span></div>
    <div class="hero-img-cell"><div class="nail-shape"></div><span class="hero-tag">Stamping</span></div>
  </div>
</div>

<!-- KATALOG -->
<section id="katalog">
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
            <img src="{{ asset('storage/' . $design->gambar) }}" alt="{{ $design->nama }}"/>
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
                  Rp {{ number_format($design->harga_min, 0, ',', '.') }} – Rp {{ number_format($design->harga_max, 0, ',', '.') }}
                @else
                  Rp {{ number_format($design->harga, 0, ',', '.') }}
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

<!-- GALERI HASIL -->
@php $galeriItems = $testimonials->filter(fn($t) => !empty($t->foto_hasil)); @endphp
@if($galeriItems->isNotEmpty())
<section id="galeri">
  <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:1.5rem">
    <div>
      <span class="section-label">Hasil Karya</span>
      <h2 style="margin-bottom:0">Inspirasi <em>dari Pelanggan Kami</em></h2>
    </div>
    <div class="galeri-nav" style="margin-bottom:0">
      <button class="slider-btn" onclick="slideGaleri(-1)">←</button>
      <button class="slider-btn" onclick="slideGaleri(1)">→</button>
    </div>
  </div>
  <div class="galeri-track-wrap">
    <div class="galeri-track" id="galeriTrack">
      @foreach($galeriItems as $testi)
        @foreach($testi->foto_hasil as $foto)
          <div class="galeri-item">
            <img src="{{ asset('storage/' . $foto) }}" alt="Hasil nail art"/>
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

<!-- TESTIMONI -->
<section id="testimoni">
  <span class="section-label">Testimoni</span>
  <h2>Kata Mereka <em>tentang Kami</em></h2>
  <div class="testi-track-wrap">
    <div class="testi-track" id="testiTrack">
      @forelse($testimonials as $testi)
        <div class="testi-card">
          <div class="testi-rating">
            @for($i = 0; $i < $testi->rating; $i++)<span>★</span>@endfor
          </div>
          <p class="testi-isi">"{{ $testi->isi }}"</p>
          <p class="testi-nama">— {{ $testi->user->name }}</p>
          @if(!empty($testi->foto_hasil))
            <div class="testi-foto">
              @foreach($testi->foto_hasil as $foto)
                <img src="{{ asset('storage/' . $foto) }}" alt="Foto" onclick="window.open(this.src)"/>
              @endforeach
            </div>
          @endif
        </div>
      @empty
        <div class="testi-card">
          <p style="color:rgba(255,255,255,.82);font-size:.9rem">Belum ada testimoni.</p>
        </div>
      @endforelse
    </div>
  </div>
  <div class="testi-nav">
    <button class="testi-btn" onclick="slideTesti(-1)">←</button>
    <button class="testi-btn" onclick="slideTesti(1)">→</button>
  </div>
</section>

<!-- ABOUT -->
<section id="about">
  <div class="about-grid">
    <div class="about-text">
      <span class="section-label">Tentang Kami</span>
      <h2>Studio <em>Nail Art</em><br>Terpercaya</h2>
      <p>OU Beauty Bar hadir untuk memberikan pengalaman nail art terbaik di Bandung. Kami menggunakan bahan-bahan berkualitas tinggi yang aman untuk kuku dan kulit kamu.</p>
      <div class="about-info">
        <span>📅 Senin – Minggu</span>
        <span>🕘 09.00 – 17.00</span>
        <span>📍 Jl. Kalimantan No 2, Bandung</span>
        <span>📸 @ou.beautybar</span>
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
</footer>

<script>
let katalogIdx = 0;
function slideKatalog(dir) {
  const track = document.getElementById('designsTrack');
  const cards = track.children;
  if (!cards.length) return;
  const cardW = cards[0].offsetWidth + 19;
  const maxIdx = Math.max(0, cards.length - 3);
  katalogIdx = Math.min(Math.max(katalogIdx + dir, 0), maxIdx);
  track.style.transform = `translateX(-${katalogIdx * cardW}px)`;
}

let galeriIdx = 0;
function slideGaleri(dir) {
  const track = document.getElementById('galeriTrack');
  if (!track) return;
  const cards = track.children;
  if (!cards.length) return;
  const cardW = cards[0].offsetWidth + 16;
  const maxIdx = Math.max(0, cards.length - 4);
  galeriIdx = Math.min(Math.max(galeriIdx + dir, 0), maxIdx);
  track.style.transform = `translateX(-${galeriIdx * cardW}px)`;
}

let testiIdx = 0;
function slideTesti(dir) {
  const track = document.getElementById('testiTrack');
  const cards = track.children;
  if (!cards.length) return;
  const cardW = cards[0].offsetWidth + 24;
  const maxIdx = Math.max(0, cards.length - 4);
  testiIdx = Math.min(Math.max(testiIdx + dir, 0), maxIdx);
  track.style.transform = `translateX(-${testiIdx * cardW}px)`;
}
</script>
</body>
</html>