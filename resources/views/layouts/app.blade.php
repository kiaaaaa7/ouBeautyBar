<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'OuBeautyBar' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --sage-dark:   #4a5a3a;
            --sage:        #6b7c52;
            --sage-mid:    #8a9e6e;
            --sage-light:  #c8d5b9;
            --sage-pale:   #e8f0dc;
            --lavender:    #c4b5d4;
            --lavender-light: #e8e0f0;
            --lilac-bg:    #e8e4f0;
            --cream:       #f5f2e8;
            --cream-dark:  #ede8d8;
            --text-dark:   #2c2c1e;
            --text-muted:  #6b6b5a;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Georgia', serif;
            background-color: var(--cream);
            color: var(--text-dark);
        }
        .font-sans { font-family: 'Arial', sans-serif; }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav style="background: var(--cream); border-bottom: 1px solid var(--cream-dark); position: sticky; top: 0; z-index: 50; padding: 0 2rem;">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; height: 64px;">

        {{-- Logo --}}
        <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
            <div style="width: 36px; height: 36px; background: var(--sage-dark); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 13px; font-weight: bold; font-family: Arial;">OU</div>
            <span style="font-size: 18px; color: var(--text-dark); letter-spacing: 0.5px;">Beauty Bar</span>
        </a>

        {{-- Nav Links --}}
        <div style="display: flex; align-items: center; gap: 2rem;">
            <a href="{{ route('products.index') }}" style="text-decoration: none; color: var(--text-muted); font-size: 14px; font-family: Arial;">Katalog</a>
            <a href="{{ route('products.index') }}?type=custom" style="text-decoration: none; color: var(--text-muted); font-size: 14px; font-family: Arial;">Custom</a>

            @auth
                <a href="{{ route('orders.index') }}" style="text-decoration: none; color: var(--text-muted); font-size: 14px; font-family: Arial;">Pesanan</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; cursor: pointer; color: var(--text-muted); font-size: 14px; font-family: Arial;">Logout</button>
                </form>
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.orders.index') }}"
                       style="background: var(--sage-dark); color: white; padding: 8px 18px; text-decoration: none; font-size: 13px; font-family: Arial; letter-spacing: 1px;">
                        ADMIN
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" style="text-decoration: none; color: var(--text-muted); font-size: 14px; font-family: Arial;">Login</a>
                <a href="{{ route('register') }}"
                   style="background: var(--sage-dark); color: white; padding: 8px 20px; text-decoration: none; font-size: 13px; font-family: Arial; letter-spacing: 1px;">
                    DAFTAR
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- FLASH MESSAGES --}}
@if(session('success'))
    <div style="background: var(--sage-pale); border-left: 4px solid var(--sage); padding: 12px 2rem; font-family: Arial; font-size: 14px; color: var(--sage-dark);">
        ✓ {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div style="background: #fde8e8; border-left: 4px solid #e57373; padding: 12px 2rem; font-family: Arial; font-size: 14px; color: #c62828;">
        @foreach($errors->all() as $error)
            <div>✗ {{ $error }}</div>
        @endforeach
    </div>
@endif

{{-- MAIN CONTENT --}}
<main>
    {{ $slot }}
</main>

{{-- FOOTER --}}
<footer style="background: var(--sage-dark); color: var(--sage-pale); padding: 3rem 2rem; margin-top: 4rem;">
    <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 2rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1rem;">
                <div style="width: 32px; height: 32px; background: var(--cream); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--sage-dark); font-size: 12px; font-weight: bold; font-family: Arial;">OU</div>
                <span style="font-size: 16px;">Beauty Bar</span>
            </div>
            <p style="font-family: Arial; font-size: 13px; color: var(--sage-light); line-height: 1.6;">Press on nail premium handmade. Ready stock & custom order tersedia.</p>
        </div>
        <div>
            <p style="font-family: Arial; font-size: 12px; letter-spacing: 1px; color: var(--sage-light); margin-bottom: 1rem;">MENU</p>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <a href="{{ route('products.index') }}" style="color: var(--cream); text-decoration: none; font-family: Arial; font-size: 13px;">Katalog</a>
                <a href="{{ route('products.index') }}?type=custom" style="color: var(--cream); text-decoration: none; font-family: Arial; font-size: 13px;">Custom Order</a>
                @auth
                    <a href="{{ route('orders.index') }}" style="color: var(--cream); text-decoration: none; font-family: Arial; font-size: 13px;">Pesanan Saya</a>
                @endauth
            </div>
        </div>
        <div>
            <p style="font-family: Arial; font-size: 12px; letter-spacing: 1px; color: var(--sage-light); margin-bottom: 1rem;">KONTAK</p>
            <p style="font-family: Arial; font-size: 13px; color: var(--cream); line-height: 1.8;">
                WhatsApp: <a href="https://wa.me/6281234567890" style="color: var(--sage-pale);">+62 812-3456-7890</a><br>
                Instagram: @oubeautybar<br>
                Bandung, Jawa Barat
            </p>
        </div>
    </div>
    <div style="max-width: 1200px; margin: 2rem auto 0; border-top: 1px solid var(--sage); padding-top: 1.5rem; font-family: Arial; font-size: 12px; color: var(--sage-light);">
        © {{ date('Y') }} OuBeautyBar. All rights reserved.
    </div>
</footer>

</body>
</html>