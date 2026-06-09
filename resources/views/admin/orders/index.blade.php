<x-admin-layout>
    <x-slot name="title">Daftar Pesanan</x-slot>

    <style>
        /* ── STATUS CARDS ── */
        .order-stats {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: .9rem;
            margin-bottom: 1.2rem;
        }
        .os-card {
            text-decoration: none;
            display: flex; flex-direction: column; align-items: center;
            padding: 1.1rem .8rem;
            border: 1px solid transparent;
            border-radius: 3px;
            transition: transform .22s, box-shadow .22s, border-color .22s;
            position: relative; overflow: hidden;
        }
        .os-card::after {
            content: '';
            position: absolute; bottom: 0; left: 0; right: 0;
            height: 3px;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .3s ease;
        }
        .os-card:hover { transform: translateY(-4px); box-shadow: 0 8px 22px rgba(0,0,0,.1); }
        .os-card:hover::after { transform: scaleX(1); }
        .os-card.active-filter { transform: translateY(-3px); box-shadow: 0 6px 18px rgba(0,0,0,.12); }
        .os-card.active-filter::after { transform: scaleX(1); }
        .os-icon { font-size: 1.6rem; margin-bottom: .5rem; }
        .os-num {
            font-size: 1.9rem; font-weight: 700; line-height: 1;
            font-variant-numeric: tabular-nums;
        }
        .os-label { font-size: .65rem; letter-spacing: .1em; text-transform: uppercase; margin-top: .25rem; opacity: .85; }

        /* Progress bars under stats */
        .os-progress { margin-bottom: 1.4rem; }
        .osp-row { display: flex; align-items: center; gap: .8rem; margin-bottom: .5rem; }
        .osp-label { font-size: .72rem; color: var(--text-muted); width: 90px; flex-shrink: 0; }
        .osp-bar-bg { flex: 1; height: 5px; background: #eee; border-radius: 99px; overflow: hidden; }
        .osp-bar-fill { height: 100%; border-radius: 99px; width: 0%; transition: width .9s ease; }
        .osp-pct { font-size: .7rem; color: var(--text-muted); width: 36px; text-align: right; }

        /* Reminder banner */
        .reminder-banner {
            display: flex; align-items: center; gap: .8rem;
            padding: .75rem 1.2rem;
            background: #fff9e6;
            border-left: 4px solid #c0892a;
            margin-bottom: 1.2rem;
            font-size: .84rem; color: #856404;
            animation: bannerIn .4s ease;
        }
        @keyframes bannerIn { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:translateY(0)} }
        .reminder-banner a { color: #856404; font-weight: 600; text-underline-offset: 2px; }
        .reminder-close { margin-left: auto; background: none; border: none; cursor: pointer; font-size: 1rem; color: #c0892a; opacity: .6; transition: opacity .2s; }
        .reminder-close:hover { opacity: 1; }

        /* ── FILTER BOX ── */
        .filter-box {
            background: white; border: 1px solid var(--cream-dark);
            padding: 1.1rem 1.3rem; margin-bottom: 1.3rem;
        }
        .filter-form { display: flex; gap: .9rem; flex-wrap: wrap; align-items: flex-end; }
        .filter-group label { display: block; font-size: 10px; color: var(--text-muted); margin-bottom: 3px; letter-spacing: .5px; }
        .filter-select, .filter-input {
            padding: .5rem .8rem; font-size: .82rem; font-family: inherit;
            border: 1px solid var(--cream-dark); background: var(--cream, #faf9f7);
            outline: none; transition: border-color .2s, box-shadow .2s;
        }
        .filter-select:focus, .filter-input:focus { border-color: var(--sage-dark); box-shadow: 0 0 0 3px rgba(92,107,58,.08); }
        .search-input-wrap { position: relative; flex: 1; min-width: 200px; }
        .search-icon-abs { position: absolute; left: .65rem; top: 50%; transform: translateY(-50%); font-size: .8rem; pointer-events: none; }
        .search-input-wrap .filter-input { width: 100%; padding-left: 2.1rem; }
        .btn-filter { background: var(--sage-dark); color: white; padding: .52rem 1.4rem; border: none; cursor: pointer; font-size: .78rem; letter-spacing: .08em; text-transform: uppercase; transition: background .2s; }
        .btn-filter:hover { filter: brightness(1.1); }
        .btn-reset { padding: .52rem 1rem; border: 1px solid var(--cream-dark); color: var(--text-muted); font-size: .78rem; text-decoration: none; transition: border-color .2s; }
        .btn-reset:hover { border-color: var(--sage-dark); color: var(--sage-dark); }

        /* ── TABLE ── */
        .order-table-wrap { background: white; border: 1px solid var(--cream-dark); overflow: hidden; }
        .order-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .order-table thead tr {
            background: var(--cream, #f8f6f2);
            border-bottom: 1px solid var(--cream-dark);
            position: sticky; top: 0; z-index: 10;
        }
        .order-table th {
            padding: .7rem 1rem; text-align: left;
            font-size: 10.5px; letter-spacing: .5px; color: var(--text-muted);
            white-space: nowrap;
        }
        .order-table tbody tr {
            border-bottom: 1px solid var(--cream-dark);
            transition: background .16s, transform .18s, box-shadow .18s;
        }
        .order-table tbody tr:hover {
            background: var(--cream, #f8f6f2) !important;
            transform: translateX(4px);
            box-shadow: -4px 0 0 var(--sage-dark);
        }
        .order-table td { padding: .65rem 1rem; vertical-align: middle; }

        /* Order number badge */
        .order-num-badge {
            display: inline-block;
            background: var(--sage-pale, #e8eddc); color: var(--sage-dark);
            padding: .25rem .65rem; font-size: .75rem; font-weight: 700;
            letter-spacing: .04em;
        }

        /* Buyer avatar */
        .buyer-wrap { display: flex; align-items: center; gap: .6rem; }
        .buyer-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: .82rem; font-weight: 700; flex-shrink: 0;
            color: white;
        }
        .buyer-name { font-size: 13px; color: var(--text-dark, #2c2c2c); margin-bottom: 1px; }
        .buyer-wa { font-size: 11px; color: var(--text-muted); }

        /* Status badge with icon */
        .status-badge {
            display: inline-flex; align-items: center; gap: .3rem;
            padding: .28rem .75rem; font-size: 11px; letter-spacing: .3px;
            white-space: nowrap;
        }

        /* Payment badge */
        .pay-badge {
            display: inline-flex; align-items: center; gap: .3rem;
            font-size: 11px; color: var(--text-muted);
        }
        .proof-tag {
            display: block; font-size: 10px; color: #856404;
            margin-top: 2px;
        }

        /* Items count chip */
        .items-chip {
            display: inline-flex; align-items: center; gap: .2rem;
            background: #f5f5f5; padding: .2rem .6rem; font-size: 11px;
            color: var(--text-muted);
        }

        /* Action */
        .btn-detail {
            background: var(--sage-dark); color: white;
            padding: 5px 14px; text-decoration: none; font-size: 11px;
            letter-spacing: .5px; transition: background .2s, transform .15s;
            display: inline-block;
        }
        .btn-detail:hover { filter: brightness(1.12); transform: translateY(-1px); }

        /* Empty state */
        .empty-orders { text-align: center; padding: 4rem 2rem; color: var(--text-muted); }
        .empty-orders-icon { font-size: 3rem; margin-bottom: 1rem; opacity: .35; }
        .empty-orders h3 { font-size: 1rem; margin-bottom: .3rem; color: var(--text-dark, #2c2c2c); }

        @media(max-width:900px) {
            .order-stats { grid-template-columns: repeat(3,1fr); }
            .os-progress { display: none; }
        }
        @media(max-width:560px) {
            .order-stats { grid-template-columns: repeat(2,1fr); }
        }
    </style>

    @php
        $statItems = [
            ['label'=>'Pending',      'status'=>'pending',    'color'=>'#856404', 'bg'=>'#fff9e6', 'icon'=>'⏳', 'bar'=>'#c0892a'],
            ['label'=>'Dikonfirmasi', 'status'=>'confirmed',  'color'=>'#0c4a9e', 'bg'=>'#e6f0ff', 'icon'=>'✅', 'bar'=>'#0c4a9e'],
            ['label'=>'Diproses',     'status'=>'processing', 'color'=>'#4a2c6a', 'bg'=>'#f0e6ff', 'icon'=>'📦', 'bar'=>'#6a4c93'],
            ['label'=>'Dikirim',      'status'=>'shipped',    'color'=>'#3730a3', 'bg'=>'#e6e8ff', 'icon'=>'🚚', 'bar'=>'#3730a3'],
            ['label'=>'Selesai',      'status'=>'completed',  'color'=>'#4a5a3a', 'bg'=>'#e8f0dc', 'icon'=>'🎉', 'bar'=>'#5C6B3A'],
            ['label'=>'Dibatalkan',   'status'=>'cancelled',  'color'=>'#c62828', 'bg'=>'#fde8e8', 'icon'=>'❌', 'bar'=>'#c62828'],
        ];
        $totalOrders = array_sum(array_column($statItems, 'status') ? array_map(fn($s) => $statusCounts[$s['status']] ?? 0, $statItems) : []);
        $totalOrders = collect($statItems)->sum(fn($s) => $statusCounts[$s['status']] ?? 0);
        $pendingCount = $statusCounts['pending'] ?? 0;

        /* avatar colors */
        $avatarColors = ['#5C6B3A','#9B87B0','#c0892a','#0c4a9e','#c62828','#3730a3','#4a5a3a','#6a4c93'];
    @endphp

    {{-- REMINDER BANNER --}}
    @if($pendingCount > 0)
    <div class="reminder-banner" id="reminderBanner">
        <span>⚠️</span>
        <span>
            Terdapat <strong>{{ $pendingCount }} pesanan</strong> yang menunggu konfirmasi.
            <a href="?status=pending">Lihat sekarang →</a>
        </span>
        <button class="reminder-close" onclick="this.closest('.reminder-banner').remove()">×</button>
    </div>
    @endif

    {{-- STAT CARDS --}}
    <div class="order-stats">
        @foreach($statItems as $s)
        @php $cnt = $statusCounts[$s['status']] ?? 0; @endphp
        <a href="{{ route('admin.orders.index') }}?status={{ $s['status'] }}"
           class="os-card {{ request('status') === $s['status'] ? 'active-filter' : '' }}"
           style="background:{{ $s['bg'] }};border-color:{{ $s['color'] }}22;">
            <style>.os-card[href*="{{ $s['status'] }}"]::after{background:{{ $s['bar'] }};}</style>
            <span class="os-icon">{{ $s['icon'] }}</span>
            <span class="os-num" style="color:{{ $s['color'] }};" data-target="{{ $cnt }}">0</span>
            <span class="os-label" style="color:{{ $s['color'] }};">{{ $s['label'] }}</span>
        </a>
        @endforeach
    </div>

    {{-- PROGRESS BARS --}}
    @if($totalOrders > 0)
    <div class="os-progress">
        @foreach($statItems as $s)
        @php $cnt = $statusCounts[$s['status']] ?? 0; $pct = $totalOrders > 0 ? round($cnt/$totalOrders*100) : 0; @endphp
        @if($cnt > 0)
        <div class="osp-row">
            <span class="osp-label">{{ $s['label'] }}</span>
            <div class="osp-bar-bg">
                <div class="osp-bar-fill" style="background:{{ $s['bar'] }}" data-width="{{ $pct }}%"></div>
            </div>
            <span class="osp-pct">{{ $pct }}%</span>
        </div>
        @endif
        @endforeach
    </div>
    @endif

    {{-- FILTER --}}
    <div class="filter-box">
        <form method="GET" class="filter-form">
            <div class="filter-group">
                <label>STATUS</label>
                <select name="status" class="filter-select">
                    <option value="">Semua</option>
                    @foreach($statItems as $s)
                    <option value="{{ $s['status'] }}" {{ request('status')===$s['status'] ? 'selected' : '' }}>
                        {{ $s['icon'] }} {{ $s['label'] }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label>PEMBAYARAN</label>
                <select name="payment" class="filter-select">
                    <option value="">Semua</option>
                    <option value="transfer" {{ request('payment')==='transfer' ? 'selected' : '' }}>🏦 Transfer</option>
                    <option value="qris"     {{ request('payment')==='qris'     ? 'selected' : '' }}>📱 QRIS</option>
                    <option value="cod"      {{ request('payment')==='cod'      ? 'selected' : '' }}>💵 COD</option>
                </select>
            </div>
            <div class="filter-group search-input-wrap">
                <label>CARI</label>
                <span class="search-icon-abs">🔍</span>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="No. pesanan / nama / WA..." class="filter-input"/>
            </div>
            <button type="submit" class="btn-filter">Filter</button>
            <a href="{{ route('admin.orders.index') }}" class="btn-reset">Reset</a>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="order-table-wrap">
        <table class="order-table">
            <thead>
                <tr>
                    <th>NO. PESANAN</th>
                    <th>PEMBELI</th>
                    <th>PRODUK</th>
                    <th>TOTAL</th>
                    <th>BAYAR</th>
                    <th>STATUS</th>
                    <th>TANGGAL</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                @php
                    $colorMap = [
                        'pending'    => ['bg'=>'#fff9e6','text'=>'#856404','icon'=>'⏳'],
                        'confirmed'  => ['bg'=>'#e6f0ff','text'=>'#0c4a9e','icon'=>'✅'],
                        'processing' => ['bg'=>'#f0e6ff','text'=>'#4a2c6a','icon'=>'📦'],
                        'shipped'    => ['bg'=>'#e6e8ff','text'=>'#3730a3','icon'=>'🚚'],
                        'completed'  => ['bg'=>'#e8f0dc','text'=>'#4a5a3a','icon'=>'🎉'],
                        'cancelled'  => ['bg'=>'#fde8e8','text'=>'#c62828','icon'=>'❌'],
                    ];
                    $c = $colorMap[$order->status] ?? ['bg'=>'#f5f5f5','text'=>'#333','icon'=>'•'];
                    $payIcons = ['transfer'=>'🏦','qris'=>'📱','cod'=>'💵'];
                    $payIcon  = $payIcons[$order->payment_method] ?? '💳';
                    // avatar color from name hash
                    $avatarColor = $avatarColors[abs(crc32($order->buyer_name ?? 'X')) % count($avatarColors)];
                    $initials = strtoupper(substr($order->buyer_name ?? '?', 0, 1));
                @endphp
                <tr>
                    <td>
                        <span class="order-num-badge">#{{ $order->order_number }}</span>
                    </td>
                    <td>
                        <div class="buyer-wrap">
                            <div class="buyer-avatar" style="background:{{ $avatarColor }}">{{ $initials }}</div>
                            <div>
                                <div class="buyer-name">{{ $order->buyer_name }}</div>
                                <div class="buyer-wa">{{ $order->buyer_whatsapp }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="items-chip">🛍 {{ $order->items->count() }} item</span>
                    </td>
                    <td style="font-weight:700;color:var(--sage-dark);">{{ $order->formattedTotal }}</td>
                    <td>
                        <span class="pay-badge">{{ $payIcon }} {{ $order->payment_label }}</span>
                        @if($order->payment_proof_path && $order->status === 'pending')
                            <span class="proof-tag">⚠ Ada bukti TF</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge" style="background:{{ $c['bg'] }};color:{{ $c['text'] }};">
                            {{ $c['icon'] }} {{ $order->status_label }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:var(--text-muted);">
                        {{ $order->created_at->format('d M Y') }}<br>
                        <span style="font-size:11px;">{{ $order->created_at->format('H:i') }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn-detail">DETAIL</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-orders">
                            <div class="empty-orders-icon">📦</div>
                            <h3>Belum ada pesanan</h3>
                            <p style="font-size:.84rem;">Pesanan pelanggan akan muncul di sini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1.5rem;">{{ $orders->links() }}</div>

    <script>
    /* ── ANIMATED COUNTERS ── */
    document.querySelectorAll('.os-num[data-target]').forEach(el => {
        const target = parseInt(el.dataset.target) || 0;
        if (target === 0) { el.textContent = '0'; return; }
        const dur = 850, steps = 30;
        let cur = 0;
        const t = setInterval(() => {
            cur += target / steps;
            if (cur >= target) { cur = target; clearInterval(t); }
            el.textContent = Math.floor(cur);
        }, dur / steps);
    });

    /* ── PROGRESS BAR ANIMATE ── */
    setTimeout(() => {
        document.querySelectorAll('.osp-bar-fill').forEach(el => {
            el.style.width = el.dataset.width || '0%';
        });
    }, 250);
    </script>
</x-admin-layout>