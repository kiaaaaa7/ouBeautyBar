<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Appointments — Admin OU Beauty Bar</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

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
      --sidebar-w:   260px;
      --r:           18px;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    body {
      font-family: 'Jost', sans-serif;
      background: var(--bg);
      color: var(--dark);
      display: flex;
      min-height: 100vh;
    }

    /* ── SIDEBAR (identical to dashboard) ── */
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
      position: absolute; inset: 0;
      background: radial-gradient(ellipse 80% 60% at 50% 0%, rgba(196,181,212,.12) 0%, transparent 60%);
      pointer-events: none;
    }

    .sidebar-header {
      padding: 2.2rem 1.8rem 1.6rem;
      border-bottom: 1px solid rgba(255,255,255,.08);
      position: relative; z-index: 1;
    }

    .sidebar-logo {
      font-family: 'Playfair Display', serif;
      font-size: 1.2rem; font-weight: 600;
      display: flex; align-items: center; gap: .9rem;
      text-decoration: none; color: #fff;
    }

    .logo-badge {
      width: 42px; height: 42px;
      background: linear-gradient(135deg, var(--lilac) 0%, var(--lilac-deep) 100%);
      border-radius: 13px;
      display: flex; align-items: center; justify-content: center;
      color: #fff; font-size: .72rem; font-weight: 700; letter-spacing: .06em;
      box-shadow: 0 6px 18px rgba(155,135,176,.5);
      flex-shrink: 0;
    }

    .sidebar-tagline {
      font-size: .63rem; color: rgba(255,255,255,.35);
      letter-spacing: .22em; text-transform: uppercase;
      margin-top: .25rem; padding-left: 3.3rem;
    }

    .sidebar-nav { flex: 1; padding: 1.8rem 1rem; overflow-y: auto; position: relative; z-index: 1; }

    .nav-section-label {
      font-size: .58rem; letter-spacing: .22em; text-transform: uppercase;
      color: rgba(255,255,255,.28); padding: 0 .9rem; margin-bottom: .7rem;
    }

    .sidebar-menu { list-style: none; display: flex; flex-direction: column; gap: .18rem; }

    .sidebar-menu a {
      display: flex; align-items: center; gap: .8rem;
      padding: .78rem 1rem; font-size: .83rem; font-weight: 400;
      text-decoration: none; color: rgba(255,255,255,.55);
      border-radius: 11px; transition: all .28s ease; position: relative;
    }

    .sidebar-menu a .nav-icon { font-size: .95rem; width: 22px; text-align: center; flex-shrink: 0; }

    .sidebar-menu a:hover {
      background: rgba(255,255,255,.09);
      color: rgba(255,255,255,.92);
      transform: translateX(4px);
    }

    .sidebar-menu a.active {
      background: rgba(255,255,255,.13);
      color: #fff; font-weight: 500;
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
      position: relative; z-index: 1;
    }

    .logout-btn {
      display: flex; align-items: center; gap: .75rem;
      background: none; border: none;
      color: rgba(255,255,255,.4); font-size: .8rem; cursor: pointer;
      font-family: 'Jost', sans-serif; padding: .72rem 1rem;
      width: 100%; border-radius: 11px; transition: all .25s;
    }
    .logout-btn:hover { background: rgba(255,255,255,.07); color: rgba(255,255,255,.7); }

    /* ── MAIN ── */
    .main { flex: 1; margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }

    .topbar {
      background: rgba(250,248,245,.9);
      backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid rgba(92,107,58,.09);
      padding: 1.1rem 2.8rem;
      display: flex; align-items: center; justify-content: space-between;
      position: sticky; top: 0; z-index: 50;
    }

    .topbar-greeting { font-size: .82rem; color: var(--gray); font-weight: 300; }
    .topbar-greeting strong { color: var(--dark); font-weight: 500; }
    .topbar-date { font-size: .74rem; color: rgba(107,107,107,.6); }
    .topbar-avatar {
      width: 34px; height: 34px;
      background: linear-gradient(135deg, var(--olive-pale), var(--lilac-pale));
      border-radius: 50%; border: 2px solid rgba(92,107,58,.15);
      display: flex; align-items: center; justify-content: center;
      font-size: .8rem; color: var(--olive); font-weight: 600;
    }

    .content { flex: 1; padding: 2.8rem; }

    /* ── PAGE HEADER ── */
    .page-header { margin-bottom: 2rem; animation: fadeUp .4s ease both; }

    .page-eyebrow {
      font-size: .62rem; letter-spacing: .22em; text-transform: uppercase;
      color: var(--lilac-deep); margin-bottom: .5rem;
      display: flex; align-items: center; gap: .5rem;
    }
    .page-eyebrow::before { content: ''; width: 18px; height: 1px; background: var(--lilac-deep); }

    .page-title {
      font-family: 'Playfair Display', serif;
      font-size: 2.4rem; font-weight: 400; margin-bottom: .4rem;
    }
    .page-title em { font-style: italic; color: var(--olive); }
    .page-sub { font-size: .84rem; color: var(--gray); font-weight: 300; }

    /* ── ALERT ── */
    .alert {
      display: flex; align-items: center; gap: .8rem;
      padding: 1rem 1.5rem; font-size: .84rem; margin-bottom: 1.8rem;
      border-radius: 14px;
      background: linear-gradient(135deg, var(--olive-pale) 0%, #eef1e2 100%);
      border: 1px solid rgba(92,107,58,.2); color: var(--olive);
    }
    .alert-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--olive); flex-shrink: 0; }

    /* ── FILTER ── */
    .filter-section {
      background: #fff;
      border-radius: var(--r);
      border: 1px solid rgba(92,107,58,.07);
      padding: 1.4rem 1.8rem;
      margin-bottom: 1.6rem;
      animation: fadeUp .45s ease .06s both;
    }

    .filter-bar { display: flex; gap: .8rem; flex-wrap: wrap; align-items: center; }

    .filter-bar input,
    .filter-bar select {
      background: var(--bg);
      border: 1.5px solid rgba(92,107,58,.13);
      color: var(--dark);
      padding: .68rem 1.1rem;
      font-family: 'Jost', sans-serif; font-size: .83rem;
      outline: none; border-radius: 10px;
      transition: border-color .2s, box-shadow .2s;
    }
    .filter-bar input { flex: 1; min-width: 220px; }
    .filter-bar input:focus,
    .filter-bar select:focus {
      border-color: var(--olive);
      box-shadow: 0 0 0 3px rgba(92,107,58,.1);
    }
    .filter-bar input::placeholder { color: rgba(107,107,107,.5); }

    .btn-search {
      background: var(--olive); color: #fff; border: none;
      padding: .68rem 1.7rem; cursor: pointer;
      font-family: 'Jost', sans-serif; font-size: .82rem; font-weight: 500;
      border-radius: 10px; letter-spacing: .05em;
      transition: background .22s, transform .15s, box-shadow .22s;
    }
    .btn-search:hover {
      background: var(--olive-light);
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(92,107,58,.25);
    }

    /* ── TABLE CARD ── */
    .table-card {
      background: #fff;
      border-radius: var(--r);
      border: 1px solid rgba(92,107,58,.07);
      overflow: hidden;
      animation: fadeUp .5s ease .12s both;
    }

    .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }

    table { width: 100%; border-collapse: collapse; font-size: .83rem; }

    thead tr {
      background: linear-gradient(135deg, var(--olive-pale) 0%, #eef1e2 100%);
    }

    th {
      text-align: left;
      padding: 1rem 1.2rem;
      font-size: .62rem;
      letter-spacing: .16em;
      text-transform: uppercase;
      color: var(--olive);
      font-weight: 600;
      white-space: nowrap;
    }

    td {
      padding: 1rem 1.2rem;
      border-bottom: 1px solid rgba(92,107,58,.05);
      vertical-align: middle;
      transition: background .2s;
    }

    tbody tr:last-child td { border-bottom: none; }

    tbody tr:nth-child(even) td { background: rgba(242,244,238,.35); }

    tbody tr:hover td {
      background: rgba(232,237,216,.4) !important;
    }

    /* ── CUSTOMER CELL ── */
    .customer-name { font-weight: 500; color: var(--dark); margin-bottom: .14rem; font-size: .85rem; }
    .customer-email { font-size: .73rem; color: var(--gray); }

    /* ── STATUS BADGES ── */
    .badge {
      display: inline-flex; align-items: center; gap: .3rem;
      font-size: .63rem; letter-spacing: .08em; text-transform: uppercase;
      padding: .3rem .9rem; border-radius: 20px; font-weight: 600;
      white-space: nowrap;
    }
    .badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; }

    .badge-pending {
      background: #fff8e6; color: #a06800; border: 1px solid #f0d980;
    }
    .badge-pending::before { background: #a06800; }

    .badge-konfirmasi {
      background: var(--lilac-pale); color: var(--lilac-deep);
      border: 1px solid rgba(196,181,212,.4);
    }
    .badge-konfirmasi::before { background: var(--lilac-deep); }

    .badge-selesai {
      background: var(--olive-pale); color: var(--olive);
      border: 1px solid rgba(92,107,58,.25);
    }
    .badge-selesai::before { background: var(--olive); }

    /* ── PAYMENT BADGE ── */
    .pay-badge {
      display: inline-flex; align-items: center; gap: .3rem;
      font-size: .63rem; letter-spacing: .06em; text-transform: uppercase;
      padding: .26rem .72rem; border-radius: 20px; font-weight: 600;
    }
    .pay-pending  { background: #fff8e6; color: #a06800; border: 1px solid #f0d980; }
    .pay-waiting  { background: #fff3e0; color: #bf6e00; border: 1px solid #ffc947; }
    .pay-paid     { background: #edf7ed; color: #2e7d32; border: 1px solid #a5d6a7; }

    /* ── ACTIONS ── */
    .actions { display: flex; gap: .45rem; align-items: center; flex-wrap: wrap; }

    .btn-detail {
      display: inline-flex; align-items: center; gap: .3rem;
      background: var(--olive-faint);
      border: 1px solid rgba(92,107,58,.18);
      padding: .38rem .9rem; font-size: .73rem;
      cursor: pointer; color: var(--olive);
      border-radius: 8px; font-family: 'Jost', sans-serif; font-weight: 500;
      text-decoration: none; transition: all .22s;
    }
    .btn-detail:hover {
      background: var(--olive); color: #fff; border-color: var(--olive);
      box-shadow: 0 4px 12px rgba(92,107,58,.25);
    }
    .btn-detail:disabled {
      opacity: .4; cursor: not-allowed;
      pointer-events: none;
    }

    select.status-select {
      font-size: .77rem; padding: .38rem .65rem;
      border: 1px solid rgba(92,107,58,.18);
      border-radius: 8px; background: #fff;
      color: var(--dark); font-family: 'Jost', sans-serif;
      cursor: pointer; outline: none; transition: border-color .2s;
    }
    select.status-select:focus { border-color: var(--olive); }

    .btn-del {
      background: none; border: 1px solid rgba(155,135,176,.3);
      padding: .38rem .8rem; font-size: .72rem;
      cursor: pointer; color: var(--lilac-deep);
      border-radius: 8px; font-family: 'Jost', sans-serif; transition: all .22s;
    }
    .btn-del:hover {
      background: var(--lilac-deep); color: #fff; border-color: var(--lilac-deep);
    }

    /* ── FOTO THUMB ── */
    .foto-thumb {
      width: 44px; height: 44px; object-fit: cover;
      border-radius: 9px; cursor: pointer;
      border: 1.5px solid rgba(92,107,58,.13);
      transition: transform .25s, box-shadow .25s; display: block;
    }
    .foto-thumb:hover {
      transform: scale(1.14);
      box-shadow: 0 8px 22px rgba(0,0,0,.15);
    }
    .no-foto { font-size: .8rem; color: #ccc; }

    /* ── NO RECORDS ── */
    .empty-state {
      text-align: center; padding: 4.5rem 2rem; color: var(--gray);
    }
    .empty-icon { font-size: 2.8rem; margin-bottom: 1rem; opacity: .4; display: block; }
    .empty-state p { font-size: .9rem; }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
      :root { --sidebar-w: 0px; }
      .sidebar { display: none; }
      .main { margin-left: 0; }
      .content { padding: 1.5rem; }
      .topbar { padding: 1rem 1.5rem; }
      .page-title { font-size: 1.8rem; }
      .filter-bar input { min-width: 140px; }
    }
  </style>
</head>
<body>

<!-- SIDEBAR -->
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
      <li><a href="{{ route('admin.index') }}"><span class="nav-icon">✦</span> Dashboard</a></li>
      <li><a href="{{ route('admin.appointments') }}" class="active"><span class="nav-icon">◈</span> Appointments</a></li>
      <li><a href="{{ route('admin.designs') }}"><span class="nav-icon">◇</span> Desain</a></li>
    </ul>
  </nav>

  <div class="sidebar-bottom">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button class="logout-btn" type="submit"><span>↩</span> Keluar</button>
    </form>
  </div>
</div>

<!-- MAIN -->
<div class="main">
  <div class="topbar">
    <div>
      <div class="topbar-greeting">Selamat datang, <strong>{{ auth()->user()->name }}</strong></div>
      <div class="topbar-date" id="topbar-date"></div>
    </div>
    <div class="topbar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
  </div>

  <div class="content">
    <div class="page-header">
      <p class="page-eyebrow">Manajemen</p>
      <h1 class="page-title">Kelola <em>Appointment</em></h1>
      <p class="page-sub">Daftar seluruh booking customer OU Beauty Bar</p>
    </div>

    @if(session('success'))
    <div class="alert"><div class="alert-dot"></div> {{ session('success') }}</div>
    @endif

    <!-- FILTER -->
    <div class="filter-section">
      <form method="GET" action="{{ route('admin.appointments') }}" class="filter-bar">
        <input type="text" name="search"
               placeholder="🔍  Cari nama atau email customer..."
               value="{{ request('search') }}"/>
        <select name="status">
          <option value="">Semua Status</option>
          @foreach(['Pending','Konfirmasi','Selesai'] as $s)
            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
          @endforeach
        </select>
        <button type="submit" class="btn-search">Cari</button>
      </form>
    </div>

    <!-- TABLE -->
    <div class="table-card">
      @if($appointments->isEmpty())
        <div class="empty-state">
          <span class="empty-icon">◈</span>
          <p>Tidak ada appointment yang ditemukan.</p>
        </div>
      @else
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Desain</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Pembayaran</th>
                <th>Foto</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($appointments as $i => $appt)
              <tr>
                <td style="color:var(--gray);font-size:.78rem;">{{ $i + 1 }}</td>
                <td>
                  <div class="customer-name">{{ $appt->user->name }}</div>
                  <div class="customer-email">{{ $appt->user->email }}</div>
                </td>
                <td style="font-size:.83rem;">{{ $appt->design->nama }}</td>
                <td style="font-size:.82rem;white-space:nowrap;">{{ \Carbon\Carbon::parse($appt->tanggal)->format('d M Y') }}</td>
                <td style="font-size:.82rem;">{{ $appt->jam }}</td>
                <td>
                  @php
                    $ps = $appt->payment_status ?? 'pending';
                    $psClass = ['pending'=>'pay-pending','waiting_confirmation'=>'pay-waiting','paid'=>'pay-paid'][$ps] ?? 'pay-pending';
                    $psLabel = ['pending'=>'Pending','waiting_confirmation'=>'Menunggu','paid'=>'Lunas'][$ps] ?? 'Pending';
                  @endphp
                  <span class="pay-badge {{ $psClass }}">{{ $psLabel }}</span>
                  <div style="font-size:.73rem;color:var(--gray);margin-top:.2rem;">{{ $appt->metode_bayar }}</div>
                </td>
                <td>
                  @if($appt->foto_referensi)
                    <img src="{{ asset('storage/' . $appt->foto_referensi) }}"
                         class="foto-thumb"
                         onclick="window.open(this.src)"
                         title="Klik untuk lihat"/>
                  @else
                    <span class="no-foto">—</span>
                  @endif
                </td>
                <td>
                  @php $sl = strtolower($appt->status); @endphp
                  <span class="badge badge-{{ $sl }}">{{ $appt->status }}</span>
                </td>
                <td>
                  <div class="actions">
                    {{-- Detail sementara dinonaktifkan (route admin.appointments.show belum ada) --}}
                    <button class="btn-detail" disabled>Detail</button>
                    {{-- TODO: aktifkan kalau route sudah dibuat --}}
                    {{-- <a href="{{ route('admin.appointments.show', $appt->id) }}" class="btn-detail">Detail</a> --}}

                    {{-- Status update --}}
                    @if(\Illuminate\Support\Facades\Route::has('admin.appointments.status'))
                    <form action="{{ route('admin.appointments.status', $appt->id) }}" method="POST">
                      @csrf @method('PATCH')
                      <select name="status" class="status-select" onchange="this.form.submit()">
                        @foreach(['Pending','Konfirmasi','Selesai'] as $s)
                          <option value="{{ $s }}" {{ $appt->status == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                      </select>
                    </form>
                    @endif

                    {{-- Hapus --}}
                    @if(\Illuminate\Support\Facades\Route::has('admin.appointments.destroy'))
                    <form action="{{ route('admin.appointments.destroy', $appt->id) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus appointment ini?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn-del">Hapus</button>
                    </form>
                    @endif
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</div>

<script>
  const d = new Date();
  document.getElementById('topbar-date').textContent =
    d.toLocaleDateString('id-ID', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
</script>
</body>
</html>