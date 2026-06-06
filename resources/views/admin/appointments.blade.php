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
    .slot-list { display: flex; flex-wrap: wrap; gap: .5rem; }
    .slot-item { display: flex; align-items: center; gap: .5rem; background: var(--olive-pale); padding: .4rem .8rem; border-radius: 4px; font-size: .78rem; }
    .slot-item.booked { background: var(--lilac-pale); color: var(--lilac-deep); }
    .slot-item .slot-del { background: none; border: none; cursor: pointer; color: #e53935; font-size: .85rem; padding: 0; line-height: 1; }
    .slot-date-group { margin-bottom: .8rem; }
    .slot-date-label { font-size: .7rem; letter-spacing: .1em; text-transform: uppercase; color: var(--gray); margin-bottom: .4rem; }

    /* TABLE */
    .filter-bar { display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .filter-bar input, .filter-bar select { background: white; border: 1px solid rgba(92,107,58,.2); color: var(--dark); padding: .6rem 1rem; font-family: 'Jost', sans-serif; font-size: .85rem; outline: none; border-radius: 4px; }
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
    .btn-detail { background: none; border: 1px solid rgba(92,107,58,.3); padding: .35rem .8rem; font-size: .72rem; cursor: pointer; color: var(--olive); border-radius: 4px; font-family: inherit; transition: all .2s; }
    .btn-detail:hover { background: var(--olive-pale); }
    .empty-state { text-align: center; padding: 3rem; color: var(--gray); }

    /* MODAL */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 1000; align-items: center; justify-content: center; }
    .modal-overlay.open { display: flex; }
    .modal { background: white; border-radius: 8px; width: 90%; max-width: 620px; max-height: 85vh; overflow-y: auto; padding: 2rem; position: relative; }
    .modal-close { position: absolute; top: 1rem; right: 1rem; background: none; border: none; font-size: 1.3rem; cursor: pointer; color: var(--gray); }
    .modal-title { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 400; margin-bottom: 1.5rem; }
    .modal-title em { font-style: italic; color: var(--olive); }
    .detail-section { margin-bottom: 1.2rem; }
    .detail-label { font-size: .68rem; letter-spacing: .12em; text-transform: uppercase; color: var(--gray); margin-bottom: .5rem; }
    .detail-value { font-size: .88rem; color: var(--dark); }
    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .8rem; margin-bottom: 1.2rem; }
    .detail-item { background: #f9faf6; padding: .7rem 1rem; border-radius: 4px; }
    .finger-table { width: 100%; border-collapse: collapse; font-size: .78rem; }
    .finger-table th { background: var(--olive-pale); padding: .4rem .6rem; text-align: left; font-size: .65rem; letter-spacing: .08em; text-transform: uppercase; color: var(--gray); }
    .finger-table td { padding: .4rem .6rem; border-bottom: 1px solid rgba(92,107,58,.07); }
    .foto-grid { display: flex; flex-wrap: wrap; gap: .5rem; margin-top: .5rem; }
    .foto-grid img { width: 80px; height: 80px; object-fit: cover; border-radius: 4px; cursor: pointer; border: 1px solid rgba(92,107,58,.2); transition: opacity .2s; }
    .foto-grid img:hover { opacity: .8; }
    .divider { border: none; border-top: 1px solid rgba(92,107,58,.1); margin: 1rem 0; }
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

  {{-- SLOT --}}
  <div class="slot-section">
    <h2>Kelola <em>Slot Jadwal</em></h2>
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
    @if($slots->isEmpty())
      <p style="font-size:.82rem;color:var(--gray)">Belum ada slot.</p>
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
                    <button type="submit" class="slot-del">×</button>
                  </form>
                @endif
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    @endif
  </div>

  {{-- FILTER --}}
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

  {{-- TABEL --}}
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
            <td>
              {{ $appt->metode_bayar }}<br>
              @if($appt->total_harga)
                <small style="color:var(--lilac-deep)">Rp {{ number_format($appt->total_harga, 0, ',', '.') }}</small>
              @endif
            </td>
            <td><span class="badge badge-{{ strtolower($appt->status) }}">{{ $appt->status }}</span></td>
            <td>
              <div class="actions">
                <button class="btn-detail" onclick="bukaDetail({{ $appt->id }})">Detail</button>
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

{{-- ===== MODAL DETAIL ===== --}}
<div class="modal-overlay" id="modal-overlay" onclick="tutupModal(event)">
  <div class="modal" id="modal-content">
    <button class="modal-close" onclick="tutupModalDirect()">×</button>
    <h2 class="modal-title">Detail <em>Order</em></h2>
    <div id="modal-body">
      {{-- Diisi via JS --}}
    </div>
  </div>
</div>

{{-- Data appointments sebagai JSON untuk modal --}}
<script>
const appointmentsData = {
  @foreach($appointments as $appt)
  @php
    $isNailArt = $appt->tipe_order !== 'press_on';
    $pilihanJari = $appt->pilihan_jari ?? [];
    $jariKiri = ['Kelingking','Manis','Tengah','Telunjuk','Ibu Jari'];
    $jariKanan = ['Ibu Jari','Telunjuk','Tengah','Manis','Kelingking'];
  @endphp
  {{ $appt->id }}: {
    customer: "{{ addslashes($appt->user->name) }}",
    email: "{{ addslashes($appt->user->email) }}",
    no_wa: "{{ $appt->no_wa ?? '' }}",
    tipe: "{{ $isNailArt ? 'Nail Art' : 'Press On Nail' }}",
    desain: "{{ addslashes($appt->design->nama ?? '—') }}",
    kategori: "{{ addslashes($appt->design->kategori ?? '') }}",
    panjang_kuku: "{{ $appt->panjang_kuku ?? '—' }}",
    bentuk_kuku: "{{ $appt->bentuk_kuku ?? '—' }}",
    tanggal: "{{ $appt->tanggal ? \Carbon\Carbon::parse($appt->tanggal)->format('d M Y') : 'Dikirim kurir' }}",
    jam: "{{ $appt->jam ?? '' }}",
    metode_bayar: "{{ $appt->metode_bayar ?? '—' }}",
    total_harga: {{ $appt->total_harga ?? 0 }},
    status: "{{ $appt->status }}",
    catatan: "{{ addslashes($appt->catatan ?? '') }}",
    foto_referensi: "{{ $appt->foto_referensi ? asset('storage/' . $appt->foto_referensi) : '' }}",
    foto_jari_koin: "{{ $appt->foto_jari_koin ? asset('storage/' . $appt->foto_jari_koin) : '' }}",
    bukti_bayar: "{{ $appt->bukti_bayar ? asset('storage/' . $appt->bukti_bayar) : '' }}",
    foto_referensi_list: [
      @if($appt->foto_referensi_list)
        @foreach($appt->foto_referensi_list as $f)
          "{{ asset('storage/' . $f) }}",
        @endforeach
      @endif
    ],
    pilihan_jari_kiri: [
      @foreach($jariKiri as $idx => $nama)
        @php $designId = $pilihanJari['kiri'][$idx] ?? null; @endphp
        { jari: "{{ $nama }}", design: "{{ $designId ? addslashes(\App\Models\Design::find($designId)?->nama ?? '—') : '—' }}" },
      @endforeach
    ],
    pilihan_jari_kanan: [
      @foreach($jariKanan as $idx => $nama)
        @php $designId = $pilihanJari['kanan'][$idx] ?? null; @endphp
        { jari: "{{ $nama }}", design: "{{ $designId ? addslashes(\App\Models\Design::find($designId)?->nama ?? '—') : '—' }}" },
      @endforeach
    ],
  },
  @endforeach
};

function bukaDetail(id) {
  const d = appointmentsData[id];
  if (!d) return;

  const dp = d.tipe === 'Nail Art' ? Math.ceil(d.total_harga * 0.5) : d.total_harga;
  const dpLabel = d.tipe === 'Nail Art' ? 'DP 50%' : 'Bayar Lunas';

  let html = `
    <div class="detail-grid">
      <div class="detail-item"><p class="detail-label">Customer</p><p class="detail-value"><strong>${d.customer}</strong><br><small style="color:var(--gray)">${d.email}</small></p></div>
      <div class="detail-item"><p class="detail-label">No. WhatsApp</p><p class="detail-value">${d.no_wa || '<em style="color:var(--gray)">—</em>'}</p></div>
      <div class="detail-item"><p class="detail-label">Tipe Order</p><p class="detail-value">${d.tipe}</p></div>
      <div class="detail-item"><p class="detail-label">Status</p><p class="detail-value">${d.status}</p></div>
      <div class="detail-item"><p class="detail-label">Desain Utama</p><p class="detail-value">${d.desain}<br><small style="color:var(--gray)">${d.kategori}</small></p></div>
      <div class="detail-item"><p class="detail-label">Kuku</p><p class="detail-value">${d.panjang_kuku} · ${d.bentuk_kuku}</p></div>
      <div class="detail-item"><p class="detail-label">Jadwal</p><p class="detail-value">${d.tanggal}${d.jam ? ' · ' + d.jam : ''}</p></div>
      <div class="detail-item"><p class="detail-label">Pembayaran</p><p class="detail-value">${d.metode_bayar}<br><small style="color:var(--lilac-deep)">Total: Rp ${d.total_harga.toLocaleString('id-ID')}</small><br><small style="color:var(--olive)">${dpLabel}: Rp ${dp.toLocaleString('id-ID')}</small></p></div>
    </div>`;

  // Pilihan per jari
  if (d.pilihan_jari_kiri.length) {
    html += `<hr class="divider"><p class="detail-label" style="margin-bottom:.5rem">Pilihan Model per Jari</p>
    <table class="finger-table">
      <thead><tr><th>Tangan</th><th>Jari</th><th>Model</th></tr></thead><tbody>`;
    d.pilihan_jari_kiri.forEach(j => {
      html += `<tr><td>Kiri</td><td>${j.jari}</td><td>${j.design}</td></tr>`;
    });
    d.pilihan_jari_kanan.forEach(j => {
      html += `<tr><td>Kanan</td><td>${j.jari}</td><td>${j.design}</td></tr>`;
    });
    html += `</tbody></table>`;
  }

  // Catatan
  if (d.catatan) {
    html += `<hr class="divider"><p class="detail-label">Catatan</p><p class="detail-value">${d.catatan}</p>`;
  }

  // Foto-foto
  html += `<hr class="divider"><p class="detail-label">Foto</p><div class="foto-grid">`;
  let adaFoto = false;

  if (d.bukti_bayar) {
    html += `<div style="text-align:center"><img src="${d.bukti_bayar}" onclick="window.open(this.src)" title="Bukti Bayar"/><p style="font-size:.65rem;color:var(--gray);margin-top:.2rem">Bukti Bayar</p></div>`;
    adaFoto = true;
  }
  if (d.foto_referensi) {
    html += `<div style="text-align:center"><img src="${d.foto_referensi}" onclick="window.open(this.src)" title="Foto Referensi"/><p style="font-size:.65rem;color:var(--gray);margin-top:.2rem">Referensi</p></div>`;
    adaFoto = true;
  }
  if (d.foto_jari_koin) {
    html += `<div style="text-align:center"><img src="${d.foto_jari_koin}" onclick="window.open(this.src)" title="Foto Jari + Koin"/><p style="font-size:.65rem;color:var(--gray);margin-top:.2rem">Jari + Koin</p></div>`;
    adaFoto = true;
  }
  d.foto_referensi_list.forEach((f, i) => {
    html += `<div style="text-align:center"><img src="${f}" onclick="window.open(this.src)" title="Referensi ${i+1}"/><p style="font-size:.65rem;color:var(--gray);margin-top:.2rem">Ref ${i+1}</p></div>`;
    adaFoto = true;
  });

  if (!adaFoto) html += `<p style="color:var(--gray);font-size:.82rem">Tidak ada foto.</p>`;
  html += `</div>`;

  document.getElementById('modal-body').innerHTML = html;
  document.getElementById('modal-overlay').classList.add('open');
}

function tutupModal(e) {
  if (e.target === document.getElementById('modal-overlay')) tutupModalDirect();
}
function tutupModalDirect() {
  document.getElementById('modal-overlay').classList.remove('open');
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') tutupModalDirect(); });
</script>

</body>
</html>