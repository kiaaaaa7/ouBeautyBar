<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — {{ $title ?? 'OuBeautyBar' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --sage-dark:  #4a5a3a;
            --sage:       #6b7c52;
            --sage-light: #c8d5b9;
            --sage-pale:  #e8f0dc;
            --lavender:   #c4b5d4;
            --cream:      #f5f2e8;
            --cream-dark: #ede8d8;
            --text-dark:  #2c2c1e;
            --text-muted: #6b6b5a;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0ede3; color: var(--text-dark); display: flex; min-height: 100vh; }
    </style>
</head>
<body>

<aside style="width: 240px; background: var(--sage-dark); min-height: 100vh; flex-shrink: 0; display: flex; flex-direction: column;">
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--sage);">
        <div style="display: flex; align-items: center; gap: 10px;">
            <div style="width: 32px; height: 32px; background: var(--cream); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--sage-dark); font-size: 11px; font-weight: bold;">OU</div>
            <div>
                <p style="color: var(--cream); font-size: 14px;">Beauty Bar</p>
                <p style="color: var(--sage-light); font-size: 11px;">Admin Panel</p>
            </div>
        </div>
    </div>

    <nav style="padding: 1rem 0; flex: 1;">
        @php
            $navItems = [
                ['route' => 'admin.orders.index',    'label' => 'Pesanan',  'icon' => '📦'],
                ['route' => 'admin.products.index',  'label' => 'Produk',   'icon' => '💅'],
                ['route' => 'admin.categories.index','label' => 'Kategori', 'icon' => '🗂️'],
            ];
        @endphp
        @foreach($navItems as $item)
        @php $active = request()->routeIs($item['route'] . '*'); @endphp
        <a href="{{ route($item['route']) }}"
           style="display: flex; align-items: center; gap: 10px; padding: 10px 1.5rem; text-decoration: none; font-size: 14px;
                  background: {{ $active ? 'rgba(255,255,255,0.12)' : 'transparent' }};
                  color: {{ $active ? 'white' : 'var(--sage-light)' }};
                  border-left: 3px solid {{ $active ? 'var(--cream)' : 'transparent' }};">
            <span>{{ $item['icon'] }}</span> {{ $item['label'] }}
        </a>
        @endforeach
    </nav>

    <div style="padding: 1rem 1.5rem; border-top: 1px solid var(--sage);">
        <p style="font-size: 12px; color: var(--sage-light); margin-bottom: 8px;">{{ auth()->user()->name }}</p>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('home') }}" style="font-size: 12px; color: var(--sage-light); text-decoration: none;">← Toko</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; cursor: pointer; color: var(--sage-light); font-size: 12px;">Logout</button>
            </form>
        </div>
    </div>
</aside>

<div style="flex: 1; display: flex; flex-direction: column; min-width: 0;">
    <header style="background: white; border-bottom: 1px solid var(--cream-dark); padding: 0 2rem; height: 56px; display: flex; align-items: center; justify-content: space-between;">
        <h1 style="font-size: 16px; font-weight: bold; color: var(--text-dark);">{{ $title ?? 'Dashboard' }}</h1>
        <p style="font-size: 12px; color: var(--text-muted);">{{ now()->format('d F Y') }}</p>
    </header>

    @if(session('success'))
    <div style="background: var(--sage-pale); border-left: 4px solid var(--sage); padding: 10px 2rem; font-size: 13px; color: var(--sage-dark);">
        ✓ {{ session('success') }}
    </div>
    @endif
    @if($errors->any())
    <div style="background: #fde8e8; border-left: 4px solid #e57373; padding: 10px 2rem; font-size: 13px; color: #c62828;">
        @foreach($errors->all() as $error)<div>✗ {{ $error }}</div>@endforeach
    </div>
    @endif

    <main style="padding: 2rem; flex: 1;">
        {{ $slot }}
    </main>
</div>

</body>
</html>