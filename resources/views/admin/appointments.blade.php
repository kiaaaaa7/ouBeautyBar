<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Appointments — Admin OU Beauty Bar</title>
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
    .page-title { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 400; margin-bottom: 1.5rem; }
    .page-title em { font-style: italic; color: var(--olive); }
    .alert { padding: .9rem 1.2rem; font-size: .85rem; margin-bottom: 1.5rem; border-left: 4px solid var(--olive); background: var(--olive-pale); color: var(--olive); }
    .alert-error { border-color: #e53935; background: #ffebee; color: #c62828; }

    /* SLOT SECTION */
    .slot-section { background: white; border-radius: 6px; border: 1px solid rgba(92,107,58,.1); padding: 1.5rem; margin-bottom: 2rem; }
    .slot-section h2 { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 400; margin-bottom: 1rem; }
    .slot-section h2 em { font-style: italic; color: var(--olive); }
    .slot-form { display: flex; gap: .8rem; flex-wrap: wrap; align-items: flex-end; margin-bottom: 1.2rem; }
    .slot-form label { font-size: .7rem; letter-spacing: .1em; text-transform: uppercase; color: var(--gray); display: block; margin-bottom: .3rem; }
    .slot-form input[type=date] { background: white; border: 1px solid rgba(92,107,58,.2); color: var(--dark); padding: .6rem .9rem; font-family: 'Jost', sans-serif; font-size: .85rem; outline: none; border-radius: 4px; }
    .slot-form input[type=date]:focus { border-color: var(--olive); }
    .jam-checkboxes { display: flex; flex-wrap: wrap; gap: .5rem; }
    .jam-cb { display: none; }
    .jam-cb + label { padding: .4rem .8rem; border: 1px solid rgba(92,107,58,.25); border-radius: 4px; cursor: pointer; font-size: .78rem; color: var(--gray); transition: all .2s; text-transform: none; letter-spacing: 0; }
    .jam-cb:checked + label { background: var(--olive); color: white; border-color: var(--olive); }
    .btn-add-slot { background: var(--olive); color: white; border: none; padding: .6rem 1.4rem; cursor: pointer; font-family: inherit; font-size: .82rem; border-radius: 4px; transition: background .2s; }
    .btn-add-slot:hover { background: var(--olive-light); }

    /* SLOT LIST */
    .slot-list { display: flex; flex-wrap: wrap; gap: .5rem; }
    .slot-item { display: flex; align-items: center; gap: .5rem; background: var(--olive-pale); padding: .4rem .8rem; border-radius: 4px; font-size: .78rem; }
    .slot-item.booked { background: var(--lilac-pale); color: var(--lilac-deep); }
    .slot-item .slot-del { background: none; border: none; cursor: pointer; color: #e53935; font-size: .85rem; padding: 0; line-height: 1; }
    .slot-date-group { margin-bottom: .8rem; }
    .slot-date-label { font-size: .7rem; letter-spacing: .1em; text-transform: uppercase; color: var(--gray); margin-bottom: .4rem; }

    /* TABLE */
    .filter-bar { display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .filter-bar input, .filter-bar select { background: white; border: 1px solid rgba(92,107,58,.2); color: var(--dark); padding: .6rem 1rem; font-family: 'Jost', sans-serif; font-size: .85rem; outline: none; border-radius: 4px; transition: border-color .2s; }
    .filter-bar input:focus, .filter-bar select:focus { border-color: var(--olive); }
    .filter-bar button { background: var(--olive); color: white; border: none; padding: .6rem 1.4rem; cursor: pointer; font-family: inherit; font-size: .82rem; border-radius: 4px; }
    .card { background: white; border-radius: 6px; border: 1px solid rgba(92,107,58,.1); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; font-size: .83rem; }
    th { text-align: left; padding: .9rem 1rem; font-size: .68rem; letter-spacing: .1em; text-transform: uppercase; color: var(--gray); border-bottom: 1px solid rgba(92,107,58,.1); background: var(--olive-pale); }
    td { padding: .85rem 1rem; border-bottom: 1px solid rgba(92,107,58,.07); vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #f9faf6; }
    .badge { font-size: .68rem; letter-spacing: .06em; text-transform: uppercase; padding: .3rem .8rem; border-radius: 20px; display: inline-block; }
    .badge-pending { background: #fff3e0; color: #e65100; }
    .badge-konfirmasi { background: var(--lilac-pale); color: var(--lilac-deep); }
    .badge-selesai { background: var(--olive-pale); color: var(--olive); }
    .tipe-badge { font-size: .65rem; padding: .2rem .5rem; border-radius: 3px; display: inline-block; margin-bottom: .2rem; }
    .tipe-nail-art { background: var(--lilac-pale); color: var(--lilac-deep); }
    .tipe-press-on { background: #e8f5e9; color: #2e7d32; }
    .actions { display: flex; gap: .5rem; align-items: center; flex-wrap: wrap; }
    select.status-select { font-size: .78rem; padding: .35rem .6rem; border: 1px solid rgba(92,107,58,.25); border-radius: 4px; background: white; color: var(--dark); font-family: inherit; cursor: pointer; outline: none; }
    .btn-del { background: none; border: 1px solid rgba(155,135,176,.4); padding: .35rem .8rem; font-size: .72rem; cursor: pointer; color: var(--lilac-deep); border-radius: 4px; font-family: inherit; transition: all .2s; }
    .btn-del:hover { background: var(--lilac-deep); color: white; border-color: var(--lilac-deep); }
    .empty-state { text-align: center; padding: 3rem; color: var(--gray); }
  </style>
</head>
<body>
<div class="sidebar">
  <a class="sidebar-logo" href="/"><div class="logo-badge">OU</div> Beauty Bar</a>
  <ul class="sidebar-menu">
    <li><a href="{{ route('admin.index') }}">📊 Dashboard</a></li>
    <li><a href="{{ route('admin.appointments') }}" class="active">📅 Appointments</a></li>
    <li><a href="{{ route('admin.designs') }}">💅 Desain</a></li>
    <li><a href="{{ route('admin.customers') }}">👥 Customer</a></li>
  </ul>
  <div class="sidebar-bottom">
    <form action="{{ route('logout') }}" method="POST">
      @csrf <button class="logout-btn" type="submit">🚪 Logout</button>
    </form>
  </div>
</div>

<div class="main">
  <h1 class="page-title">Kelola <em>Appointment</em></h1>

  @if(session('success'))
    <div class="alert">✅ {{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-error">⚠️ {{ session('error') }}</div>
  @endif

  {{-- ===== KELOLA SLOT ===== --}}
  <div class="slot-section">
    <h2>Kelola <em>Slot Jadwal</em></h2>

    {{-- Form tambah slot --}}
    <form action="{{ route('admin.slots.store') }}" method="POST">
      @csrf
      <div class="slot-form">
        <div>
          <label>Tanggal</label>
          <input type="date" name="tanggal" min="{{ date('Y-m-d') }}" required/>
        </div>
        <div>
          <label>Pilih Jam (bisa lebih dari 1)</label>
          <div class="jam-checkboxes">
            @foreach(['09:00','10:00','11:00','13:00','14:00','15:00','16:00'] as $j)
              <input type="checkbox" name="jam[]" id="jam-{{ $loop->index }}" value="{{ $j }}" class="jam-cb"/>
              <label for="jam-{{ $loop->index }}">{{ $j }}</label>
            @endforeach
          </div>
        </div>
        <button type="submit" class="btn-add-slot">+ Tambah Slot</button>
      </div>
    </form>

    {{-- Daftar slot --}}
    @if($slots->isEmpty())
      <p style="font-size:.82rem;color:var(--gray)">Belum ada slot. Tambahkan jadwal di atas.</p>
    @else
      @php $slotsByDate = $slots->groupBy(fn($s) => \Carbon\Carbon::parse($s->tanggal)->format('Y-m-d')); @endphp
      @foreach($slotsByDate as $tgl => $slotGroup)
        <div class="slot-date-group">
          <p class="slot-date-label">{{ \Carbon\Carbon::parse($tgl)->translatedFormat('l, d F Y') }}</p>
          <div class="slot-list">
            @foreach($slotGroup as $slot)
              <div class="slot-item {{ $slot->is_booked ? 'booked' : '' }}">
                <span>{{ $slot->jam }}</span>
                @if($slot->is_booked)
                  <span style="font-size:.68rem">✓ Booked</span>
                @else
                  <form action="{{ route('admin.slots.destroy', $slot->id) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="slot-del" title="Hapus slot">×</button>
                  </form>
                @endif
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    @endif
  </div>

  {{-- ===== TABEL APPOINTMENTS ===== --}}
  <form method="GET" action="{{ route('admin.appointments') }}" class="filter-bar">
    <input type="text" name="search" placeholder="Cari nama customer..." value="{{ request('search') }}"/>
    <select name="status">
      <option value="">Semua Status</option>
      @foreach(['Pending','Konfirmasi','Selesai'] as $s)
        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
      @endforeach
    </select>
    <button type="submit">Cari</button>
  </form>

  <div class="card">
    @if($appointments->isEmpty())
      <p class="empty-state">Tidak ada appointment ditemukan.</p>
    @else
      <table>
        <thead>
          <tr>
            <th>#</th><th>Customer</th><th>Desain</th>
            <th>Tipe</th><th>Jadwal</th><th>Bayar</th>
            <th>Status</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($appointments as $i => $appt)
          @php $isNailArt = $appt->tipe_order !== 'press_on'; @endphp
          <tr>
            <td>{{ $i + 1 }}</td>
            <td>
              <strong>{{ $appt->user->name }}</strong><br>
              <small style="color:var(--gray)">{{ $appt->user->email }}</small><br>
              @if($appt->no_wa)
                <small style="color:var(--olive)">📱 {{ $appt->no_wa }}</small>
              @endif
            </td>
            <td>
              {{ $appt->design->nama ?? '—' }}<br>
              <small style="color:var(--gray)">{{ $appt->panjang_kuku }} · {{ $appt->bentuk_kuku ?? '—' }}</small>
            </td>
            <td>
              <span class="tipe-badge {{ $isNailArt ? 'tipe-nail-art' : 'tipe-press-on' }}">
                {{ $isNailArt ? '💅 Nail Art' : '📦 Press On' }}
              </span>
            </td>
            <td>
              @if($isNailArt && $appt->tanggal)
                {{ \Carbon\Carbon::parse($appt->tanggal)->format('d M Y') }}<br>
                <small style="color:var(--gray)">{{ $appt->jam }}</small>
              @else
                <span style="color:var(--gray);font-size:.78rem">Dikirim kurir</span>
              @endif
            </td>
            <td>{{ $appt->metode_bayar }}</td>
            <td><span class="badge badge-{{ strtolower($appt->status) }}">{{ $appt->status }}</span></td>
            <td>
              <div class="actions">
                <form action="{{ route('admin.appointments.status', $appt->id) }}" method="POST">
                  @csrf @method('PATCH')
                  <select name="status" class="status-select" onchange="this.form.submit()">
                    @foreach(['Pending','Konfirmasi','Selesai'] as $s)
                      <option value="{{ $s }}" {{ $appt->status == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                  </select>
                </form>
                <form action="{{ route('admin.appointments.destroy', $appt->id) }}" method="POST"
                      onsubmit="return confirm('Hapus appointment ini?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-del">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</div>
</body>
</html>