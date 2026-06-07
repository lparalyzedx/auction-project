@extends('layouts.app')

@section('title', 'Ana Sayfa')

@push('styles')
<style>
/* ── Filtre barı ── */
.idx-filterbar {
    display: flex; align-items: center; gap: 10px;
    flex-wrap: wrap;
    padding: 14px 18px;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 14px;
    margin-bottom: 20px;
}
.idx-search-wrap {
    position: relative; flex: 1; min-width: 180px;
}
.idx-search-wrap i {
    position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
    font-size: 14px; color: var(--muted); pointer-events: none;
}
.idx-search-wrap input {
    width: 100%; height: 36px; padding: 0 12px 0 34px;
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 9px; color: var(--text); font-size: 13px; outline: none;
    transition: border-color .15s;
}
.idx-search-wrap input::placeholder { color: var(--muted); }
.idx-search-wrap input:focus { border-color: var(--primary); }

.idx-select {
    height: 36px; padding: 0 10px;
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 9px; color: var(--text); font-size: 12px; font-weight: 600;
    outline: none; cursor: pointer; min-width: 130px;
    transition: border-color .15s;
}
.idx-select:focus { border-color: var(--primary); }
.idx-select option { background: var(--bg); color: var(--text); }

.idx-filter-divider {
    width: 1px; height: 22px;
    background: var(--border); flex-shrink: 0;
}
@media(max-width:600px){ .idx-filter-divider { display: none; } }

.idx-sort-btns {
    display: flex; gap: 4px;
}
.idx-sort-btn {
    height: 36px; padding: 0 12px;
    background: transparent; border: 1px solid var(--border);
    border-radius: 9px; color: var(--muted);
    font-size: 12px; font-weight: 600; cursor: pointer;
    display: flex; align-items: center; gap: 5px;
    transition: border-color .15s, color .15s, background .15s;
    white-space: nowrap;
}
.idx-sort-btn i { font-size: 13px; }
.idx-sort-btn:hover, .idx-sort-btn.active {
    border-color: var(--primary); color: var(--primary);
    background: rgba(145,70,255,.08);
}

.idx-filter-count {
    font-size: 11px; color: var(--muted);
    white-space: nowrap; margin-left: auto;
}
.idx-filter-count span { font-weight: 700; color: var(--text); }

/* ── Category pills ── */
.idx-cats {
    display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 20px;
    align-items: center;
}
.idx-cats-lbl {
    font-size: 11px; font-weight: 600; color: var(--muted);
    text-transform: uppercase; letter-spacing: .5px; margin-right: 2px;
}
.idx-cat {
    padding: 5px 13px; border-radius: 20px;
    background: var(--card); border: 1px solid var(--border);
    font-size: 12px; font-weight: 600; color: var(--muted);
    cursor: pointer; transition: border-color .15s, color .15s, background .15s;
    text-decoration: none; display: inline-flex; align-items: center; gap: 5px;
}
.idx-cat:hover { border-color: rgba(145,70,255,.4); color: var(--primary); }
.idx-cat.active {
    border-color: var(--primary); color: var(--primary);
    background: rgba(145,70,255,.1);
}
.idx-cat .cnt {
    font-size: 10px; opacity: .55; font-weight: 400;
}

/* ── Section header ── */
.idx-section-head {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 14px;
}
.idx-section-title {
    font-size: 14px; font-weight: 700; color: var(--text);
    display: flex; align-items: center; gap: 7px;
}
.idx-section-title i { color: var(--primary); font-size: 15px; }
.idx-see-all {
    font-size: 12px; font-weight: 600; color: var(--primary);
    text-decoration: none; display: flex; align-items: center; gap: 3px;
    opacity: .75; transition: opacity .15s;
}
.idx-see-all:hover { opacity: 1; }

/* ── Auction card ── */
.idx-card {
    background: var(--card); border: 1px solid var(--border);
    border-radius: 14px; overflow: hidden;
    display: flex; flex-direction: column;
    transition: transform .2s, border-color .2s;
    text-decoration: none; color: var(--text);
    height: 100%;
}
.idx-card:hover {
    transform: translateY(-4px);
    border-color: rgba(145,70,255,.38);
    color: var(--text);
}

.idx-card-img {
    position: relative; aspect-ratio: 4/3; overflow: hidden;
    background: rgba(0,0,0,.15);
}
.idx-card-img img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform .32s;
}
.idx-card:hover .idx-card-img img { transform: scale(1.05); }

