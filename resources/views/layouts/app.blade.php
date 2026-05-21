<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ?? 'OU Beauty Bar' }}</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

@vite(['resources/css/app.css','resources/js/app.js'])

<style>
:root{
    --olive:#5C6B3A;
    --olive-light:#7A8C4E;
    --olive-pale:#E8EDD8;
    --lilac:#C4B5D4;
    --cream:#FAF8F5;
    --bg:#F2F4EE;
    --dark:#2C2C2C;
    --gray:#6B6B6B;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Jost',sans-serif;
    background:var(--bg);
    color:var(--dark);
}

.ou-navbar{
    position:sticky;
    top:0;
    z-index:999;
    background:rgba(250,248,245,.95);
    backdrop-filter:blur(12px);

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:20px 40px;
    border-bottom:1px solid rgba(0,0,0,.05);
}

.ou-nav-logo{
    display:flex;
    align-items:center;
    gap:10px;
    text-decoration:none;
    color:var(--olive);
    font-size:1.4rem;
    font-family:'Playfair Display',serif;
}

.ou-logo-badge{
    width:38px;
    height:38px;
    border-radius:50%;
    background:linear-gradient(
    135deg,
    var(--olive),
    var(--olive-light)
    );

    display:flex;
    justify-content:center;
    align-items:center;

    color:white;
    font-size:.7rem;
    font-weight:bold;
}

.ou-nav-links{
    display:flex;
    align-items:center;
    gap:30px;
}

.ou-nav-links a{
    text-decoration:none;
    color:var(--gray);
    transition:.3s;
}

.ou-nav-links a:hover{
    color:var(--olive);
}

.ou-nav-actions{
    display:flex;
    align-items:center;
    gap:10px;
}

.ou-btn{
    padding:10px 18px;
    border-radius:8px;
    text-decoration:none;
    border:none;
    cursor:pointer;
}

.ou-btn-outline{
    border:1px solid var(--olive);
    color:var(--olive);
    background:white;
}

.ou-btn-primary{
    background:var(--olive);
    color:white;
}

.ou-flash{
    margin:20px auto;
    width:90%;
    padding:15px;
    border-radius:10px;
}

.success{
    background:#e9f4df;
}

.error{
    background:#ffe3e3;
}

footer{
    margin-top:70px;
    background:linear-gradient(
    180deg,
    #32401e,
    #556639
    );

    color:white;
    padding:50px;
}

.footer-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:30px;
    max-width:1200px;
    margin:auto;
}

.footer-title{
    margin-bottom:15px;
}

.footer-grid a{
    color:white;
    text-decoration:none;
}

.footer-grid p{
    margin-bottom:10px;
}

@media(max-width:768px){

.footer-grid{
grid-template-columns:1fr;
}

.ou-navbar{
flex-direction:column;
gap:20px;
}

.ou-nav-links{
flex-wrap:wrap;
justify-content:center;
}

}
</style>

@stack('styles')

</head>

<body>

{{-- NAVBAR --}}
<nav class="ou-navbar">

<a href="{{ route('home') }}"
class="ou-nav-logo">

<div class="ou-logo-badge">
OU
</div>

Beauty Bar

</a>


<div class="ou-nav-links">

<a href="{{ route('products.index') }}">
Katalog
</a>

<a href="{{ route('products.index') }}?type=custom">
Custom
</a>

@auth

<a href="{{ route('orders.index') }}">
Pesanan
</a>

@if(auth()->user()->is_admin)

<a href="{{ route('admin.orders.index') }}">
Admin
</a>

@endif

@endauth

</div>


<div class="ou-nav-actions">

@auth

<div>

{{ auth()->user()->name }}

</div>

<form action="{{ route('logout') }}"
method="POST">

@csrf

<button
type="submit"
class="ou-btn ou-btn-outline">

Logout

</button>

</form>

@else

<a
href="{{ route('login') }}"
class="ou-btn ou-btn-outline">

Login

</a>

<a
href="{{ route('register') }}"
class="ou-btn ou-btn-primary">

Daftar

</a>

@endauth

</div>

</nav>


{{-- FLASH MESSAGE --}}

<div style="width:90%;margin:auto;">

@if(session('success'))

<div class="ou-flash success">

✓ {{ session('success') }}

</div>

@endif


@if($errors->any())

<div class="ou-flash error">

@foreach($errors->all() as $error)

<div>

✗ {{ $error }}

</div>

@endforeach

</div>

@endif

</div>


{{-- CONTENT --}}

<main>

{{ $slot }}

</main>


{{-- FOOTER --}}

<footer>

<div class="footer-grid">

<div>

<h3 class="footer-title">
OU Beauty Bar
</h3>

<p>
Press on nail premium handmade
</p>

</div>


<div>

<h3 class="footer-title">
Menu
</h3>

<p>
<a href="{{ route('products.index') }}">
Katalog
</a>
</p>

<p>
<a href="{{ route('products.index') }}?type=custom">
Custom Order
</a>
</p>

@auth
<p>
<a href="{{ route('orders.index') }}">
Pesanan Saya
</a>
</p>
@endauth

</div>


<div>

<h3 class="footer-title">
Kontak
</h3>

<p>
WhatsApp:
+62 812-3456-7890
</p>

<p>
Instagram:
@oubeautybar
</p>

<p>
Bandung, Jawa Barat
</p>

</div>

</div>

<div
style="
text-align:center;
margin-top:40px;
border-top:1px solid rgba(255,255,255,.2);
padding-top:20px;
">

© {{ date('Y') }}
OU Beauty Bar

</div>

</footer>

@stack('scripts')

</body>
</html>