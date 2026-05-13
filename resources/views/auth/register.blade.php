<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar — OU Beauty Bar</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root { --olive:#5C6B3A; --olive-light:#7A8C4E; --olive-pale:#E8EDD8; --lilac:#C4B5D4; --lilac-deep:#9B87B0; --lilac-pale:#F0EBF7; --cream:#FAF8F5; --dark:#2C2C2C; --gray:#6B6B6B; }
    body { font-family: 'Jost', sans-serif; min-height: 100vh; display: grid; grid-template-columns: 1fr 1fr; }
    .left-panel { background: var(--lilac-deep); display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 4rem; text-align: center; position: relative; overflow: hidden; }
    .left-panel::before { content: ''; position: absolute; inset: 0; background: url('/images/cream_strip.jpg') center/cover no-repeat; opacity: .1; }
    .left-deco { position: relative; z-index: 1; }
    .left-logo { font-family: 'Playfair Display', serif; font-size: 2.5rem; font-weight: 600; color: white; margin-bottom: .5rem; display: flex; align-items: center; gap: .8rem; justify-content: center; }
    .logo-badge { width: 52px; height: 52px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--lilac-deep); font-size: 1rem; font-weight: 700; }
    .left-tagline { color: rgba(255,255,255,.75); font-size: .95rem; line-height: 1.8; margin-top: 1rem; }
    .left-nails { display: flex; gap: .8rem; margin-top: 2.5rem; justify-content: center; }
    .nail-pill { width: 22px; height: 34px; border-radius: 50% 50% 35% 35%/55% 55% 45% 45%; box-shadow: 0 4px 12px rgba(0,0,0,.2); }
    .nail-pill:nth-child(1){background:linear-gradient(160deg,#f2c4c4,#e8a0a0)}
    .nail-pill:nth-child(2){background:linear-gradient(160deg,#C4B5D4,#9B87B0)}
    .nail-pill:nth-child(3){background:linear-gradient(160deg,#E8EDD8,#b8c98a)}
    .nail-pill:nth-child(4){background:linear-gradient(160deg,#f2e4c4,#e8cfa0)}
    .nail-pill:nth-child(5){background:linear-gradient(160deg,#d4c4f2,#b8a0e8)}
    .right-panel { background: var(--cream); display: flex; align-items: center; justify-content: center; padding: 4rem; }
    .form-box { width: 100%; max-width: 400px; }
    .form-title { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 400; margin-bottom: .3rem; }
    .form-title em { font-style: italic; color: var(--lilac-deep); }
    .form-sub { font-size: .85rem; color: var(--gray); margin-bottom: 2.5rem; }
    .form-group { margin-bottom: 1.2rem; }
    label { display: block; font-size: .7rem; letter-spacing: .12em; text-transform: uppercase; color: var(--gray); margin-bottom: .45rem; }
    input { width: 100%; background: white; border: 1.5px solid rgba(92,107,58,.2); color: var(--dark); padding: .85rem 1rem; font-family: 'Jost', sans-serif; font-size: .9rem; outline: none; border-radius: 6px; transition: border-color .2s; }
    input:focus { border-color: var(--lilac-deep); box-shadow: 0 0 0 3px rgba(155,135,176,.1); }
    .input-error { border-color: #e53935 !important; }
    .error-msg { font-size: .75rem; color: #e53935; margin-top: .3rem; display: block; }
    .btn-submit { width: 100%; background: var(--lilac-deep); color: white; padding: .9rem; font-size: .82rem; letter-spacing: .1em; text-transform: uppercase; border: none; cursor: pointer; font-family: 'Jost', sans-serif; border-radius: 6px; transition: background .2s; margin-bottom: 1.5rem; }
    .btn-submit:hover { background: var(--olive); }
    .divider { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
    .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: rgba(92,107,58,.15); }
    .divider span { font-size: .75rem; color: var(--gray); }
    .login-link { text-align: center; font-size: .85rem; color: var(--gray); }
    .login-link a { color: var(--lilac-deep); text-decoration: none; font-weight: 500; }
    .login-link a:hover { text-decoration: underline; }
    @media(max-width:768px) { body { grid-template-columns: 1fr; } .left-panel { display: none; } .right-panel { padding: 2rem; } }
  </style>
</head>
<body>

<div class="left-panel">
  <div class="left-deco">
    <div class="left-logo"><div class="logo-badge">OU</div> Beauty Bar</div>
    <p class="left-tagline">Bergabung dan nikmati<br>pengalaman nail art terbaik ✨<br>Bandung · @ou.beautybar</p>
    <div class="left-nails">
      <div class="nail-pill"></div><div class="nail-pill"></div><div class="nail-pill"></div>
      <div class="nail-pill"></div><div class="nail-pill"></div>
    </div>
  </div>
</div>

<div class="right-panel">
  <div class="form-box">
    <h1 class="form-title">Buat <em>Akun</em></h1>
    <p class="form-sub">Daftar gratis dan mulai booking nail art impianmu 💅</p>

    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name') }}"
               class="{{ $errors->has('name') ? 'input-error' : '' }}"
               placeholder="Nama kamu" autofocus/>
        @error('name') <span class="error-msg">{{ $message }}</span> @enderror
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}"
               class="{{ $errors->has('email') ? 'input-error' : '' }}"
               placeholder="kamu@email.com"/>
        @error('email') <span class="error-msg">{{ $message }}</span> @enderror
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password"
               class="{{ $errors->has('password') ? 'input-error' : '' }}"
               placeholder="Min. 8 karakter"/>
        @error('password') <span class="error-msg">{{ $message }}</span> @enderror
      </div>
      <div class="form-group">
        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" placeholder="Ulangi password"/>
      </div>
      <button type="submit" class="btn-submit">Buat Akun</button>
    </form>

    <div class="divider"><span>atau</span></div>
    <p class="login-link">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
  </div>
</div>

</body>
</html>