/* Badges */
.idx-live-badge {
    position: absolute; top: 9px; left: 9px;
    display: flex; align-items: center; gap: 5px;
    background: rgba(16,185,129,.15); border: 1px solid rgba(16,185,129,.28);
    color: #10b981; font-size: 10px; font-weight: 700;
    padding: 3px 9px; border-radius: 20px; letter-spacing: .3px;
    backdrop-filter: blur(6px);
}
.idx-live-badge .dot {
    width: 5px; height: 5px; background: #10b981; border-radius: 50%;
    animation: lp 1.6s infinite;
}
@keyframes lp { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.3;transform:scale(1.8)} }

.idx-ended-badge {
    position: absolute; top: 9px; left: 9px;
    background: rgba(248,113,113,.12); border: 1px solid rgba(248,113,113,.25);
    color: #f87171; font-size: 10px; font-weight: 700;
    padding: 3px 9px; border-radius: 20px; letter-spacing: .3px;
    backdrop-filter: blur(6px);
}

.idx-price-overlay {
    position: absolute; bottom: 9px; right: 9px;
    background: rgba(0,0,0,.6); color: #fff;
    font-size: 12px; font-weight: 800;
    padding: 3px 9px; border-radius: 7px;
    backdrop-filter: blur(6px);
}

/* Card body */
.idx-card-body {
    padding: 12px 14px; flex: 1;
    display: flex; flex-direction: column; gap: 8px;
}
.idx-card-title {
    font-size: 13px; font-weight: 600; color: var(--text);
    line-height: 1.4; overflow: hidden;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
}
.idx-card-meta {
    display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
}
.idx-card-meta span {
    font-size: 11px; color: var(--muted);
    display: flex; align-items: center; gap: 3px;
}
.idx-card-meta span i { font-size: 11px; }

.idx-card-bottom {
    display: flex; align-items: flex-end; justify-content: space-between;
    margin-top: auto; padding-top: 10px;
    border-top: 1px solid var(--border);
}
.idx-bid-lbl { font-size: 10px; color: var(--muted); margin-bottom: 2px; text-transform: uppercase; letter-spacing: .3px; }
.idx-bid-val { font-size: 15px; font-weight: 800; color: var(--primary); line-height: 1; }
.idx-timer-lbl { font-size: 10px; color: var(--muted); margin-bottom: 2px; text-align: right; text-transform: uppercase; letter-spacing: .3px; }
.idx-timer-val {
    font-size: 12px; font-weight: 700; color: var(--text);
    font-variant-numeric: tabular-nums; text-align: right;
}
.idx-timer-val.critical { color: #f87171; animation: tblink 1s infinite; }
@keyframes tblink { 50%{opacity:.55} }

/* ── Empty state ── */
.idx-empty {
    text-align: center; padding: 56px 20px; color: var(--muted);
    width: 100%;
}
.idx-empty i { font-size: 2.5rem; display: block; margin-bottom: 12px; opacity: .18; }
.idx-empty p { font-size: 13px; margin: 0; }

/* ── No-results state (JS search) ── */
#no-results {
    display: none; text-align: center; padding: 48px; color: var(--muted);
    width: 100%;
}
#no-results i { font-size: 2rem; display: block; margin-bottom: 10px; opacity: .2; }
</style>
@endpush

