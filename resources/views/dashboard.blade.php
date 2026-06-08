<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard — OU Beauty Bar</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --olive:#5C6B3A; --olive-light:#7A8C4E; --olive-pale:#E8EDD8;
      --lilac:#C4B5D4; --lilac-deep:#9B87B0; --lilac-pale:#F0EBF7;
      --cream:#FAF8F5; --dark:#2C2C2C; --gray:#6B6B6B;
      --white:#FFFFFF;
      --wa:#25D366; --wa-dark:#1da851;
    }

    body { font-family: 'Jost', sans-serif; background: var(--cream); color: var(--dark); }

    /* ── NAV ── */
    nav {
      position: sticky; top: 0; z-index: 100;
      display: flex; justify-content: space-between; align-items: center;
      padding: 1.1rem 3rem;
      background: rgba(250,248,245,.97); backdrop-filter: blur(14px);
      border-bottom: 1px solid rgba(92,107,58,.12);
    }
    .logo { font-family:'Playfair Display',serif; font-size:1.35rem; font-weight:600; text-decoration:none; color:var(--olive); display:flex; align-items:center; gap:.5rem; }
    .logo-badge { width:30px; height:30px; background:var(--olive); border-radius:50%; display:flex; align-items:center; justify-content:center; color:var(--lilac); font-size:.68rem; font-weight:700; }
    .nav-right { display:flex; gap:1.4rem; align-items:center; font-size:.84rem; }
    .nav-right a { text-decoration:none; color:var(--dark); opacity:.6; transition:opacity .2s; }
    .nav-right a:hover { opacity:1; color:var(--olive); }
    .nav-user { display:flex; align-items:center; gap:.5rem; }
    .nav-avatar { width:28px; height:28px; border-radius:50%; background:var(--lilac-pale); border:1.5px solid var(--lilac); display:flex; align-items:center; justify-content:center; font-size:.62rem; font-weight:700; color:var(--lilac-deep); text-transform:uppercase; }
    .logout-form button { background:none; border:none; font-size:.84rem; color:var(--dark); opacity:.6; cursor:pointer; font-family:inherit; transition:opacity .2s; }
    .logout-form button:hover { opacity:1; color:#e53935; }

    /* ── BUTTONS ── */
    .btn { display:inline-block; padding:.55rem 1.4rem; font-size:.75rem; letter-spacing:.08em; text-transform:uppercase; text-decoration:none; border:none; cursor:pointer; font-family:'Jost',sans-serif; transition:all .2s; border-radius:3px; }
    .btn-olive { background:var(--olive); color:white; }
    .btn-olive:hover { background:var(--olive-light); transform:translateY(-1px); }
    .btn-lilac { background:var(--lilac-deep); color:white; }
    .btn-lilac:hover { background:var(--olive); transform:translateY(-1px); }
    .btn-sm { padding:.32rem .85rem; font-size:.7rem; }
    .btn-ghost { background:none; border:1px solid rgba(92,107,58,.3); color:var(--olive); font-size:.72rem; padding:.3rem .75rem; border-radius:4px; cursor:pointer; font-family:inherit; transition:all .2s; }
    .btn-ghost:hover { background:var(--olive-pale); border-color:var(--olive); }

    /* ── LAYOUT ── */
    .container { max-width:1040px; margin:0 auto; padding:2.5rem 2rem; }
    .page-header { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:2rem; flex-wrap:wrap; gap:1rem; }
    .page-title { font-family:'Playfair Display',serif; font-size:2rem; font-weight:400; line-height:1.2; }
    .page-title em { font-style:italic; color:var(--olive); }
    .page-sub { font-size:.85rem; color:var(--gray); margin-top:.3rem; }

    /* ── ALERT ── */
    .alert { padding:.85rem 1.1rem; font-size:.83rem; margin-bottom:1.5rem; border-left:3px solid var(--olive); background:var(--olive-pale); color:var(--olive); border-radius:0 4px 4px 0; display:flex; align-items:center; gap:.5rem; animation:slideIn .3s ease; }
    @keyframes slideIn { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:translateY(0)} }

    /* ── STATS STRIP ── */
    .stats-strip { display:grid; grid-template-columns:repeat(auto-fit,minmax(130px,1fr)); gap:1rem; margin-bottom:2rem; }
    .stat-card { background:white; border:1px solid rgba(92,107,58,.12); border-radius:6px; padding:1rem 1.2rem; display:flex; flex-direction:column; gap:.2rem; transition:transform .2s; }
    .stat-card:hover { transform:translateY(-2px); }
    .stat-num { font-family:'Playfair Display',serif; font-size:1.8rem; font-weight:600; color:var(--olive); line-height:1; }
    .stat-lbl { font-size:.68rem; letter-spacing:.1em; text-transform:uppercase; color:var(--gray); }
    .stat-sub { font-size:.72rem; color:var(--lilac-deep); margin-top:.1rem; }

    /* ── FILTER BAR ── */
    .filter-bar { display:flex; align-items:center; gap:.8rem; margin-bottom:1rem; flex-wrap:wrap; }
    .filter-bar input[type=text] { flex:1; min-width:180px; padding:.5rem .9rem; border:1px solid rgba(92,107,58,.2); border-radius:4px; font-family:'Jost',sans-serif; font-size:.83rem; background:white; color:var(--dark); outline:none; transition:border-color .2s; }
    .filter-bar input[type=text]:focus { border-color:var(--olive); }
    .filter-bar input::placeholder { color:var(--gray); }
    .filter-pills { display:flex; gap:.4rem; flex-wrap:wrap; }
    .pill { padding:.3rem .8rem; border-radius:20px; border:1px solid rgba(92,107,58,.25); background:white; color:var(--gray); font-size:.72rem; cursor:pointer; transition:all .18s; white-space:nowrap; }
    .pill:hover, .pill.active { background:var(--olive); color:white; border-color:var(--olive); }
    .pill.active-konfirmasi { background:var(--lilac-deep); color:white; border-color:var(--lilac-deep); }
    .pill.active-selesai { background:var(--olive); color:white; border-color:var(--olive); }
    .pill.active-pending { background:#e65100; color:white; border-color:#e65100; }

    /* ── CARD ── */
    .card { background:white; border:1px solid rgba(92,107,58,.12); border-radius:8px; overflow:hidden; margin-bottom:2rem; }
    .card-header { padding:1.1rem 1.4rem; border-bottom:1px solid rgba(92,107,58,.1); display:flex; justify-content:space-between; align-items:center; background:var(--olive-pale); }
    .card-title { font-family:'Playfair Display',serif; font-size:1.3rem; font-weight:400; }
    .card-title em { font-style:italic; color:var(--olive); }

    /* ── TABLE ── */
    .table-wrap { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; font-size:.82rem; }
    th { text-align:left; padding:.75rem 1.1rem; font-size:.65rem; letter-spacing:.1em; text-transform:uppercase; color:var(--gray); border-bottom:1px solid rgba(92,107,58,.12); background:rgba(232,237,216,.25); white-space:nowrap; }
    td { padding:.85rem 1.1rem; border-bottom:1px solid rgba(92,107,58,.07); vertical-align:middle; }
    tr:last-child td { border-bottom:none; }
    tr:hover td { background:rgba(232,237,216,.35); transition:background .15s; }

    /* ── BADGES ── */
    .badge { font-size:.64rem; letter-spacing:.06em; text-transform:uppercase; padding:.28rem .75rem; border-radius:20px; display:inline-block; font-weight:500; }
    .badge-pending { background:#fff3e0; color:#e65100; }
    .badge-konfirmasi { background:var(--lilac-pale); color:var(--lilac-deep); }
    .badge-selesai { background:var(--olive-pale); color:var(--olive); }
    .badge-dibatalkan { background:#ffebee; color:#c62828; }

    .tipe-badge { font-size:.62rem; letter-spacing:.04em; text-transform:uppercase; padding:.18rem .5rem; border-radius:3px; display:inline-block; margin-bottom:.25rem; font-weight:500; }
    .tipe-nail-art { background:var(--lilac-pale); color:var(--lilac-deep); }
    .tipe-press-on { background:#e8f5e9; color:#2e7d32; }

    /* ── DESIGN CELL ── */
    .design-cell { display:flex; align-items:center; gap:.75rem; }
    .design-thumb { width:44px; height:44px; object-fit:cover; border-radius:4px; border:1px solid rgba(92,107,58,.15); flex-shrink:0; background:var(--lilac-pale); display:flex; align-items:center; justify-content:center; font-size:1rem; overflow:hidden; transition:transform .2s; }
    .design-thumb:hover { transform:scale(1.06); }
    .design-thumb img { width:100%; height:100%; object-fit:cover; }
    .design-info { display:flex; flex-direction:column; gap:.12rem; }
    .design-nama { font-weight:500; font-size:.82rem; line-height:1.3; }
    .design-sub { font-size:.7rem; color:var(--gray); }

    /* ── COUNTDOWN ── */
    .countdown { display:inline-block; font-size:.68rem; padding:.18rem .55rem; border-radius:3px; margin-top:.2rem; }
    .countdown.upcoming { background:#e3f2fd; color:#1565c0; }
    .countdown.today { background:#fff8e1; color:#f57f17; }
    .countdown.past { background:#f5f5f5; color:#9e9e9e; }

    /* ── AKSI ── */
    .aksi-group { display:flex; flex-direction:column; gap:.35rem; min-width:100px; }
    .wa-btn { display:block; text-align:center; background:var(--wa); color:white; padding:.32rem .75rem; font-size:.72rem; border-radius:4px; text-decoration:none; transition:background .2s, transform .15s; white-space:nowrap; }
    .wa-btn:hover { background:var(--wa-dark); transform:translateY(-1px); }

    /* ── EMPTY STATE ── */
    .empty-state { text-align:center; padding:3rem 2rem; color:var(--gray); }
    .empty-state-icon { font-size:2.5rem; margin-bottom:.75rem; }
    .empty-state p { font-size:.88rem; margin-bottom:1rem; }

    /* ── NO RESULTS ── */
    #no-results { display:none; text-align:center; padding:2rem; color:var(--gray); font-size:.88rem; }

    /* ── TESTIMONI ── */
    .testi-section { background:var(--lilac-pale); padding:2rem; border-radius:8px; border:1px solid rgba(155,135,176,.2); }
    .section-label { display:flex; align-items:center; gap:.5rem; font-size:.68rem; letter-spacing:.2em; text-transform:uppercase; color:var(--olive); margin-bottom:1.2rem; font-weight:500; }
    .form-group { margin-bottom:1.1rem; }
    label { display:block; font-size:.7rem; letter-spacing:.1em; text-transform:uppercase; color:var(--gray); margin-bottom:.35rem; }
    input[type=text], select, textarea {
      width:100%; background:white; border:1px solid rgba(92,107,58,.2); color:var(--dark);
      padding:.7rem 1rem; font-family:'Jost',sans-serif; font-size:.86rem; outline:none;
      transition:border-color .2s; border-radius:3px;
    }
    input[type=text]:focus, select:focus, textarea:focus { border-color:var(--olive); }
    textarea { resize:vertical; min-height:80px; }
    .is-invalid { border-color:#e53935 !important; }
    .invalid-feedback { font-size:.73rem; color:#e53935; margin-top:.22rem; display:block; }

    /* ── STAR RATING ── */
    .star-rating { display:flex; flex-direction:row-reverse; gap:.35rem; margin-bottom:.3rem; }
    .star-rating input { display:none; }
    .star-rating label { font-size:1.8rem; cursor:pointer; color:#ddd; transition:color .15s, transform .15s; text-transform:none; letter-spacing:0; }
    .star-rating label:hover { transform:scale(1.15); }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label { color:var(--olive); }

    /* ── UPLOAD AREA ── */
    .upload-area {
      border:2px dashed rgba(155,135,176,.4); padding:1.3rem; text-align:center;
      background:white; cursor:pointer; border-radius:6px; transition:border-color .2s, background .2s;
    }
    .upload-area:hover { border-color:var(--lilac-deep); background:var(--lilac-pale); }
    .upload-area .upload-icon { font-size:1.8rem; display:block; margin-bottom:.4rem; }
    .upload-area p { font-size:.78rem; color:var(--gray); margin:.15rem 0 0; }
    .upload-area .upload-hint { font-size:.7rem; color:var(--lilac-deep); margin-top:.2rem; }
    #preview-testi-foto { display:flex; flex-wrap:wrap; gap:.4rem; margin-top:.7rem; justify-content:center; }
    .preview-img-wrap { position:relative; width:64px; height:64px; }
    .preview-img-wrap img { width:64px; height:64px; object-fit:cover; border-radius:4px; border:1px solid rgba(92,107,58,.2); }
    .preview-remove { position:absolute; top:-5px; right:-5px; width:16px; height:16px; border-radius:50%; background:#e53935; color:white; border:none; cursor:pointer; font-size:.65rem; display:flex; align-items:center; justify-content:center; line-height:1; }

    /* ── LIGHTBOX ── */
    .lightbox { display:none; position:fixed; inset:0; background:rgba(0,0,0,.85); z-index:9999; align-items:center; justify-content:center; }
    .lightbox.open { display:flex; }
    .lightbox img { max-width:90vw; max-height:90vh; object-fit:contain; border-radius:6px; }
    .lightbox-close { position:absolute; top:1rem; right:1.5rem; color:white; font-size:2rem; cursor:pointer; line-height:1; }

    /* ── RESPONSIVE ── */
    @media(max-width:768px) {
      nav { padding:.9rem 1.2rem; }
      .container { padding:1.5rem 1rem; }
      .page-title { font-size:1.6rem; }
      .stats-strip { grid-template-columns:repeat(2,1fr); }
      table { font-size:.76rem; }
      th, td { padding:.55rem .7rem; }
      .design-thumb { display:none; }
      .aksi-group { min-width:80px; }
    }
    @media(max-width:480px) {
      .stats-strip { grid-template-columns:1fr 1fr; }
      th:nth-child(4), td:nth-child(4) { display:none; }
    }
  </style>
</head>
<body>

{{-- LIGHTBOX --}}
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
  <span class="lightbox-close" onclick="closeLightbox()">×</span>
  <img id="lightbox-img" src="" alt=""/>
</div>

{{-- NAV --}}
<nav>
  <a class="logo" href="/">
    <div class="logo-badge">OU</div>
    Beauty Bar
  </a>
  <div class="nav-right">
    <a href="/">Beranda</a>
    <a href="/promo">Promo</a>
    <a href="/guide">Guide</a>
    <div class="nav-user">
      <div class="nav-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
      <span style="color:var(--gray)">{{ auth()->user()->name }}</span>
    </div>
    <form class="logout-form" action="{{ route('logout') }}" method="POST">
      @csrf <button type="submit">Logout</button>
    </form>
  </div>
</nav>

<div class="container">

  {{-- HEADER --}}
  <div class="page-header">
    <div>
      <h1 class="page-title">Halo, <em>{{ auth()->user()->name }}</em> 👋</h1>
      <p class="page-sub">Kelola appointment dan riwayat kunjunganmu di sini.</p>
    </div>
    <a href="/" class="btn btn-olive">+ Booking Baru</a>
  </div>

  {{-- ALERT --}}
  @if(session('success'))
    <div class="alert">✅ {{ session('success') }}</div>
  @endif

  {{-- STATS STRIP --}}
  @php
    $total      = $appointments->count();
    $pending    = $appointments->where('status','Pending')->count();
    $konfirmasi = $appointments->where('status','Konfirmasi')->count();
    $selesai    = $appointments->where('status','Selesai')->count();
    $totalBayar = $appointments->where('status','Selesai')->sum('total_harga');
  @endphp
  <div class="stats-strip">
    <div class="stat-card">
      <span class="stat-lbl">Total Order</span>
      <span class="stat-num">{{ $total }}</span>
      <span class="stat-sub">semua waktu</span>
    </div>
    <div class="stat-card">
      <span class="stat-lbl">Menunggu</span>
      <span class="stat-num">{{ $pending }}</span>
      <span class="stat-sub">perlu konfirmasi</span>
    </div>
    <div class="stat-card">
      <span class="stat-lbl">Dikonfirmasi</span>
      <span class="stat-num">{{ $konfirmasi }}</span>
      <span class="stat-sub">segera datang</span>
    </div>
    <div class="stat-card">
      <span class="stat-lbl">Selesai</span>
      <span class="stat-num">{{ $selesai }}</span>
      <span class="stat-sub">Rp {{ number_format($totalBayar,0,',','.') }}</span>
    </div>
  </div>

  {{-- RIWAYAT ORDER --}}
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Riwayat <em>Order</em></h2>
    </div>

    @if($appointments->isEmpty())
      <div class="empty-state">
        <div class="empty-state-icon">💅</div>
        <p>Belum ada order. Yuk booking sekarang!</p>
        <a href="/" class="btn btn-olive">Booking Sekarang</a>
      </div>
    @else
      {{-- FILTER BAR --}}
      <div style="padding:1rem 1.2rem; border-bottom:1px solid rgba(92,107,58,.1); background:rgba(250,248,245,.6)">
        <div class="filter-bar">
          <input type="text" id="search-input" placeholder="🔍 Cari nama desain..." oninput="filterTable()"/>
          <div class="filter-pills">
            <span class="pill active" data-status="semua" onclick="setStatus(this,'semua')">Semua</span>
            <span class="pill" data-status="pending" onclick="setStatus(this,'pending')">Pending</span>
            <span class="pill" data-status="konfirmasi" onclick="setStatus(this,'konfirmasi')">Konfirmasi</span>
            <span class="pill" data-status="selesai" onclick="setStatus(this,'selesai')">Selesai</span>
          </div>
        </div>
      </div>

      <div class="table-wrap">
        <table id="order-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Desain</th>
              <th>Info Kuku</th>
              <th>Jadwal</th>
              <th>Total</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($appointments as $i => $appt)
            @php
              $isNailArt  = $appt->tipe_order !== 'press_on';
              $namaDesain = $appt->design ? $appt->design->nama : '—';
              $katDesain  = $appt->design ? $appt->design->kategori : '';
              $customDesign = false;
              if (!empty($appt->pilihan_jari)) {
                $designIds = collect($appt->pilihan_jari)->flatten()->unique();
                $customDesign = $designIds->count() > 1;
              }
              if ($customDesign) { $namaDesain = 'Mix Design'; $katDesain = ''; }
              $gambar = $appt->design && $appt->design->gambar
                          ? asset('storage/' . $appt->design->gambar) : null;

              // Countdown
              $countdown = '';
              $countdownClass = '';
              if ($isNailArt && $appt->tanggal && $appt->status !== 'Selesai') {
                $diff = now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($appt->tanggal)->startOfDay(), false);
                if ($diff > 0) { $countdown = "dalam {$diff} hari"; $countdownClass = 'upcoming'; }
                elseif ($diff === 0) { $countdown = 'hari ini!'; $countdownClass = 'today'; }
                else { $countdown = abs($diff) . ' hari lalu'; $countdownClass = 'past'; }
              }

              // WA message
              $tipeLbl = $isNailArt ? 'Nail Art' : 'Press On Nail';
              $pesan = 'Halo OU Beauty Bar! 👋' . "\n\n" .
                       'Saya ' . auth()->user()->name . ' ingin konfirmasi order berikut:' . "\n\n" .
                       '📋 *Detail Order*' . "\n" .
                       '• Tipe        : ' . $tipeLbl . "\n" .
                       '• Desain      : ' . $namaDesain . "\n" .
                       '• Panjang Kuku: ' . $appt->panjang_kuku . "\n" .
                       '• Bentuk Kuku : ' . ($appt->bentuk_kuku ?? '—') . "\n" .
                       ($isNailArt
                         ? '• Tanggal     : ' . \Carbon\Carbon::parse($appt->tanggal)->format('d F Y') . "\n" .
                           '• Jam         : ' . $appt->jam . " WIB\n"
                         : '') .
                       '• Metode Bayar: ' . $appt->metode_bayar . "\n" .
                       '• Status      : ' . $appt->status . "\n\n" .
                       'Mohon konfirmasinya, terima kasih! 🙏';
              $waUrl = 'https://wa.me/6282216672840?text=' . urlencode($pesan);
            @endphp
            <tr data-status="{{ strtolower($appt->status) }}" data-nama="{{ strtolower($namaDesain) }}">
              <td style="color:var(--gray);font-size:.78rem">{{ $i + 1 }}</td>

              {{-- DESAIN --}}
              <td>
                <div class="design-cell">
                  <div class="design-thumb" @if($gambar) onclick="openLightbox('{{ $gambar }}')" style="cursor:pointer" @endif>
                    @if($gambar)
                      <img src="{{ $gambar }}" alt="{{ $namaDesain }}"/>
                    @else
                      💅
                    @endif
                  </div>
                  <div class="design-info">
                    <span class="tipe-badge {{ $isNailArt ? 'tipe-nail-art' : 'tipe-press-on' }}">
                      {{ $isNailArt ? '💅 Nail Art' : '📦 Press On' }}
                    </span>
                    <span class="design-nama">{{ $namaDesain }}</span>
                    @if($katDesain)
                      <span class="design-sub">{{ $katDesain }}</span>
                    @endif
                  </div>
                </div>
              </td>

              {{-- INFO KUKU --}}
              <td>
                <span style="font-size:.82rem">{{ $appt->panjang_kuku }}</span><br>
                <span style="font-size:.73rem;color:var(--gray)">{{ $appt->bentuk_kuku ?? '—' }}</span>
              </td>

              {{-- JADWAL --}}
              <td>
                @if($isNailArt && $appt->tanggal)
                  <span style="font-size:.82rem">{{ \Carbon\Carbon::parse($appt->tanggal)->format('d M Y') }}</span><br>
                  <span style="font-size:.73rem;color:var(--gray)">{{ $appt->jam }} WIB</span>
                  @if($countdown)
                    <br><span class="countdown {{ $countdownClass }}">{{ $countdown }}</span>
                  @endif
                @else
                  <span style="font-size:.78rem;color:var(--gray)">📦 Dikirim kurir</span>
                @endif
              </td>

              {{-- TOTAL --}}
              <td>
                @if($appt->total_harga)
                  <span style="font-size:.82rem;font-weight:500;color:var(--lilac-deep)">
                    Rp {{ number_format($appt->total_harga, 0, ',', '.') }}
                  </span><br>
                  @if($isNailArt)
                    <span style="font-size:.7rem;color:var(--olive)">
                      DP: Rp {{ number_format(ceil($appt->total_harga * 0.5), 0, ',', '.') }}
                    </span>
                  @else
                    <span style="font-size:.7rem;color:var(--gray)">Lunas</span>
                  @endif
                @else
                  <span style="color:var(--gray);font-size:.78rem">—</span>
                @endif
              </td>

              {{-- STATUS --}}
              <td>
                <span class="badge badge-{{ strtolower($appt->status) }}">{{ $appt->status }}</span>
              </td>

              {{-- AKSI --}}
              <td>
                <div class="aksi-group">
                  @if($appt->status === 'Pending')
                    <form action="{{ route('booking.destroy', $appt->id) }}" method="POST"
                          onsubmit="return confirm('Batalkan order ini?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn-ghost" style="width:100%">Batalkan</button>
                    </form>
                  @endif
                  <a href="{{ $waUrl }}" target="_blank" class="wa-btn">💬 WA Admin</a>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div id="no-results">
          <p>Tidak ada order yang cocok 🔍</p>
        </div>
      </div>
    @endif
  </div>

  {{-- TESTIMONI --}}
  <div class="testi-section">
    <p class="section-label">✦ Tulis Testimoni</p>
    <form action="{{ route('testimonial.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label>Rating</label>
        <div class="star-rating">
          @for($i = 5; $i >= 1; $i--)
            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}"
                   {{ old('rating') == $i ? 'checked' : '' }}/>
            <label for="star{{ $i }}" title="{{ $i }} bintang">★</label>
          @endfor
        </div>
        @error('rating') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label>Foto Hasil (opsional, bisa lebih dari 1)</label>
        <div class="upload-area" onclick="document.getElementById('foto-testi').click()">
          <input type="file" id="foto-testi" name="foto_testi[]"
                 accept="image/*" multiple style="display:none"
                 onchange="previewTestiFoto(this)"/>
          <span class="upload-icon">📷</span>
          <p>Klik untuk upload foto hasil nail art kamu</p>
          <p class="upload-hint">JPG, PNG · Maks. 2MB per foto</p>
          <div id="preview-testi-foto"></div>
        </div>
      </div>

      <div class="form-group">
        <label>Ceritakan Pengalamanmu</label>
        <textarea name="isi" class="{{ $errors->has('isi') ? 'is-invalid' : '' }}"
                  placeholder="Bagaimana pengalaman kamu di OU Beauty Bar? Ceritakan desain favoritmu, pelayanannya, dll.">{{ old('isi') }}</textarea>
        @error('isi') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>

      <button type="submit" class="btn btn-lilac">Kirim Testimoni ✨</button>
    </form>
  </div>

</div>

{{-- SCRIPTS --}}
<script>
let activeStatus = 'semua';

function setStatus(el, status) {
  activeStatus = status;
  document.querySelectorAll('.pill').forEach(p => {
    p.classList.remove('active','active-pending','active-konfirmasi','active-selesai');
  });
  if (status === 'semua') el.classList.add('active');
  else el.classList.add('active-' + status);
  filterTable();
}

function filterTable() {
  const q = document.getElementById('search-input').value.toLowerCase().trim();
  const rows = document.querySelectorAll('#order-table tbody tr');
  let visible = 0;

  rows.forEach(row => {
    const nama   = row.dataset.nama || '';
    const status = row.dataset.status || '';
    const matchSearch = !q || nama.includes(q);
    const matchStatus = activeStatus === 'semua' || status === activeStatus;
    const show = matchSearch && matchStatus;
    row.style.display = show ? '' : 'none';
    if (show) visible++;
  });

  const noRes = document.getElementById('no-results');
  if (noRes) noRes.style.display = visible === 0 ? 'block' : 'none';
}

function openLightbox(src) {
  document.getElementById('lightbox-img').src = src;
  document.getElementById('lightbox').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeLightbox() {
  document.getElementById('lightbox').classList.remove('open');
  document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if(e.key === 'Escape') closeLightbox(); });

function previewTestiFoto(input) {
  const container = document.getElementById('preview-testi-foto');
  container.innerHTML = '';
  Array.from(input.files).forEach((file, idx) => {
    const reader = new FileReader();
    reader.onload = e => {
      const wrap = document.createElement('div');
      wrap.className = 'preview-img-wrap';
      const img = document.createElement('img');
      img.src = e.target.result;
      img.alt = 'Preview ' + (idx+1);
      wrap.appendChild(img);
      container.appendChild(wrap);
    };
    reader.readAsDataURL(file);
  });
}
</script>
</body>
</html>