<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard — OU Beauty Bar</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root { --olive:#5C6B3A; --olive-light:#7A8C4E; --olive-pale:#E8EDD8; --lilac:#C4B5D4; --lilac-deep:#9B87B0; --lilac-pale:#F0EBF7; --cream:#FAF8F5; --dark:#2C2C2C; --gray:#6B6B6B; }
    body { font-family: 'Jost', sans-serif; background: var(--cream); color: var(--dark); }
    nav { position: sticky; top: 0; z-index: 100; display: flex; justify-content: space-between; align-items: center; padding: 1.2rem 4rem; background: rgba(250,248,245,.96); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(92,107,58,.12); }
    .logo { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 600; text-decoration: none; color: var(--olive); display: flex; align-items: center; gap: .5rem; }
    .logo-badge { width: 32px; height: 32px; background: var(--olive); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--lilac); font-size: .72rem; font-weight: 700; }
    .nav-right { display: flex; gap: 1.5rem; align-items: center; font-size: .85rem; }
    .nav-right a { text-decoration: none; color: var(--dark); opacity: .65; transition: opacity .2s; }
    .nav-right a:hover { opacity: 1; color: var(--olive); }
    .logout-form button { background: none; border: none; font-size: .85rem; color: var(--dark); opacity: .65; cursor: pointer; font-family: inherit; transition: opacity .2s; }
    .logout-form button:hover { opacity: 1; color: var(--olive); }
    .btn { display: inline-block; padding: .55rem 1.4rem; font-size: .78rem; letter-spacing: .08em; text-transform: uppercase; text-decoration: none; border: none; cursor: pointer; font-family: 'Jost', sans-serif; transition: all .2s; }
    .btn-olive { background: var(--olive); color: white; }
    .btn-olive:hover { background: var(--olive-light); }
    .btn-lilac { background: var(--lilac-deep); color: white; }
    .btn-lilac:hover { background: var(--olive); }
    .btn-sm { padding: .35rem .9rem; font-size: .72rem; }

    .container { max-width: 1000px; margin: 0 auto; padding: 3rem 2rem; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 400; margin-bottom: .3rem; }
    .page-title em { font-style: italic; color: var(--olive); }
    .page-sub { font-size: .88rem; color: var(--gray); margin-bottom: 2rem; }
    .alert { padding: .9rem 1.2rem; font-size: .85rem; margin-bottom: 1.5rem; border-left: 4px solid var(--olive); background: var(--olive-pale); color: var(--olive); }

    .card { background: white; border: 1px solid rgba(92,107,58,.12); margin-bottom: 2.5rem; overflow: hidden; }
    .card-header { padding: 1.2rem 1.5rem; border-bottom: 1px solid rgba(92,107,58,.1); display: flex; justify-content: space-between; align-items: center; background: var(--olive-pale); }
    .card-title { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 400; }
    .card-title em { font-style: italic; color: var(--olive); }

    table { width: 100%; border-collapse: collapse; font-size: .84rem; }
    th { text-align: left; padding: .8rem 1.2rem; font-size: .68rem; letter-spacing: .1em; text-transform: uppercase; color: var(--gray); border-bottom: 1px solid rgba(92,107,58,.1); }
    td { padding: .9rem 1.2rem; border-bottom: 1px solid rgba(92,107,58,.07); vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: var(--olive-pale); }

    .badge { font-size: .68rem; letter-spacing: .06em; text-transform: uppercase; padding: .3rem .8rem; border-radius: 20px; display: inline-block; }
    .badge-pending { background: #fff3e0; color: #e65100; }
    .badge-konfirmasi { background: var(--lilac-pale); color: var(--lilac-deep); }
    .badge-selesai { background: var(--olive-pale); color: var(--olive); }

    /* TIPE ORDER BADGE */
    .tipe-badge { font-size: .65rem; letter-spacing: .05em; text-transform: uppercase; padding: .2rem .55rem; border-radius: 3px; display: inline-block; margin-bottom: .3rem; }
    .tipe-nail-art { background: var(--lilac-pale); color: var(--lilac-deep); }
    .tipe-press-on { background: #e8f5e9; color: #2e7d32; }

    /* DESAIN CELL */
    .design-cell { display: flex; align-items: center; gap: .8rem; }
    .design-thumb { width: 44px; height: 44px; object-fit: cover; border-radius: 3px; border: 1px solid rgba(92,107,58,.15); flex-shrink: 0; background: var(--lilac-pale); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; overflow: hidden; }
    .design-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .design-info { display: flex; flex-direction: column; gap: .15rem; }
    .design-nama { font-weight: 500; font-size: .84rem; line-height: 1.3; }
    .design-sub { font-size: .72rem; color: var(--gray); }

    /* FOTO THUMBNAILS */
    .foto-group { display: flex; gap: .3rem; flex-wrap: wrap; }
    .foto-thumb { width: 36px; height: 36px; object-fit: cover; border-radius: 3px; cursor: pointer; border: 1px solid rgba(92,107,58,.2); transition: opacity .2s; }
    .foto-thumb:hover { opacity: .8; }
    .foto-label { font-size: .62rem; color: var(--gray); margin-bottom: .2rem; }

    .empty-state { text-align: center; padding: 2.5rem; color: var(--gray); font-size: .9rem; }

    /* TESTI */
    .testi-section { background: var(--lilac-pale); padding: 2rem; border: 1px solid rgba(155,135,176,.2); }
    .section-label { display: flex; align-items: center; gap: .6rem; font-size: .7rem; letter-spacing: .2em; text-transform: uppercase; color: var(--olive); margin-bottom: 1rem; }
    .form-group { margin-bottom: 1.2rem; }
    label { display: block; font-size: .72rem; letter-spacing: .1em; text-transform: uppercase; color: var(--gray); margin-bottom: .4rem; }
    input, select, textarea { width: 100%; background: white; border: 1px solid rgba(92,107,58,.2); color: var(--dark); padding: .75rem 1rem; font-family: 'Jost', sans-serif; font-size: .88rem; outline: none; transition: border-color .2s; }
    input:focus, select:focus, textarea:focus { border-color: var(--olive); }
    textarea { resize: vertical; min-height: 80px; }
    .is-invalid { border-color: #e53935 !important; }
    .invalid-feedback { font-size: .75rem; color: #e53935; margin-top: .25rem; display: block; }
    .star-rating { display: flex; flex-direction: row-reverse; gap: .4rem; }
    .star-rating input { display: none; }
    .star-rating label { font-size: 1.6rem; cursor: pointer; color: #ddd; transition: color .2s; text-transform: none; letter-spacing: 0; }
    .star-rating input:checked ~ label, .star-rating label:hover, .star-rating label:hover ~ label { color: var(--olive); }

    @media(max-width:768px) {
      nav { padding: 1rem 1.5rem; }
      .container { padding: 2rem 1.2rem; }
      table { font-size: .78rem; }
      th, td { padding: .6rem .8rem; }
      .design-thumb { display: none; }
    }
  </style>
</head>
<body>

<nav>
  <a class="logo" href="/">
    <div class="logo-badge">OU</div>
    Beauty Bar
  </a>
  <div class="nav-right">
    <a href="/">Beranda</a>
    <span style="color:var(--gray)">{{ auth()->user()->name }}</span>
    <form class="logout-form" action="{{ route('logout') }}" method="POST">
      @csrf <button type="submit">Logout</button>
    </form>
  </div>
</nav>

<div class="container">
  <h1 class="page-title">Halo, <em>{{ auth()->user()->name }}</em> 👋</h1>
  <p class="page-sub">Kelola appointment dan riwayat kunjunganmu di sini.</p>

  @if(session('success'))
    <div class="alert">✅ {{ session('success') }}</div>
  @endif

  <!-- RIWAYAT ORDER -->
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Riwayat <em>Order</em></h2>
      <a href="/" class="btn btn-olive btn-sm">+ Booking Baru</a>
    </div>

    @if($appointments->isEmpty())
      <p class="empty-state">Belum ada order. Yuk booking sekarang! 💅</p>
    @else
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Desain</th>
            <th>Info</th>
            <th>Jadwal</th>
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
            $gambar     = $appt->design && $appt->design->gambar
                            ? asset('storage/' . $appt->design->gambar)
                            : null;

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
          <tr>
            <td>{{ $i + 1 }}</td>

            {{-- DESAIN --}}
            <td>
              <div class="design-cell">
                <div class="design-thumb">
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
              <span style="font-size:.75rem;color:var(--gray)">{{ $appt->bentuk_kuku ?? '—' }}</span>
            </td>

            {{-- JADWAL --}}
            <td>
              @if($isNailArt && $appt->tanggal)
                <span style="font-size:.82rem">{{ \Carbon\Carbon::parse($appt->tanggal)->format('d M Y') }}</span><br>
                <span style="font-size:.75rem;color:var(--gray)">{{ $appt->jam }}</span>
              @else
                <span style="font-size:.78rem;color:var(--gray)">Dikirim kurir</span>
              @endif
            </td>


            {{-- STATUS --}}
            <td>
              <span class="badge badge-{{ strtolower($appt->status) }}">{{ $appt->status }}</span>
            </td>

            {{-- AKSI --}}
            <td>
              <div style="display:flex;flex-direction:column;gap:.4rem">
                @if($appt->status === 'Pending')
                  <form action="{{ route('booking.destroy', $appt->id) }}" method="POST"
                        onsubmit="return confirm('Batalkan order ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:none;border:1px solid rgba(92,107,58,.3);color:var(--olive);cursor:pointer;font-family:inherit;padding:.35rem .8rem;font-size:.75rem;border-radius:4px;width:100%">
                      Batalkan
                    </button>
                  </form>
                @endif
                <a href="{{ $waUrl }}" target="_blank"
                   style="display:block;text-align:center;background:#25D366;color:white;padding:.35rem .8rem;font-size:.75rem;border-radius:4px;text-decoration:none;transition:background .2s"
                   onmouseover="this.style.background='#1da851'"
                   onmouseout="this.style.background='#25D366'">
                  💬 WhatsApp Admin
                </a>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>

  <!-- TESTIMONI -->
  <div class="testi-section">
    <p class="section-label">✦ Tulis Testimoni</p>
    <form action="{{ route('testimonial.store') }}" method="POST">
      @csrf
      <div class="form-group">
        <label>Rating</label>
        <div class="star-rating">
          @for($i = 5; $i >= 1; $i--)
            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}"
                   {{ old('rating') == $i ? 'checked' : '' }}/>
            <label for="star{{ $i }}">★</label>
          @endfor
        </div>
        @error('rating') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>
      <div class="form-group">
        <label>Ceritakan Pengalamanmu</label>
        <textarea name="isi" class="{{ $errors->has('isi') ? 'is-invalid' : '' }}"
                  placeholder="Bagaimana pengalaman kamu di OU Beauty Bar?">{{ old('isi') }}</textarea>
        @error('isi') <span class="invalid-feedback">{{ $message }}</span> @enderror
      </div>
      <button type="submit" class="btn btn-lilac">Kirim Testimoni</button>
    </form>
  </div>
</div>

</body>
</html>