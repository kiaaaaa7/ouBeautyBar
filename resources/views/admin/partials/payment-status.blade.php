{{--
  Partial: Admin — Status Pembayaran
  @include('admin.partials.payment-status', ['appointment' => $appointment])
--}}

@php
  $statusConfig = [
    'pending' => [
      'label'  => 'Pending',
      'icon'   => '⏳',
      'class'  => 'pay-pending',
      'bg'     => '#FFF8E6',
      'color'  => '#A06800',
      'border' => '#F0D980',
      'dot'    => '#A06800',
    ],
    'waiting_confirmation' => [
      'label'  => 'Menunggu Konfirmasi',
      'icon'   => '⧗',
      'class'  => 'pay-waiting',
      'bg'     => '#FFF3E0',
      'color'  => '#BF6E00',
      'border' => '#FFC947',
      'dot'    => '#BF6E00',
    ],
    'paid' => [
      'label'  => 'Lunas',
      'icon'   => '✦',
      'class'  => 'pay-paid',
      'bg'     => '#EDF7ED',
      'color'  => '#2E7D32',
      'border' => '#A5D6A7',
      'dot'    => '#2E7D32',
    ],
  ];

  $status = $appointment->payment_status ?? 'pending';
  $cfg    = $statusConfig[$status] ?? $statusConfig['pending'];
@endphp

<style>
/* ── Payment Card ── */
.ps-card {
  background: #ffffff;
  border: 1px solid rgba(92,107,58,.08);
  border-radius: 20px;
  overflow: hidden;
  margin-bottom: 1.4rem;
  font-family: 'Jost', sans-serif;
  box-shadow: 0 4px 24px rgba(92,107,58,.06);
  transition: box-shadow .3s ease;
}
.ps-card:hover {
  box-shadow: 0 8px 36px rgba(92,107,58,.1);
}

/* ── Card Header ── */
.ps-header {
  display: flex; align-items: center; gap: .75rem;
  padding: 1.4rem 1.8rem 1.1rem;
  border-bottom: 1px solid rgba(92,107,58,.07);
  background: linear-gradient(135deg, rgba(240,235,247,.4) 0%, rgba(232,237,216,.3) 100%);
}

.ps-header-icon {
  width: 36px; height: 36px;
  background: linear-gradient(135deg, #F0EBF7 0%, #E8EDD8 100%);
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: .9rem; flex-shrink: 0;
}

.ps-header h3 {
  font-family: 'Playfair Display', serif;
  font-size: 1rem; font-weight: 500;
  color: #2C2C2C; margin: 0; letter-spacing: .01em;
}

.ps-header-sub {
  font-size: .7rem; color: #6B6B6B; font-weight: 300;
  margin-top: .05rem;
}

/* ── Body ── */
.ps-body { padding: 1.8rem; }

/* ── Info Grid ── */
.ps-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.3rem;
  margin-bottom: 1.6rem;
}

.ps-label {
  font-size: .6rem; letter-spacing: .16em; text-transform: uppercase;
  color: #6B6B6B; margin-bottom: .35rem; font-weight: 500;
}

.ps-value {
  font-size: .9rem; color: #2C2C2C; font-weight: 400;
}

.ps-value.amount {
  font-family: 'Playfair Display', serif;
  font-size: 1.15rem; color: #5C6B3A; font-weight: 400;
}

/* ── Status Badge ── */
.ps-badge {
  display: inline-flex; align-items: center; gap: .45rem;
  padding: .38rem 1.1rem;
  border-radius: 20px; font-size: .78rem; font-weight: 500;
  border: 1.5px solid;
  background: {{ $cfg['bg'] }};
  color: {{ $cfg['color'] }};
  border-color: {{ $cfg['border'] }};
  letter-spacing: .02em;
}

.ps-badge-dot {
  width: 6px; height: 6px; border-radius: 50%;
  background: {{ $cfg['dot'] }};
  flex-shrink: 0;
}

/* ── Divider ── */
.ps-divider {
  height: 1px;
  background: linear-gradient(to right, rgba(92,107,58,.1), transparent);
  margin: 1.5rem 0;
}

