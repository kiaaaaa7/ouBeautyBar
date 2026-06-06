<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Rekap Pemesanan — Admin OU Beauty Bar</title>

  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet"/>

  <style>
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }

    :root {
      --olive:#5C6B3A;
      --olive-light:#7A8C4E;
      --olive-pale:#E8EDD8;
      --lilac:#C4B5D4;
      --lilac-deep:#9B87B0;
      --dark:#2C2C2C;
      --gray:#6B6B6B;
    }

    body{
      font-family:'Jost',sans-serif;
      background:#F2F4EE;
      color:var(--dark);
      display:flex;
      min-height:100vh;
    }

    .sidebar{
      width:240px;
      background:var(--olive);
      color:white;
      padding:2rem 1.5rem;
      flex-shrink:0;
      display:flex;
      flex-direction:column;
    }

    .sidebar-logo{
      font-family:'Playfair Display',serif;
      font-size:1.3rem;
      font-weight:600;
      margin-bottom:2.5rem;
      display:flex;
      align-items:center;
      gap:.6rem;
      text-decoration:none;
      color:white;
    }

    .logo-badge{
      width:34px;
      height:34px;
      background:var(--lilac);
      border-radius:50%;
      display:flex;
      align-items:center;
      justify-content:center;
      color:var(--olive);
      font-size:.72rem;
      font-weight:700;
    }

    .sidebar-menu{
      list-style:none;
      display:flex;
      flex-direction:column;
      gap:.3rem;
    }

    .sidebar-menu a{
      display:block;
      padding:.75rem 1rem;
      font-size:.82rem;
      text-decoration:none;
      color:rgba(255,255,255,.65);
      border-radius:4px;
      transition:.2s;
    }

    .sidebar-menu a:hover,
    .sidebar-menu a.active{
      background:rgba(255,255,255,.15);
      color:white;
    }

    .sidebar-bottom{
      margin-top:auto;
      padding-top:2rem;
      border-top:1px solid rgba(255,255,255,.15);
    }

    .logout-btn{
      background:none;
      border:none;
      color:rgba(255,255,255,.55);
      font-size:.82rem;
      cursor:pointer;
      font-family:inherit;
      padding:.75rem 1rem;
      width:100%;
      text-align:left;
      border-radius:4px;
    }

    .logout-btn:hover{
      background:rgba(255,255,255,.1);
      color:white;
    }

    .main{
      flex:1;
      padding:2.5rem;
      overflow-y:auto;
    }

    .page-title{
      font-family:'Playfair Display',serif;
      font-size:2rem;
      margin-bottom:.3rem;
    }

    .page-title em{
      color:var(--olive);
      font-style:italic;
    }

    .page-sub{
      color:var(--gray);
      margin-bottom:2rem;
      font-size:.85rem;
    }

    .card{
      background:white;
      border-radius:6px;
      border:1px solid rgba(92,107,58,.1);
      overflow:hidden;
    }

    table{
      width:100%;
      border-collapse:collapse;
    }

    th{
      background:var(--olive-pale);
      padding:1rem;
      text-align:left;
      font-size:.75rem;
      text-transform:uppercase;
    }

    td{
      padding:1rem;
      border-bottom:1px solid rgba(92,107,58,.08);
    }

    tr:last-child td{
      border-bottom:none;
    }

    .badge{
      background:var(--olive-pale);
      color:var(--olive);
      padding:.25rem .7rem;
      border-radius:20px;
      font-size:.75rem;
      font-weight:500;
    }
  </style>
</head>

<body>

<div class="sidebar">
  <a class="sidebar-logo" href="/">
    <div class="logo-badge">OU</div>
    Beauty Bar
  </a>

  <ul class="sidebar-menu">
    <li><a href="{{ route('admin.index') }}">📊 Dashboard</a></li>
    <li><a href="{{ route('admin.appointments') }}">📅 Appointments</a></li>
    <li><a href="{{ route('admin.designs') }}">💅 Desain</a></li>
    <li><a href="{{ route('admin.customers') }}">👥 Customer</a></li>
    <li><a href="{{ route('admin.rekap') }}" class="active">📊 Rekap Pemesanan</a></li>
  </ul>

  <div class="sidebar-bottom">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button class="logout-btn" type="submit">
        🚪 Logout
      </button>
    </form>
  </div>
</div>

<div class="main">

  <h1 class="page-title">Rekap <em>Pemesanan</em></h1>

  <p class="page-sub">
    Statistik jumlah pesanan berdasarkan bulan
  </p>

  <div class="card">
    <table>
      <thead>
<tr>
    <th>Bulan</th>
    <th>Tahun</th>
    <th>Nail Art</th>
    <th>Press On</th>
    <th>Total</th>
</tr>
</thead>

<tbody>
@foreach($rekapBulanan as $item)

@php
$namaBulan = [
    1=>'Januari',
    2=>'Februari',
    3=>'Maret',
    4=>'April',
    5=>'Mei',
    6=>'Juni',
    7=>'Juli',
    8=>'Agustus',
    9=>'September',
    10=>'Oktober',
    11=>'November',
    12=>'Desember'
];
@endphp

<tr>
    <td>{{ $namaBulan[$item->bulan] }}</td>
    <td>{{ $item->tahun }}</td>

    <td>
        💅 {{ $item->total_nail_art }}
    </td>

    <td>
        📦 {{ $item->total_press_on }}
    </td>

    <td>
        <span class="badge">
            {{ $item->total_pesanan }} Pesanan
        </span>
    </td>
</tr>

@endforeach
</tbody>

    </table>
    <div class="card" style="margin-top:20px;padding:20px;">
    <h3 style="margin-bottom:15px;">📊 Grafik Pemesanan Bulanan</h3>

    <canvas id="rekapChart"></canvas>
</div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('rekapChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            @foreach($rekapBulanan as $item)
                '{{ DateTime::createFromFormat("!m",$item->bulan)->format("F") }} {{ $item->tahun }}',
            @endforeach
        ],
        datasets: [
        {
            label: 'Nail Art',
            data: [
                @foreach($rekapBulanan as $item)
                    {{ $item->total_nail_art }},
                @endforeach
            ]
        },
        {
            label: 'Press On',
            data: [
                @foreach($rekapBulanan as $item)
                    {{ $item->total_press_on }},
                @endforeach
            ]
        }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
</body>
</html>