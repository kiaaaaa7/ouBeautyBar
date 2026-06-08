<x-admin-layout>
    <x-slot name="title">Daftar Produk</x-slot>

    <style>
        /* ── STATS GRID ── */
        .prod-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .ps-card {
            background: white;
            border: 1px solid var(--cream-dark);
            padding: 1.1rem 1.3rem;
            display: flex;
            align-items: center;
            gap: .9rem;
            transition: transform .22s, box-shadow .22s, border-color .22s;
            position: relative;
            overflow: hidden;
        }
        .ps-card::before {
            content: '';
            position: absolute; left: 0; top: 0; bottom: 0;
            width: 3px;
            background: var(--sage-dark);
            transform: scaleY(0);
            transform-origin: bottom;
            transition: transform .25s ease;
        }
        .ps-card.warn::before { background: #c0892a; }
        .ps-card.danger::before { background: #c62828; }
        .ps-card.purple::before { background: #6a4c93; }
        .ps-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,.09); border-color: var(--sage-dark); }
        .ps-card:hover::before { transform: scaleY(1); }
        .ps-icon { font-size: 1.6rem; flex-shrink: 0; }
        .ps-num {
            font-size: 1.8rem; font-weight: 700; color: var(--sage-dark); line-height: 1;
            font-variant-numeric: tabular-nums;
        }
        .ps-num.warn   { color: #c0892a; }
        .ps-num.danger { color: #c62828; }
        .ps-num.purple { color: #6a4c93; }
        .ps-label { font-size: .7rem; letter-spacing: .09em; text-transform: uppercase; color: var(--text-muted); margin-top: .15rem; }

        /* ── TOOLBAR ── */
        .prod-toolbar {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 1.2rem; gap: .8rem; flex-wrap: wrap;
        }
        .prod-toolbar-left { display: flex; align-items: center; gap: .8rem; flex-wrap: wrap; }
        .search-wrap { position: relative; }
        .search-wrap input {
            padding: .5rem .9rem .5rem 2.1rem;
            font-size: .82rem; font-family: inherit;
            border: 1px solid var(--cream-dark);
            outline: none; width: 220px;
            transition: border-color .2s, box-shadow .2s;
        }
        .search-wrap input:focus { border-color: var(--sage-dark); box-shadow: 0 0 0 3px rgba(92,107,58,.1); }
        .search-icon-pos { position: absolute; left: .65rem; top: 50%; transform: translateY(-50%); font-size: .8rem; pointer-events: none; }
        .filter-select {
            padding: .5rem .8rem; font-size: .82rem; font-family: inherit;
            border: 1px solid var(--cream-dark);
            outline: none; cursor: pointer; background: white;
            transition: border-color .2s;
        }
        .filter-select:focus { border-color: var(--sage-dark); }
        .result-count { font-size: .78rem; color: var(--text-muted); white-space: nowrap; }

        /* ── TABLE ── */
        .prod-table-wrap {
            background: white; border: 1px solid var(--cream-dark); overflow: hidden;
        }
        .prod-table {
            width: 100%; border-collapse: collapse; font-size: 13px;
        }
        .prod-table thead tr {
            background: var(--cream); border-bottom: 1px solid var(--cream-dark);
            position: sticky; top: 0; z-index: 10;
        }
        .prod-table th {
            padding: .7rem 1rem; text-align: left; font-size: 11px;
            letter-spacing: .5px; color: var(--text-muted);
            white-space: nowrap; cursor: pointer; user-select: none;
        }
        .prod-table th:hover { color: var(--sage-dark); }
        .prod-table th.sorted { color: var(--sage-dark); }
        .sort-icon { font-size: .65rem; margin-left: .25rem; opacity: .45; }
        .prod-table tbody tr {
            border-bottom: 1px solid var(--cream-dark);
            transition: background .18s, transform .18s, box-shadow .18s;
        }
        .prod-table tbody tr:hover {
            background: var(--cream) !important;
            transform: translateX(4px);
            box-shadow: -4px 0 0 var(--sage-dark);
        }
        .prod-table td { padding: .6rem 1rem; }

        /* Foto hover zoom */
        .prod-img-wrap {
            width: 48px; height: 48px; overflow: hidden;
            background: var(--cream); flex-shrink: 0;
        }
        .prod-img-wrap img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform .4s ease;
        }
        .prod-img-wrap:hover img { transform: scale(1.35); }
        .prod-img-empty {
            width: 100%; height: 100%; display: flex;
            align-items: center; justify-content: center; font-size: 1.25rem;
        }

        /* Badge foto */
        .foto-badge {
            display: inline-flex; align-items: center; gap: .2rem;
            background: var(--cream); color: var(--text-muted);
            font-size: .65rem; padding: .15rem .45rem;
            margin-top: 3px;
        }

        /* Stok progress */
        .stok-wrap { display: flex; flex-direction: column; gap: 3px; }
        .stok-bar-bg { height: 4px; background: #f0f0f0; width: 64px; }
        .stok-bar-fill { height: 100%; background: var(--sage-dark); transition: width .8s ease; }
        .stok-bar-fill.warn   { background: #c0892a; }
        .stok-bar-fill.danger { background: #c62828; }
        .stok-text { font-size: 12px; }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 3px 10px; font-size: 11px; letter-spacing: .5px;
            white-space: nowrap;
        }
        .badge-custom   { background: var(--lavender-light); color: #4a2c6a; }
        .badge-ready    { background: var(--sage-pale); color: var(--sage-dark); }
        .badge-active   { background: #e8f0dc; color: var(--sage-dark); }
        .badge-inactive { background: #fde8e8; color: #c62828; }

        /* Tooltip */
        .tooltip-wrap { position: relative; display: inline-block; }
        .tooltip-box {
            position: absolute; left: 0; top: calc(100% + 6px); z-index: 200;
            background: #2c2c2c; color: white; font-size: .72rem; line-height: 1.6;
            padding: .5rem .8rem; white-space: nowrap;
            opacity: 0; visibility: hidden;
            transition: opacity .2s, visibility .2s;
            pointer-events: none;
            box-shadow: 0 4px 14px rgba(0,0,0,.2);
        }
        .tooltip-wrap:hover .tooltip-box { opacity: 1; visibility: visible; }

        /* Action btns */
        .action-wrap { display: flex; gap: 6px; align-items: center; }
        .btn-edit {
            background: var(--sage-dark); color: white;
            padding: 5px 12px; text-decoration: none; font-size: 11px;
            letter-spacing: .5px; border: none; cursor: pointer;
            transition: background .2s, transform .15s;
        }
        .btn-edit:hover { background: var(--sage-light, #7A8C4E); transform: translateY(-1px); }
        .btn-del {
            background: none; border: 1px solid #e57373; color: #c62828;
            padding: 5px 10px; cursor: pointer; font-size: 11px;
            transition: background .2s, transform .15s;
        }
        .btn-del:hover { background: #fde8e8; transform: translateY(-1px); }

        /* Empty state */
        .empty-state {
            text-align: center; padding: 4rem 2rem; color: var(--text-muted);
        }
        .empty-state-icon { font-size: 3rem; margin-bottom: 1rem; opacity: .4; }
        .empty-state h3 { font-size: 1rem; color: var(--text-dark); margin-bottom: .4rem; }
        .empty-state p { font-size: .85rem; margin-bottom: 1.2rem; }

        /* FAB */
        #fab {
            position: fixed; bottom: 2rem; right: 2rem; z-index: 100;
            width: 50px; height: 50px; border-radius: 50%;
            background: var(--sage-dark); color: white;
            font-size: 1.5rem; text-decoration: none;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 18px rgba(92,107,58,.4);
            transition: transform .25s, box-shadow .25s;
        }
        #fab:hover { transform: scale(1.1) rotate(90deg); box-shadow: 0 8px 24px rgba(92,107,58,.5); }

        /* No-results row */
        #noResults { display: none; }

        @media(max-width: 900px) {
            .prod-stats { grid-template-columns: 1fr 1fr; }
            .search-wrap input { width: 160px; }
        }
        @media(max-width: 600px) {
            .prod-stats { grid-template-columns: 1fr 1fr; }
            .prod-toolbar { flex-direction: column; align-items: stretch; }
        }
    </style>

    {{-- ── STAT CARDS ── --}}
    @php
        $totalProd   = $products->total();
        $readyCount  = $products->getCollection()->where('is_custom', false)->count();
        $customCount = $products->getCollection()->where('is_custom', true)->count();
        $lowStock    = $products->getCollection()->where('is_custom', false)->where('stock', '<=', 3)->where('stock', '>', 0)->count();
        $outStock    = $products->getCollection()->where('is_custom', false)->where('stock', 0)->count();
        $maxStock    = $products->getCollection()->max('stock') ?: 1;
    @endphp

    <div class="prod-stats">
        <div class="ps-card">
            <span class="ps-icon">📦</span>
            <div>
                <div class="ps-num" data-target="{{ $totalProd }}">0</div>
                <div class="ps-label">Total Produk</div>
            </div>
        </div>
        <div class="ps-card">
            <span class="ps-icon">💅</span>
            <div>
                <div class="ps-num" data-target="{{ $readyCount }}">0</div>
                <div class="ps-label">Produk Ready</div>
            </div>
        </div>
        <div class="ps-card purple">
            <span class="ps-icon">🎨</span>
            <div>
                <div class="ps-num purple" data-target="{{ $customCount }}">0</div>
                <div class="ps-label">Produk Custom</div>
            </div>
        </div>
        <div class="ps-card {{ ($lowStock + $outStock) > 0 ? 'warn' : '' }}">
            <span class="ps-icon">⚠️</span>
            <div>
                <div class="ps-num {{ ($lowStock + $outStock) > 0 ? 'warn' : '' }}" data-target="{{ $lowStock + $outStock }}">0</div>
                <div class="ps-label">Stok Menipis / Habis</div>
            </div>
        </div>
    </div>

    {{-- ── TOOLBAR ── --}}
    <div class="prod-toolbar">
        <div class="prod-toolbar-left">
            <div class="search-wrap">
                <span class="search-icon-pos">🔍</span>
                <input type="text" id="prodSearch" placeholder="Cari nama produk..." oninput="filterTable()"/>
            </div>
            <select class="filter-select" id="filterTipe" onchange="filterTable()">
                <option value="">Semua Tipe</option>
                <option value="ready">Ready</option>
                <option value="custom">Custom</option>
            </select>
            <select class="filter-select" id="filterStatus" onchange="filterTable()">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
            <span class="result-count" id="resultCount">Total {{ $totalProd }} produk</span>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-edit" style="padding: 9px 20px; font-size: 12px; letter-spacing: 1px;">
            + TAMBAH PRODUK
        </a>
    </div>

    {{-- ── TABLE ── --}}
    <div class="prod-table-wrap">
        <table class="prod-table" id="prodTable">
            <thead>
                <tr>
                    <th style="width:60px;">FOTO</th>
                    <th onclick="sortTable(1)" class="sorted">NAMA PRODUK<span class="sort-icon" id="sort1">▼</span></th>
                    <th onclick="sortTable(2)">KATEGORI<span class="sort-icon" id="sort2">⇅</span></th>
                    <th onclick="sortTable(3)">HARGA<span class="sort-icon" id="sort3">⇅</span></th>
                    <th onclick="sortTable(4)">STOK<span class="sort-icon" id="sort4">⇅</span></th>
                    <th>TIPE</th>
                    <th>STATUS</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="prodTbody">
                @forelse($products as $product)
                <tr data-nama="{{ strtolower($product->name) }}"
                    data-tipe="{{ $product->is_custom ? 'custom' : 'ready' }}"
                    data-status="{{ $product->is_active ? 'aktif' : 'nonaktif' }}">

                    {{-- Foto --}}
                    <td>
                        <div class="prod-img-wrap">
                            @if($product->primaryImageUrl)
                                <img src="{{ $product->primaryImageUrl }}" alt="{{ $product->name }}"/>
                            @else
                                <div class="prod-img-empty">💅</div>
                            @endif
                        </div>
                    </td>

                    {{-- Nama + tooltip --}}
                    <td>
                        <div class="tooltip-wrap">
                            <p style="font-size:14px;color:var(--text-dark);margin-bottom:2px;">{{ $product->name }}</p>
                            <div class="tooltip-box">
                                Kategori: {{ $product->category->name ?? '-' }}<br>
                                Harga: {{ $product->formattedPrice }}<br>
                                Stok: {{ $product->is_custom ? 'Custom' : ($product->stock . ' pcs') }}<br>
                                Status: {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </div>
                        </div>
                        <div class="foto-badge">📷 {{ $product->images->count() }}</div>
                    </td>

                    {{-- Kategori --}}
                    <td style="color:var(--text-muted);font-size:13px;">
                        {{ $product->category->name ?? '-' }}
                    </td>

                    {{-- Harga --}}
                    <td style="font-weight:bold;color:var(--sage-dark);">
                        {{ $product->formattedPrice }}
                    </td>

                    {{-- Stok dengan progress bar --}}
                    <td>
                        @if($product->is_custom)
                            <span style="font-size:12px;color:#6a4c93;">—</span>
                        @else
                            @php
                                $pct  = $maxStock > 0 ? min(100, round(($product->stock / $maxStock) * 100)) : 0;
                                $cls  = $product->stock === 0 ? 'danger' : ($product->stock <= 3 ? 'warn' : '');
                            @endphp
                            <div class="stok-wrap">
                                <span class="stok-text {{ $product->stock === 0 ? 'danger' : ($product->stock <= 3 ? 'warn' : '') }}"
                                      style="{{ $product->stock === 0 ? 'color:#c62828;font-weight:bold;' : ($product->stock <= 3 ? 'color:#856404;' : 'color:var(--text-dark);') }}">
                                    {{ $product->stock === 0 ? 'Habis' : $product->stock . ' pcs' }}
                                    @if($product->stock > 0 && $product->stock <= 3) ⚠ @endif
                                </span>
                                <div class="stok-bar-bg">
                                    <div class="stok-bar-fill {{ $cls }}"
                                         style="width:0%"
                                         data-width="{{ $pct }}%"></div>
                                </div>
                            </div>
                        @endif
                    </td>

                    {{-- Tipe --}}
                    <td>
                        <span class="badge {{ $product->is_custom ? 'badge-custom' : 'badge-ready' }}">
                            {{ $product->is_custom ? 'CUSTOM' : 'READY' }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td>
                        <span class="badge {{ $product->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td>
                        <div class="action-wrap">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn-edit">EDIT</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-del">HAPUS</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr id="emptyRow">
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-state-icon">📦</div>
                            <h3>Belum ada produk tersedia</h3>
                            <p>Mulai tambahkan produk nail art pertama kamu!</p>
                            <a href="{{ route('admin.products.create') }}" class="btn-edit"
                               style="display:inline-block;padding:9px 22px;font-size:12px;letter-spacing:1px;text-decoration:none;">
                                + TAMBAH PRODUK
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- No results row (hidden by default) --}}
        <div id="noResults" style="display:none;text-align:center;padding:3rem;color:var(--text-muted);font-size:.88rem;">
            🔍 Tidak ada produk yang cocok dengan pencarian.
        </div>
    </div>

    <div style="margin-top: 1.5rem;">{{ $products->links() }}</div>

    {{-- FAB --}}
    <a href="{{ route('admin.products.create') }}" id="fab" title="Tambah Produk">＋</a>

    <script>
    /* ── ANIMATED COUNTERS ── */
    document.querySelectorAll('.ps-num[data-target]').forEach(el => {
        const target = parseInt(el.dataset.target) || 0;
        if (target === 0) { el.textContent = '0'; return; }
        const dur = 900, steps = 35, inc = target / steps;
        let cur = 0;
        const t = setInterval(() => {
            cur += inc;
            if (cur >= target) { cur = target; clearInterval(t); }
            el.textContent = Math.floor(cur);
        }, dur / steps);
    });

    /* ── STOK BAR ANIMATE ── */
    setTimeout(() => {
        document.querySelectorAll('.stok-bar-fill').forEach(el => {
            el.style.width = el.dataset.width || '0%';
        });
    }, 300);

    /* ── SEARCH + FILTER ── */
    function filterTable() {
        const q       = (document.getElementById('prodSearch')?.value || '').toLowerCase().trim();
        const tipe    = document.getElementById('filterTipe')?.value || '';
        const status  = document.getElementById('filterStatus')?.value || '';
        const rows    = document.querySelectorAll('#prodTbody tr[data-nama]');
        let visible   = 0;

        rows.forEach(row => {
            const matchQ      = !q      || row.dataset.nama.includes(q);
            const matchTipe   = !tipe   || row.dataset.tipe === tipe;
            const matchStatus = !status || row.dataset.status === status;
            const show = matchQ && matchTipe && matchStatus;
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        const countEl = document.getElementById('resultCount');
        if (countEl) countEl.textContent = `${visible} produk ditampilkan`;

        const noRes = document.getElementById('noResults');
        if (noRes) noRes.style.display = (visible === 0 && rows.length > 0) ? 'block' : 'none';
    }

    /* ── TABLE SORT ── */
    let sortDir = {};
    function sortTable(colIdx) {
        const tbody = document.getElementById('prodTbody');
        if (!tbody) return;
        const rows = Array.from(tbody.querySelectorAll('tr[data-nama]'));
        sortDir[colIdx] = !sortDir[colIdx]; // toggle asc/desc

        rows.sort((a, b) => {
            const aCell = a.cells[colIdx]?.textContent.trim() || '';
            const bCell = b.cells[colIdx]?.textContent.trim() || '';
            // numeric sort for price / stock
            const aNum = parseFloat(aCell.replace(/[^0-9.]/g, ''));
            const bNum = parseFloat(bCell.replace(/[^0-9.]/g, ''));
            if (!isNaN(aNum) && !isNaN(bNum)) {
                return sortDir[colIdx] ? aNum - bNum : bNum - aNum;
            }
            return sortDir[colIdx]
                ? aCell.localeCompare(bCell, 'id')
                : bCell.localeCompare(aCell, 'id');
        });

        // update sort icons
        [1,2,3,4].forEach(i => {
            const icon = document.getElementById('sort' + i);
            if (icon) icon.textContent = i === colIdx ? (sortDir[colIdx] ? '▲' : '▼') : '⇅';
        });

        rows.forEach(r => tbody.appendChild(r));
    }
    </script>
</x-admin-layout>