@section('content')
<div class="container py-4">

    {{-- ══ FİLTRE BARI ══ --}}
    <div class="idx-filterbar">

        {{-- Arama --}}
        <div class="idx-search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="search-input"
                   placeholder="Artırma ara..."
                   value="{{ request('q') }}"
                   autocomplete="off">
        </div>

        <div class="idx-filter-divider"></div>

        {{-- Kategori --}}
        @if(isset($categories) && $categories->count())
        <select class="idx-select" id="cat-select" onchange="applyFilters()">
            <option value="">Tüm Kategoriler</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->slug }}"
                {{ request('category') == $cat->slug ? 'selected' : '' }}>
                {{ $cat->name }} ({{ $cat->auctions_count }})
            </option>
            @endforeach
        </select>
        @endif

        {{-- Durum --}}
        <select class="idx-select" id="status-select" style="min-width:110px;" onchange="applyFilters()">
            <option value="">Tüm Durumlar</option>
            <option value="active"  {{ request('status') == 'active'  ? 'selected' : '' }}>Aktif</option>
            <option value="ended"   {{ request('status') == 'ended'   ? 'selected' : '' }}>Bitti</option>
        </select>

        <div class="idx-filter-divider"></div>

        {{-- Sıralama --}}
        <div class="idx-sort-btns">
            <button class="idx-sort-btn {{ !request('sort') || request('sort')=='bids' ? 'active' : '' }}"
                    onclick="setSort('bids')" id="sort-bids">
                <i class="bi bi-fire"></i> Popüler
            </button>
            <button class="idx-sort-btn {{ request('sort')=='ending' ? 'active' : '' }}"
                    onclick="setSort('ending')" id="sort-ending">
                <i class="bi bi-clock"></i> Bitmek Üzere
            </button>
            <button class="idx-sort-btn {{ request('sort')=='new' ? 'active' : '' }}"
                    onclick="setSort('new')" id="sort-new">
                <i class="bi bi-stars"></i> Yeni
            </button>
            <button class="idx-sort-btn {{ request('sort')=='price' ? 'active' : '' }}"
                    onclick="setSort('price')" id="sort-price">
                <i class="bi bi-sort-down"></i> Fiyat
            </button>
        </div>

        <div class="idx-filter-count">
            <span id="result-count">{{ ($activeAuctions ?? collect())->count() }}</span> sonuç
        </div>
    </div>

    {{-- ══ KATEGORİ PİLLLERI (opsiyonel — ya birini kullan) ── --}}
    {{-- Eğer filtre barındaki select yeterliyse bu bloğu silebilirsin --}}

    {{-- ══ ARTIRMALAR ══ --}}
    <div class="idx-section-head">
        <div class="idx-section-title">
            <i class="bi bi-activity"></i>
            @if(request('status') == 'ended') Biten Artırmalar
            @elseif(request('sort') == 'ending') Bitmek Üzere
            @elseif(request('sort') == 'new') Yeni Eklenenler
            @else Aktif Artırmalar
            @endif
        </div>
        <div style="font-size:11px;color:var(--muted);">
            {{ now()->format('d.m.Y H:i') }} itibarıyla
        </div>
    </div>

    <div class="row g-3" id="auction-grid">
        @forelse($activeAuctions ?? [] as $auction)
        <div class="col-xl-3 col-lg-4 col-md-6 auction-item"
             data-title="{{ strtolower($auction->title) }}"
             data-status="{{ $auction->status }}">
            <a href="{{ route('auctions.show', $auction) }}" class="idx-card">
                <div class="idx-card-img">
                    <img src="{{ $auction->cover?->url() ?? asset('assets/media/placeholder.png') }}"
                         alt="{{ $auction->title }}" loading="lazy">

                    @if($auction->isActive())
                    <div class="idx-live-badge"><span class="dot"></span> CANLI</div>
                    @else
                    <div class="idx-ended-badge">BİTTİ</div>
                    @endif

                    <div class="idx-price-overlay">{{ $auction->displayPrice() }}</div>
                </div>

                <div class="idx-card-body">
                    <div class="idx-card-title">{{ $auction->title }}</div>

                    <div class="idx-card-meta">
                        @if($auction->category)
                        <span><i class="bi bi-tag"></i>{{ $auction->category->name }}</span>
                        @endif
                        <span><i class="bi bi-chat-square"></i>{{ $auction->bidCount() }} teklif</span>
                        @if($auction->location)
                        <span><i class="bi bi-geo-alt"></i>{{ Str::limit($auction->location, 18) }}</span>
                        @endif
                    </div>

                    <div class="idx-card-bottom">
                        <div>
                            <div class="idx-bid-lbl">Güncel Teklif</div>
                            <div class="idx-bid-val">{{ $auction->displayPrice() }}</div>
                        </div>
                        <div>
                            <div class="idx-timer-lbl">Kalan</div>
                            <div class="idx-timer-val"
                                 data-ends="{{ $auction->ends_at->timestamp }}">
                                {{ $auction->timeLeft() }}
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="idx-empty">
            <i class="bi bi-inbox"></i>
            <p>Şu an gösterilecek artırma yok.</p>
        </div>
        @endforelse

        <div id="no-results">
            <i class="bi bi-search"></i>
            <p>Aramanızla eşleşen artırma bulunamadı.</p>
        </div>
    </div>

    {{-- ══ SON EKLENENLER (sadece ana sayfada, filtre yokken) ── --}}
    @if(!request()->hasAny(['q','category','status','sort']) && isset($recentAuctions) && $recentAuctions->count())
    <div class="idx-section-head mt-5">
        <div class="idx-section-title">
            <i class="bi bi-clock-history"></i> Son Eklenenler
        </div>
        <a href="{{ route('index', ['sort' => 'new']) }}" class="idx-see-all">
            Tümünü Gör <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="row g-3 mb-4">
        @foreach($recentAuctions as $auction)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <a href="{{ route('auctions.show', $auction) }}" class="idx-card">
                <div class="idx-card-img">
                    <img src="{{ $auction->cover?->url() ?? asset('assets/media/placeholder.png') }}"
                         alt="{{ $auction->title }}" loading="lazy">
                    @if($auction->isActive())
                    <div class="idx-live-badge"><span class="dot"></span> CANLI</div>
                    @else
                    <div class="idx-ended-badge">BİTTİ</div>
                    @endif
                    <div class="idx-price-overlay">{{ $auction->displayPrice() }}</div>
                </div>
                <div class="idx-card-body">
                    <div class="idx-card-title">{{ $auction->title }}</div>
                    <div class="idx-card-meta">
                        @if($auction->category)
                        <span><i class="bi bi-tag"></i>{{ $auction->category->name }}</span>
                        @endif
                        <span><i class="bi bi-chat-square"></i>{{ $auction->bidCount() }} teklif</span>
                    </div>
                    <div class="idx-card-bottom">
                        <div>
                            <div class="idx-bid-lbl">Güncel Teklif</div>
                            <div class="idx-bid-val">{{ $auction->displayPrice() }}</div>
                        </div>
                        <div>
                            <div class="idx-timer-lbl">Kalan</div>
                            <div class="idx-timer-val" data-ends="{{ $auction->ends_at->timestamp }}">
                                {{ $auction->timeLeft() }}
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
/* ── Aktif sort takibi ── */
let currentSort = '{{ request('sort', 'bids') }}';

