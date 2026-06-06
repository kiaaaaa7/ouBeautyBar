<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Customer — Admin OU Beauty Bar</title>
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
    .page-title { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 400; margin-bottom: .3rem; }
    .page-title em { font-style: italic; color: var(--olive); }
    .page-sub { font-size: .85rem; color: var(--gray); margin-bottom: 2rem; }
    .filter-bar { display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .filter-bar input { background: white; border: 1px solid rgba(92,107,58,.2); color: var(--dark); padding: .6rem 1rem; font-family: 'Jost', sans-serif; font-size: .85rem; outline: none; border-radius: 4px; transition: border-color .2s; min-width: 250px; }
    .filter-bar input:focus { border-color: var(--olive); }
    .filter-bar button { background: var(--olive); color: white; border: none; padding: .6rem 1.4rem; cursor: pointer; font-family: inherit; font-size: .82rem; border-radius: 4px; transition: background .2s; }
    .filter-bar button:hover { background: var(--olive-light); }
    .card { background: white; border-radius: 6px; border: 1px solid rgba(92,107,58,.1); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; font-size: .83rem; }
    th { text-align: left; padding: .9rem 1rem; font-size: .68rem; letter-spacing: .1em; text-transform: uppercase; color: var(--gray); border-bottom: 1px solid rgba(92,107,58,.1); background: var(--olive-pale); }
    td { padding: .85rem 1rem; border-bottom: 1px solid rgba(92,107,58,.07); vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #f9faf6; }
    .avatar { width: 36px; height: 36px; border-radius: 50%; background: var(--lilac); display: flex; align-items: center; justify-content: center; font-size: .85rem; font-weight: 600; color: var(--lilac-deep); flex-shrink: 0; }
    .customer-cell { display: flex; align-items: center; gap: .8rem; }
    .badge-order { background: var(--olive-pale); color: var(--olive); font-size: .72rem; padding: .2rem .6rem; border-radius: 10px; font-weight: 500; }
    .wa-btn { display: inline-flex; align-items: center; gap: .3rem; background: #25D366; color: white; padding: .35rem .8rem; font-size: .75rem; border-radius: 4px; text-decoration: none; transition: background .2s; }
    .wa-btn:hover { background: #1da851; }
    .empty-state { text-align: center; padding: 3rem; color: var(--gray); }
    .no-wa { font-size: .75rem; color: var(--gray); font-style: italic; }
  </style>
</head>
<body>
<div class="sidebar">
  <a class="sidebar-logo" href="/"><div class="logo-badge">OU</div> Beauty Bar</a>
  <ul class="sidebar-menu">
    <li><a href="{{ route('admin.index') }}">📊 Dashboard</a></li>
    <li><a href="{{ route('admin.appointments') }}">📅 Appointments</a></li>
    <li><a href="{{ route('admin.designs') }}">💅 Desain</a></li>
    <li><a href="{{ route('admin.customers') }}" class="active">👥 Customer</a></li>
  </ul>
  <div class="sidebar-bottom">
    <form action="{{ route('logout') }}" method="POST">
      @csrf <button class="logout-btn" type="submit">🚪 Logout</button>
    </form>
  </div>
</div>

<div class="main">
  <h1 class="page-title">Data <em>Customer</em></h1>
  <p class="page-sub">Daftar semua customer terdaftar — {{ $customers->count() }} customer</p>

  <form method="GET" action="{{ route('admin.customers') }}" class="filter-bar">
    <input type="text" name="search" placeholder="Cari nama atau email..." value="{{ request('search') }}"/>
    <button type="submit">Cari</button>
  </form>

  <div class="card">
    @if($customers->isEmpty())
      <p class="empty-state">Belum ada customer terdaftar.</p>
    @else
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Customer</th>
            <th>No. WhatsApp</th>
            <th>Total Order</th>
            <th>Terakhir Order</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($customers as $i => $customer)
          @php
            $noWa = $customer->appointments->whereNotNull('no_wa')->last()?->no_wa;
            $waUrl = $noWa
              ? 'https://wa.me/62' . ltrim($noWa, '0') . '?text=' . urlencode('Halo ' . $customer->name . '! 👋 Ini admin OU Beauty Bar.')
              : null;
            $lastOrder = $customer->appointments->sortByDesc('created_at')->first();
          @endphp
          <tr>
            <td>{{ $i + 1 }}</td>
            <td>
              <div class="customer-cell">
                <div class="avatar">{{ strtoupper(substr($customer->name, 0, 1)) }}</div>
                <div>
                  <strong>{{ $customer->name }}</strong><br>
                  <small style="color:var(--gray)">{{ $customer->email }}</small>
                </div>
              </div>
            </td>
            <td>
              @if($noWa)
                <span style="font-size:.83rem">{{ $noWa }}</span>
              @else
                <span class="no-wa">Belum ada</span>
              @endif
            </td>
            <td>
              <span class="badge-order">{{ $customer->appointments->count() }} order</span>
            </td>
            <td>
              @if($lastOrder)
                <span style="font-size:.82rem">{{ \Carbon\Carbon::parse($lastOrder->created_at)->format('d M Y') }}</span><br>
                <small style="color:var(--gray)">
                  {{ $lastOrder->tipe_order === 'press_on' ? '📦 Press On' : '💅 Nail Art' }}
                </small>
              @else
                <span style="color:var(--gray);font-size:.78rem">—</span>
              @endif
            </td>
            <td>
              @if($waUrl)
                <a href="{{ $waUrl }}" target="_blank" class="wa-btn">
                  💬 WhatsApp
                </a>
              @else
                <span class="no-wa">No WA belum tersedia</span>
              @endif
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