/* ── Proof Section ── */
.ps-proof-label {
  font-size: .6rem; letter-spacing: .16em; text-transform: uppercase;
  color: #6B6B6B; margin-bottom: .9rem; font-weight: 500;
}

.ps-proof-wrap {
  position: relative; display: inline-block; cursor: pointer;
}

.ps-proof-overlay {
  position: absolute; inset: 0;
  background: rgba(92,107,58,.0);
  border-radius: 13px;
  display: flex; align-items: center; justify-content: center;
  transition: background .28s ease;
}
.ps-proof-wrap:hover .ps-proof-overlay {
  background: rgba(92,107,58,.3);
}

.ps-proof-zoom-icon {
  color: #fff; font-size: 1.3rem; opacity: 0;
  transition: opacity .28s ease;
}
.ps-proof-wrap:hover .ps-proof-zoom-icon { opacity: 1; }

.ps-proof-img {
  max-width: 280px; max-height: 200px; object-fit: cover;
  border-radius: 13px;
  border: 1.5px solid rgba(92,107,58,.12);
  display: block;
  transition: box-shadow .3s ease;
}
.ps-proof-wrap:hover .ps-proof-img {
  box-shadow: 0 14px 44px rgba(0,0,0,.18);
}

.ps-proof-hint {
  font-size: .72rem; color: #5C6B3A; margin-top: .55rem;
  display: flex; align-items: center; gap: .3rem;
}

.ps-no-proof {
  display: flex; align-items: center; gap: .6rem;
  padding: 1.2rem 1.4rem;
  background: #f9f9f9;
  border: 1.5px dashed rgba(92,107,58,.15);
  border-radius: 10px;
  font-size: .84rem; color: #aaa; font-style: italic;
}

/* ── Update Form ── */
.ps-form-label {
  font-size: .6rem; letter-spacing: .16em; text-transform: uppercase;
  color: #6B6B6B; margin-bottom: .8rem; font-weight: 500;
}

.ps-update-row {
  display: flex; align-items: center; gap: .9rem; flex-wrap: wrap;
}

.ps-select {
  padding: .62rem 1.1rem;
  border: 1.5px solid rgba(92,107,58,.18);
  border-radius: 11px; font-size: .83rem;
  background: #F2F4EE; color: #2C2C2C;
  font-family: 'Jost', sans-serif; outline: none; cursor: pointer;
  transition: border-color .22s, box-shadow .22s;
  min-width: 200px;
}
.ps-select:focus {
  border-color: #5C6B3A;
  box-shadow: 0 0 0 3px rgba(92,107,58,.1);
}

.ps-btn {
  padding: .62rem 1.8rem;
  background: linear-gradient(135deg, #5C6B3A 0%, #7A8C4E 100%);
  color: #fff; border: none; border-radius: 11px;
  font-size: .82rem; font-weight: 500; cursor: pointer;
  font-family: 'Jost', sans-serif; letter-spacing: .05em;
  transition: transform .22s, box-shadow .22s;
}
.ps-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(92,107,58,.3);
}

/* ── Modal Zoom ── */
.ps-modal {
  position: fixed; inset: 0;
  background: rgba(0,0,0,.75);
  backdrop-filter: blur(6px);
  display: flex; align-items: center; justify-content: center;
  z-index: 9999;
  opacity: 0; pointer-events: none;
  transition: opacity .28s ease;
}
.ps-modal.open { opacity: 1; pointer-events: all; }

.ps-modal-inner {
  position: relative;
  animation: psZoomIn .3s ease;
}

@keyframes psZoomIn {
  from { transform: scale(.92); opacity: 0; }
  to   { transform: scale(1); opacity: 1; }
}

.ps-modal-img {
  max-width: 90vw; max-height: 85vh;
  border-radius: 16px;
  box-shadow: 0 32px 80px rgba(0,0,0,.55);
  display: block;
}