function setSort(val) {
    currentSort = val;
    document.querySelectorAll('.idx-sort-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('sort-' + val)?.classList.add('active');
    applyFilters();
}

/* ── URL parametreleriyle sunucuya gönder ── */
function applyFilters() {
    const params = new URLSearchParams();
    const q   = document.getElementById('search-input')?.value.trim();
    const cat = document.getElementById('cat-select')?.value;
    const st  = document.getElementById('status-select')?.value;
    if (q)   params.set('q', q);
    if (cat) params.set('category', cat);
    if (st)  params.set('status', st);
    if (currentSort && currentSort !== 'bids') params.set('sort', currentSort);
    window.location.href = '?' + params.toString();
}

/* ── Anlık arama (client-side, sadece görünür kartları filtreler) ── */
let searchTimer;
document.getElementById('search-input')?.addEventListener('input', function () {
    clearTimeout(searchTimer);
    const q = this.value.toLowerCase().trim();

    if (!q) {
        // Temizle — sunucuya git
        searchTimer = setTimeout(() => applyFilters(), 600);
        return;
    }

    // Anlık: sadece mevcut kartları filtrele (server'a gitmeden)
    let visible = 0;
    document.querySelectorAll('.auction-item').forEach(el => {
        const match = el.dataset.title.includes(q);
        el.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    document.getElementById('result-count').textContent = visible;
    document.getElementById('no-results').style.display = visible === 0 ? 'block' : 'none';
});

/* ── Geri sayım ── */
function updateTimers() {
    const now = Math.floor(Date.now() / 1000);
    document.querySelectorAll('[data-ends]').forEach(el => {
        const diff = parseInt(el.dataset.ends) - now;
        if (diff <= 0) { el.textContent = 'Bitti'; el.classList.add('critical'); return; }
        const h = Math.floor(diff / 3600);
        const m = Math.floor((diff % 3600) / 60);
        const s = diff % 60;
        el.textContent = h > 0
            ? `${h}s ${String(m).padStart(2,'0')}d`
            : `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
        if (diff < 1800) el.classList.add('critical');
    });
}
setInterval(updateTimers, 1000);
updateTimers();
</script>
@endpush
