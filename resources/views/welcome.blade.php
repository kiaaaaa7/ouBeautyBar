<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>OU Beauty Bar</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

        <style>
            *, ::before, ::after {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            :root {
                --blush:     #F2D4CC;
                --rose:      #C9856A;
                --deep-rose: #9E5A47;
                --nude:      #EDD9C8;
                --cream:     #FBF5F0;
                --gold:      #C9A96E;
                --dark:      #2C1A16;
                --muted:     #8C6A62;
            }

            html { scroll-behavior: smooth; }

            body {
                font-family: 'DM Sans', sans-serif;
                background: var(--cream);
                color: var(--dark);
                overflow-x: hidden;
                min-height: 100vh;
            }

            /* ── BACKGROUND ───────────────────────────────────── */
            .bg-layer {
                position: fixed;
                inset: 0;
                z-index: 0;
                pointer-events: none;
            }
            .bg-layer::before {
                content: '';
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(ellipse 80% 60% at 10% 20%, rgba(242,212,204,.55) 0%, transparent 60%),
                    radial-gradient(ellipse 60% 50% at 90% 80%, rgba(201,133,106,.18) 0%, transparent 55%),
                    radial-gradient(ellipse 40% 40% at 60% 10%, rgba(201,169,110,.12) 0%, transparent 50%);
            }
            /* soft noise texture */
            .bg-layer::after {
                content: '';
                position: absolute;
                inset: 0;
                opacity: .04;
                background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
                background-size: 200px 200px;
            }

            /* ── FLOATING PETALS ──────────────────────────────── */
            .petals {
                position: fixed;
                inset: 0;
                pointer-events: none;
                z-index: 0;
                overflow: hidden;
            }
            .petal {
                position: absolute;
                width: 8px;
                height: 14px;
                border-radius: 50% 50% 50% 0;
                opacity: 0;
                animation: fall linear infinite;
            }
            .petal:nth-child(1)  { left: 8%;  background: #F2C4B8; width:6px;  height:10px; animation-duration: 12s; animation-delay: 0s;  }
            .petal:nth-child(2)  { left: 22%; background: #E8A896; width:9px;  height:15px; animation-duration: 15s; animation-delay: 3s;  }
            .petal:nth-child(3)  { left: 38%; background: #F2D4CC; width:5px;  height:9px;  animation-duration: 11s; animation-delay: 6s;  }
            .petal:nth-child(4)  { left: 55%; background: #C9856A; width:7px;  height:12px; animation-duration: 14s; animation-delay: 1s;  }
            .petal:nth-child(5)  { left: 70%; background: #EDD9C8; width:8px;  height:13px; animation-duration: 13s; animation-delay: 8s;  }
            .petal:nth-child(6)  { left: 85%; background: #F2C4B8; width:6px;  height:10px; animation-duration: 16s; animation-delay: 4s;  }
            .petal:nth-child(7)  { left: 15%; background: #C9A96E; width:5px;  height:9px;  animation-duration: 18s; animation-delay: 10s; }
            .petal:nth-child(8)  { left: 48%; background: #E8A896; width:7px;  height:11px; animation-duration: 12s; animation-delay: 5s;  }
            .petal:nth-child(9)  { left: 65%; background: #F2D4CC; width:9px;  height:14px; animation-duration: 17s; animation-delay: 2s;  }
            .petal:nth-child(10) { left: 92%; background: #C9856A; width:6px;  height:10px; animation-duration: 14s; animation-delay: 7s;  }

            @keyframes fall {
                0%   { transform: translateY(-20px) rotate(0deg);   opacity: 0; }
                10%  { opacity: .7; }
                90%  { opacity: .4; }
                100% { transform: translateY(110vh) rotate(360deg); opacity: 0; }
            }

            /* ── NAV ──────────────────────────────────────────── */
            nav {
                position: fixed;
                top: 0; left: 0; right: 0;
                z-index: 100;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1.25rem 3rem;
                background: rgba(251,245,240,.85);
                backdrop-filter: blur(16px);
                border-bottom: 1px solid rgba(201,133,106,.12);
            }
            .nav-brand {
                font-family: 'Cormorant Garamond', serif;
                font-size: 1.5rem;
                font-weight: 300;
                letter-spacing: .12em;
                color: var(--dark);
                text-decoration: none;
            }
            .nav-brand span { color: var(--rose); }
            .nav-links {
                display: flex;
                align-items: center;
                gap: 2rem;
                list-style: none;
            }
            .nav-links a {
                font-size: .8rem;
                letter-spacing: .1em;
                text-transform: uppercase;
                color: var(--muted);
                text-decoration: none;
                transition: color .25s;
            }
            .nav-links a:hover { color: var(--rose); }
            .nav-cta {
                background: var(--rose);
                color: #fff !important;
                padding: .55rem 1.4rem;
                border-radius: 999px;
                transition: background .25s, transform .2s !important;
            }
            .nav-cta:hover {
                background: var(--deep-rose) !important;
                transform: translateY(-1px);
            }

            /* ── WRAPPER ──────────────────────────────────────── */
            .wrapper {
                position: relative;
                z-index: 1;
            }

            /* ── HERO ─────────────────────────────────────────── */
            .hero {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 7rem 2rem 4rem;
            }
            .hero-pill {
                display: inline-flex;
                align-items: center;
                gap: .5rem;
                background: rgba(201,133,106,.12);
                border: 1px solid rgba(201,133,106,.3);
                border-radius: 999px;
                padding: .35rem 1rem;
                font-size: .75rem;
                letter-spacing: .12em;
                text-transform: uppercase;
                color: var(--rose);
                margin-bottom: 1.75rem;
                animation: fadeUp .8s ease both;
            }
            .hero-title {
                font-family: 'Cormorant Garamond', serif;
                font-size: clamp(3.2rem, 9vw, 7.5rem);
                font-weight: 300;
                line-height: 1.05;
                color: var(--dark);
                letter-spacing: -.01em;
                animation: fadeUp .9s .1s ease both;
            }
            .hero-title em {
                font-style: italic;
                color: var(--rose);
            }
            .hero-sub {
                margin-top: 1.5rem;
                font-size: 1rem;
                color: var(--muted);
                letter-spacing: .03em;
                max-width: 440px;
                line-height: 1.7;
                animation: fadeUp .9s .2s ease both;
            }
            .hero-quote {
                margin-top: 1rem;
                font-family: 'Cormorant Garamond', serif;
                font-style: italic;
                font-size: 1.05rem;
                color: var(--rose);
                animation: fadeUp .9s .25s ease both;
            }
            .hero-actions {
                margin-top: 2.5rem;
                display: flex;
                gap: 1rem;
                flex-wrap: wrap;
                justify-content: center;
                animation: fadeUp .9s .35s ease both;
            }
            .btn-primary {
                background: var(--rose);
                color: #fff;
                text-decoration: none;
                padding: .85rem 2.2rem;
                border-radius: 999px;
                font-size: .85rem;
                letter-spacing: .08em;
                text-transform: uppercase;
                transition: background .25s, transform .2s, box-shadow .25s;
                box-shadow: 0 4px 20px rgba(201,133,106,.35);
            }
            .btn-primary:hover {
                background: var(--deep-rose);
                transform: translateY(-2px);
                box-shadow: 0 8px 28px rgba(201,133,106,.45);
            }
            .btn-secondary {
                background: transparent;
                color: var(--dark);
                text-decoration: none;
                padding: .85rem 2.2rem;
                border-radius: 999px;
                font-size: .85rem;
                letter-spacing: .08em;
                text-transform: uppercase;
                border: 1px solid rgba(44,26,22,.2);
                transition: border-color .25s, color .25s, transform .2s;
            }
            .btn-secondary:hover {
                border-color: var(--rose);
                color: var(--rose);
                transform: translateY(-2px);
            }

            /* scroll hint */
            .scroll-hint {
                margin-top: 4rem;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: .5rem;
                opacity: .45;
                animation: fadeUp .9s .5s ease both;
            }
            .scroll-hint span {
                font-size: .7rem;
                letter-spacing: .14em;
                text-transform: uppercase;
                color: var(--muted);
            }
            .scroll-line {
                width: 1px;
                height: 40px;
                background: linear-gradient(to bottom, var(--rose), transparent);
                animation: scrollPulse 1.8s ease-in-out infinite;
            }
            @keyframes scrollPulse {
                0%, 100% { opacity: .4; transform: scaleY(1); }
                50%       { opacity: 1;  transform: scaleY(1.2); }
            }

            /* ── STATS ────────────────────────────────────────── */
            .stats {
                padding: 4rem 2rem;
                display: flex;
                justify-content: center;
                gap: 0;
                flex-wrap: wrap;
            }
            .stat-item {
                padding: 2rem 3.5rem;
                text-align: center;
                border-right: 1px solid rgba(201,133,106,.18);
                animation: fadeUp .7s ease both;
            }
            .stat-item:last-child { border-right: none; }
            .stat-number {
                font-family: 'Cormorant Garamond', serif;
                font-size: 3rem;
                font-weight: 300;
                color: var(--rose);
                line-height: 1;
            }
            .stat-label {
                font-size: .75rem;
                letter-spacing: .12em;
                text-transform: uppercase;
                color: var(--muted);
                margin-top: .4rem;
            }

            /* ── DIVIDER ──────────────────────────────────────── */
            .divider {
                text-align: center;
                padding: 1rem 0;
                font-size: 1.4rem;
                letter-spacing: .5rem;
                color: var(--blush);
            }

            /* ── SECTION LABEL ────────────────────────────────── */
            .section-label {
                font-size: .7rem;
                letter-spacing: .2em;
                text-transform: uppercase;
                color: var(--rose);
                margin-bottom: .8rem;
                display: block;
            }
            .section-title {
                font-family: 'Cormorant Garamond', serif;
                font-size: clamp(2rem, 5vw, 3.2rem);
                font-weight: 300;
                color: var(--dark);
                line-height: 1.2;
            }
            .section-title em { font-style: italic; color: var(--rose); }

            /* ── SERVICES ─────────────────────────────────────── */
            .services {
                padding: 5rem 2rem;
                max-width: 1200px;
                margin: 0 auto;
            }
            .services-header {
                text-align: center;
                margin-bottom: 3.5rem;
            }
            .services-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
                gap: 1.5rem;
            }
            .service-card {
                background: rgba(255,255,255,.7);
                border: 1px solid rgba(201,133,106,.15);
                border-radius: 1.5rem;
                padding: 2rem;
                text-decoration: none;
                color: inherit;
                display: flex;
                flex-direction: column;
                gap: 1rem;
                transition: transform .3s, box-shadow .3s, border-color .3s;
                backdrop-filter: blur(8px);
                position: relative;
                overflow: hidden;
            }
            .service-card::before {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(135deg, rgba(242,212,204,.25) 0%, transparent 60%);
                opacity: 0;
                transition: opacity .3s;
            }
            .service-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 16px 48px rgba(201,133,106,.2);
                border-color: rgba(201,133,106,.4);
            }
            .service-card:hover::before { opacity: 1; }

            .service-icon {
                width: 3.5rem;
                height: 3.5rem;
                background: linear-gradient(135deg, var(--blush), var(--nude));
                border-radius: 1rem;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
            }
            .service-title {
                font-family: 'Cormorant Garamond', serif;
                font-size: 1.3rem;
                font-weight: 400;
                color: var(--dark);
            }
            .service-desc {
                font-size: .85rem;
                color: var(--muted);
                line-height: 1.65;
                flex: 1;
            }
            .service-arrow {
                display: inline-flex;
                align-items: center;
                gap: .4rem;
                font-size: .75rem;
                letter-spacing: .1em;
                text-transform: uppercase;
                color: var(--rose);
                margin-top: .5rem;
                transition: gap .25s;
            }
            .service-card:hover .service-arrow { gap: .7rem; }

            /* ── TESTIMONIAL ──────────────────────────────────── */
            .testimonial-section {
                padding: 5rem 2rem;
                text-align: center;
            }
            .testimonial-box {
                max-width: 680px;
                margin: 2.5rem auto 0;
                background: rgba(255,255,255,.6);
                border: 1px solid rgba(201,133,106,.18);
                border-radius: 2rem;
                padding: 3rem;
                backdrop-filter: blur(10px);
                position: relative;
            }
            .testimonial-box::before {
                content: '"';
                position: absolute;
                top: -1rem;
                left: 2.5rem;
                font-family: 'Cormorant Garamond', serif;
                font-size: 6rem;
                line-height: 1;
                color: var(--blush);
                pointer-events: none;
            }
            .testimonial-stars {
                color: var(--gold);
                font-size: 1.1rem;
                letter-spacing: .2em;
                margin-bottom: 1.2rem;
            }
            .testimonial-text {
                font-family: 'Cormorant Garamond', serif;
                font-size: 1.3rem;
                font-style: italic;
                color: var(--dark);
                line-height: 1.65;
                margin-bottom: 1.5rem;
            }
            .testimonial-author {
                font-size: .8rem;
                letter-spacing: .1em;
                text-transform: uppercase;
                color: var(--muted);
            }

            /* ── SOCIAL ───────────────────────────────────────── */
            .social-section {
                padding: 3rem 2rem;
                text-align: center;
            }
            .social-links {
                display: flex;
                justify-content: center;
                gap: 1rem;
                margin-top: 1.5rem;
                flex-wrap: wrap;
            }
            .social-btn {
                display: inline-flex;
                align-items: center;
                gap: .55rem;
                padding: .7rem 1.5rem;
                border-radius: 999px;
                font-size: .78rem;
                letter-spacing: .08em;
                text-transform: uppercase;
                text-decoration: none;
                border: 1px solid rgba(201,133,106,.25);
                color: var(--muted);
                transition: background .25s, color .25s, border-color .25s, transform .2s;
            }
            .social-btn:hover {
                background: var(--rose);
                color: #fff;
                border-color: var(--rose);
                transform: translateY(-2px);
            }

            /* ── FOOTER ───────────────────────────────────────── */
            footer {
                border-top: 1px solid rgba(201,133,106,.15);
                padding: 2rem 3rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 1rem;
            }
            .footer-brand {
                font-family: 'Cormorant Garamond', serif;
                font-size: 1.1rem;
                font-weight: 300;
                letter-spacing: .1em;
                color: var(--dark);
            }
            .footer-brand span { color: var(--rose); }
            .footer-copy {
                font-size: .75rem;
                color: var(--muted);
                letter-spacing: .05em;
            }

            /* ── ANIMATIONS ───────────────────────────────────── */
            @keyframes fadeUp {
                from { opacity: 0; transform: translateY(22px); }
                to   { opacity: 1; transform: translateY(0); }
            }

            /* Intersection-triggered animations */
            .reveal {
                opacity: 0;
                transform: translateY(28px);
                transition: opacity .7s ease, transform .7s ease;
            }
            .reveal.visible {
                opacity: 1;
                transform: translateY(0);
            }

            /* ── RESPONSIVE ───────────────────────────────────── */
            @media (max-width: 640px) {
                nav { padding: 1rem 1.5rem; }
                .nav-links { display: none; }
                .stat-item { padding: 1.5rem 2rem; border-right: none; border-bottom: 1px solid rgba(201,133,106,.15); }
                .stat-item:last-child { border-bottom: none; }
                footer { flex-direction: column; align-items: center; text-align: center; }
            }
        </style>
    </head>
    <body>

        <!-- Ambient background -->
        <div class="bg-layer"></div>

        <!-- Floating petals -->
        <div class="petals">
            <div class="petal"></div>
            <div class="petal"></div>
            <div class="petal"></div>
            <div class="petal"></div>
            <div class="petal"></div>
            <div class="petal"></div>
            <div class="petal"></div>
            <div class="petal"></div>
            <div class="petal"></div>
            <div class="petal"></div>
        </div>

        <!-- Navigation -->
        <nav>
            <a href="/" class="nav-brand">OU <span>Beauty</span> Bar</a>
            <ul class="nav-links">
                <li><a href="/katalog">Katalog</a></li>
                <li><a href="/booking">Booking</a></li>
                <li><a href="#testimoni">Testimoni</a></li>
                <li><a href="#tentang">Tentang</a></li>
                @if (Route::has('login'))
                    @auth
                        <li><a href="{{ url('/dashboard') }}" class="nav-cta">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Log in</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}" class="nav-cta">Daftar</a></li>
                        @endif
                    @endauth
                @endif
            </ul>
        </nav>

        <div class="wrapper">

            <!-- ── HERO ────────────────────────────── -->
            <section class="hero">
                <div class="hero-pill">
                    💅 &nbsp;Nail Art · Manicure · Pedicure
                </div>
                <h1 class="hero-title">
                    Express Your Style<br>Through <em>Beautiful</em> Nails
                </h1>
                <p class="hero-sub">
                    Temukan ratusan desain nail art eksklusif dan rasakan pengalaman perawatan kuku terbaik bersama OU Beauty Bar.
                </p>
                <p class="hero-quote">"Life is too short for boring nails 💅"</p>
                <div class="hero-actions">
                    <a href="/booking" class="btn-primary">Book Now</a>
                    <a href="/katalog" class="btn-secondary">Lihat Katalog</a>
                </div>
                <div class="scroll-hint">
                    <span>Scroll</span>
                    <div class="scroll-line"></div>
                </div>
            </section>

            <!-- ── STATS ───────────────────────────── -->
            <div class="stats reveal">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Happy Customers</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Desain Nail Art</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4.9★</div>
                    <div class="stat-label">Rating Pelanggan</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">3+</div>
                    <div class="stat-label">Tahun Berpengalaman</div>
                </div>
            </div>

            <div class="divider">✦ ✦ ✦</div>

            <!-- ── SERVICES ────────────────────────── -->
            <section class="services" id="tentang">
                <div class="services-header reveal">
                    <span class="section-label">Layanan Kami</span>
                    <h2 class="section-title">Semua yang Kamu <em>Butuhkan</em></h2>
                </div>
                <div class="services-grid">

                    <a href="/katalog" class="service-card reveal">
                        <div class="service-icon">🎨</div>
                        <div class="service-title">Katalog Nail Art</div>
                        <p class="service-desc">
                            Jelajahi koleksi lengkap desain nail art kami — dari minimalis elegan hingga bold & colorful. Selalu update dengan tren terkini.
                        </p>
                        <span class="service-arrow">Lihat Semua →</span>
                    </a>

                    <a href="/booking" class="service-card reveal">
                        <div class="service-icon">📅</div>
                        <div class="service-title">Booking Appointment</div>
                        <p class="service-desc">
                            Pesan jadwal kamu dengan mudah — pilih layanan, tanggal, dan waktu. Tidak perlu antri, langsung dilayani saat tiba.
                        </p>
                        <span class="service-arrow">Book Sekarang →</span>
                    </a>

                    <a href="#testimoni" class="service-card reveal">
                        <div class="service-icon">💬</div>
                        <div class="service-title">Testimoni Pelanggan</div>
                        <p class="service-desc">
                            Lihat apa kata pelanggan setia kami. Kepuasan kamu adalah prioritas utama OU Beauty Bar sejak pertama dibuka.
                        </p>
                        <span class="service-arrow">Baca Ulasan →</span>
                    </a>

                    <div class="service-card reveal">
                        <div class="service-icon">✨</div>
                        <div class="service-title">Tentang Kami</div>
                        <p class="service-desc">
                            OU Beauty Bar hadir untuk menemani setiap momen spesialmu. Studio nail art profesional dengan produk berkualitas tinggi dan artist berpengalaman.
                        </p>
                        <span class="service-arrow">Selengkapnya →</span>
                    </div>

                </div>
            </section>

            <div class="divider">✦ ✦ ✦</div>

            <!-- ── TESTIMONIAL ─────────────────────── -->
            <section class="testimonial-section reveal" id="testimoni">
                <span class="section-label">Kata Mereka</span>
                <h2 class="section-title">Pelanggan <em>Bahagia</em></h2>
                <div class="testimonial-box">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-text">
                        "Nail art-nya rapi banget dan hasilnya jauh melebihi ekspektasi. Pelayanannya ramah, tempatnya nyaman, dan harganya sangat worth it. Udah jadi langganan tetap!"
                    </p>
                    <span class="testimonial-author">— Salsabila R., Pelanggan Setia</span>
                </div>
            </section>

            <!-- ── SOCIAL ──────────────────────────── -->
            <section class="social-section reveal">
                <span class="section-label">Ikuti Kami</span>
                <h2 class="section-title" style="font-size:1.8rem">Stay Connected</h2>
                <div class="social-links">
                    <a href="#" class="social-btn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <circle cx="12" cy="12" r="4"/>
                            <circle cx="17.5" cy="6.5" r="1.2" fill="currentColor" stroke="none"/>
                        </svg>
                        Instagram
                    </a>
                    <a href="#" class="social-btn">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.498 14.382c-.301-.15-1.767-.867-2.04-.966-.273-.101-.473-.15-.673.15-.197.295-.771.964-.944 1.162-.175.195-.349.21-.646.075-.3-.15-1.263-.465-2.403-1.485-.888-.795-1.484-1.77-1.66-2.07-.174-.3-.019-.465.13-.615.136-.135.301-.345.451-.523.146-.181.194-.301.297-.496.1-.21.049-.375-.025-.524-.075-.15-.672-1.62-.922-2.206-.24-.584-.487-.51-.672-.51-.172-.015-.371-.015-.571-.015-.2 0-.523.074-.797.359-.273.3-1.045 1.02-1.045 2.475s1.07 2.865 1.219 3.075c.149.18 2.105 3.195 5.1 4.485.714.3 1.27.48 1.704.629.714.227 1.365.195 1.88.121.574-.091 1.767-.721 2.016-1.426.255-.705.255-1.29.18-1.425-.074-.135-.27-.21-.57-.345z"/>
                            <path d="M20.52 3.449C18.24 1.245 15.24 0 12.045 0 5.463 0 .104 5.334.101 11.893c0 2.096.549 4.14 1.595 5.945L0 24l6.335-1.652c1.746.943 3.71 1.444 5.71 1.447h.006c6.585 0 11.946-5.336 11.949-11.896 0-3.176-1.24-6.165-3.48-8.4z"/>
                        </svg>
                        WhatsApp
                    </a>
                    <a href="#" class="social-btn">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.3 6.3 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.94a8.22 8.22 0 004.8 1.53V7.04a4.85 4.85 0 01-1.03-.35z"/>
                        </svg>
                        TikTok
                    </a>
                </div>
            </section>

            <!-- ── FOOTER ──────────────────────────── -->
            <footer>
                <div class="footer-brand">OU <span>Beauty</span> Bar</div>
                <div class="footer-copy">
                    &copy; {{ date('Y') }} OU Beauty Bar — Bandung, West Java
                </div>
            </footer>

        </div><!-- /wrapper -->

        <script>
            // Intersection Observer for reveal animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, i) => {
                    if (entry.isIntersecting) {
                        // stagger cards inside a grid
                        entry.target.style.transitionDelay = '0s';
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

            // Stagger service cards
            document.querySelectorAll('.service-card').forEach((card, i) => {
                card.style.transitionDelay = `${i * 0.08}s`;
            });
        </script>
    </body>
</html>