.ps-modal-close {
  position: absolute; top: -14px; right: -14px;
  background: #fff; border: none;
  color: #333; font-size: .85rem;
  width: 36px; height: 36px;
  border-radius: 50%; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  box-shadow: 0 4px 14px rgba(0,0,0,.25);
  transition: transform .2s, box-shadow .2s;
}
.ps-modal-close:hover { transform: rotate(90deg); box-shadow: 0 6px 18px rgba(0,0,0,.3); }
</style>

<!-- ── Modal Zoom ── -->
<div class="ps-modal" id="psModal-{{ $appointment->id }}"
     onclick="document.getElementById('psModal-{{ $appointment->id }}').classList.remove('open'); document.body.style.overflow='';">
  <div class="ps-modal-inner" onclick="event.stopPropagation()">
    <button class="ps-modal-close"
            onclick="document.getElementById('psModal-{{ $appointment->id }}').classList.remove('open'); document.body.style.overflow='';">✕</button>
    <img class="ps-modal-img" id="psModalImg-{{ $appointment->id }}" src="" alt="Bukti pembayaran"/>
  </div>
</div>

<!-- ── Payment Card ── -->
<div class="ps-card">
  <div class="ps-header">
    <div class="ps-header-icon">◆</div>
    <div>
      <h3>Informasi Pembayaran</h3>
      <div class="ps-header-sub">Detail transaksi & status pembayaran</div>
    </div>
  </div>

  <div class="ps-body">
    <!-- Info Grid -->
    <div class="ps-grid">
      <div>
        <div class="ps-label">Metode Pembayaran</div>
        <div class="ps-value">{{ $appointment->payment_method ?? $appointment->metode_bayar ?? '—' }}</div>
      </div>
      <div>
        <div class="ps-label">Total Harga</div>
        <div class="ps-value amount">
          @if($appointment->total_harga)
            Rp {{ number_format($appointment->total_harga, 0, ',', '.') }}
          @else —
          @endif
        </div>
      </div>
      <div>
        <div class="ps-label">Status Pembayaran</div>
        <div class="ps-value">
          <span class="ps-badge">
            <span class="ps-badge-dot"></span>
            {{ $cfg['icon'] }} {{ $cfg['label'] }}
          </span>
        </div>
      </div>
    </div>

    <div class="ps-divider"></div>

    <!-- Bukti Pembayaran -->
    <div class="ps-proof-label">Bukti Pembayaran</div>
    @if($appointment->bukti_pembayaran)
      <div class="ps-proof-wrap"
           onclick="document.getElementById('psModalImg-{{ $appointment->id }}').src='{{ asset('bukti/' . $appointment->bukti_pembayaran) }}';
                    document.getElementById('psModal-{{ $appointment->id }}').classList.add('open');
                    document.body.style.overflow='hidden';">
        <img src="{{ asset('bukti/' . $appointment->bukti_pembayaran) }}"
             class="ps-proof-img"
             alt="Bukti pembayaran"/>
        <div class="ps-proof-overlay">
          <span class="ps-proof-zoom-icon">⊕</span>
        </div>
      </div>
      <div class="ps-proof-hint">◈ Klik gambar untuk memperbesar</div>
    @else
      <div class="ps-no-proof">
        <span>◻</span>
        Belum ada bukti pembayaran yang diupload.
      </div>
    @endif

    <!-- Update Status (admin only) -->
    @can('admin')
    <div class="ps-divider"></div>
    <div class="ps-form-label">Update Status Pembayaran</div>
    <form action="{{ route('admin.appointments.update-payment', $appointment->id) }}"
          method="POST">
      @csrf @method('PATCH')
      <div class="ps-update-row">
        <select name="payment_status" class="ps-select">
          <option value="pending"              {{ $status == 'pending'              ? 'selected' : '' }}>⏳ Pending</option>
          <option value="waiting_confirmation" {{ $status == 'waiting_confirmation' ? 'selected' : '' }}>⧗ Menunggu Konfirmasi</option>
          <option value="paid"                 {{ $status == 'paid'                 ? 'selected' : '' }}>✦ Lunas</option>
        </select>
        <button type="submit" class="ps-btn">Update Status</button>
      </div>
    </form>
    @endcan
  </div>
</div>