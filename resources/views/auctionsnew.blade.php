@extends('layouts.app')
@section('title', $auction->title)

@push('styles')
<style>
/* ═══════════════════════════════════════
   LIVE DOT & BADGES
═══════════════════════════════════════ */
.live-pill {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.2);
    color: #10b981; border-radius: 20px; padding: 4px 12px;
    font-size: 11px; font-weight: 700; letter-spacing: .3px; text-transform: uppercase;
}
.live-dot {
    width: 7px; height: 7px; background: #10b981;
    border-radius: 50%; flex-shrink: 0;
    animation: livepulse 1.6s infinite;
}
@keyframes livepulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.35;transform:scale(1.7)} }
.viewer-pill {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--card); border: 1px solid var(--border);
    color: var(--muted); border-radius: 20px; padding: 4px 12px;
    font-size: 11px; font-weight: 600;
}

/* ═══════════════════════════════════════
   PAGE LAYOUT
═══════════════════════════════════════ */
.auction-grid { display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start; }
@media(max-width:1100px) { .auction-grid { grid-template-columns: 1fr; } }

/* ═══════════════════════════════════════
   CARD BASE
═══════════════════════════════════════ */
.au-card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; }
.au-card-head { display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border-bottom: 1px solid var(--border); }
.au-card-title { font-size: 12px; font-weight: 700; letter-spacing: .6px; text-transform: uppercase; color: var(--muted); display: flex; align-items: center; gap: 8px; }
.au-card-title i { font-size: 14px; color: var(--primary); }

/* ═══════════════════════════════════════
   BREADCRUMB & TOOLBAR
═══════════════════════════════════════ */
.au-toolbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
.au-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--muted); }
.au-breadcrumb a { color: var(--muted); text-decoration: none; }
.au-breadcrumb a:hover { color: var(--primary); }
.au-breadcrumb .sep { opacity: .4; }
.au-title { font-size: 17px; font-weight: 700; color: var(--text); margin-bottom: 4px; line-height: 1.3; }
.au-status-badges { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

/* ═══════════════════════════════════════
   CAMERA / LIVE STREAM
═══════════════════════════════════════ */
.camera-section { position: relative; background: #000; border-radius: 16px; overflow: hidden; aspect-ratio: 16/9; border: 1px solid var(--border); }
.camera-video { width: 100%; height: 100%; object-fit: cover; display: block; }
.camera-overlay { position: absolute; inset: 0; display: flex; flex-direction: column; justify-content: space-between; pointer-events: none; }
.camera-top-bar { display: flex; align-items: flex-start; justify-content: space-between; padding: 14px 16px; background: linear-gradient(to bottom, rgba(0,0,0,.6) 0%, transparent 100%); pointer-events: all; }
.camera-bottom-bar { display: flex; align-items: flex-end; justify-content: space-between; padding: 14px 16px; background: linear-gradient(to top, rgba(0,0,0,.7) 0%, transparent 100%); pointer-events: all; }
.cam-off-banner { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; }
.cam-off-banner i { font-size: 52px; color: rgba(255,255,255,.15); }
.cam-off-banner p { font-size: 13px; color: rgba(255,255,255,.35); margin: 0; }
.cam-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; height: 36px; padding: 0 14px; border-radius: 10px; border: 1px solid rgba(255,255,255,.15); background: rgba(255,255,255,.08); color: #fff; font-size: 12px; font-weight: 600; cursor: pointer; transition: background .15s; backdrop-filter: blur(8px); }
.cam-btn:hover { background: rgba(255,255,255,.18); }
.cam-btn i { font-size: 15px; }
.cam-btn-icon { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 10px; border: 1px solid rgba(255,255,255,.15); background: rgba(255,255,255,.08); color: #fff; cursor: pointer; transition: background .15s; backdrop-filter: blur(8px); }
.cam-btn-icon:hover { background: rgba(255,255,255,.18); }
.cam-btn-icon i { font-size: 16px; }

/* ═══════════════════════════════════════
   GALLERY
═══════════════════════════════════════ */
.gallery-main { width: 100%; aspect-ratio: 4/3; object-fit: contain; background: rgba(0,0,0,.3); border-radius: 12px; cursor: zoom-in; transition: opacity .15s; }
.gallery-thumbs { display: flex; gap: 8px; padding: 14px 18px; overflow-x: auto; scrollbar-width: none; }
.gallery-thumbs::-webkit-scrollbar { display: none; }
.gallery-thumb { width: 58px; height: 58px; flex-shrink: 0; object-fit: cover; border-radius: 8px; cursor: pointer; border: 2px solid transparent; opacity: .55; transition: opacity .15s, border-color .15s, transform .15s; }
.gallery-thumb.active, .gallery-thumb:hover { opacity: 1; border-color: var(--primary); transform: translateY(-1px); }
.mode-toggle { display: flex; background: var(--card); border: 1px solid var(--border); border-radius: 10px; padding: 3px; gap: 2px; }
.mode-btn { display: flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 7px; font-size: 12px; font-weight: 600; color: var(--muted); cursor: pointer; border: none; background: transparent; transition: background .15s, color .15s; }
.mode-btn.active { background: var(--primary); color: #fff; }
.mode-btn i { font-size: 14px; }

/* ═══════════════════════════════════════
   DETAIL ROWS
═══════════════════════════════════════ */
.detail-row { display: flex; align-items: center; gap: 12px; padding: 11px 18px; border-bottom: 1px solid var(--border); }
.detail-row:last-child { border-bottom: none; }
.detail-icon { width: 32px; height: 32px; border-radius: 8px; background: rgba(145,70,255,.1); border: 1px solid rgba(145,70,255,.15); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.detail-icon i { font-size: 15px; color: var(--primary); }
.detail-lbl { font-size: 11px; color: var(--muted); margin-bottom: 2px; }
.detail-val { font-size: 13px; font-weight: 600; color: var(--text); }

/* ═══════════════════════════════════════
   BID PANEL
═══════════════════════════════════════ */
.bid-column { position: sticky; top: 16px; display: flex; flex-direction: column; gap: 16px; }
.price-hero { background: var(--primary); padding: 20px 20px 16px; position: relative; overflow: hidden; }
.price-hero::before { content: ''; position: absolute; right: -20px; top: -20px; width: 100px; height: 100px; background: rgba(255,255,255,.05); border-radius: 50%; }
.price-lbl { font-size: 10px; color: rgba(255,255,255,.6); letter-spacing: .5px; text-transform: uppercase; margin-bottom: 4px; }
.price-value { font-size: 2.4rem; font-weight: 800; color: #fff; line-height: 1; letter-spacing: -1px; }
.price-value.price-flash { animation: priceflash .6s ease forwards; }
@keyframes priceflash { 0%{transform:scale(1.06)} 100%{transform:scale(1)} }
.price-start { font-size: 11px; color: rgba(255,255,255,.5); margin-top: 6px; }
.buy-now-box { background: rgba(0,0,0,.15); border-radius: 10px; padding: 10px 14px; margin-top: 14px; display: flex; align-items: center; justify-content: space-between; }
.buy-now-lbl { font-size: 10px; color: rgba(255,255,255,.55); margin-bottom: 2px; }
.buy-now-val { font-size: 16px; font-weight: 800; color: #fbbf24; }
.stats-row { display: grid; grid-template-columns: repeat(3, 1fr); border-bottom: 1px solid var(--border); }
.stat-cell { padding: 12px 8px; text-align: center; }
.stat-cell + .stat-cell { border-left: 1px solid var(--border); }
.stat-lbl { font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: .4px; margin-bottom: 3px; }
.stat-val { font-size: 17px; font-weight: 700; color: var(--text); }
.stat-val.timer-critical { color: #f87171; animation: timerblink 1s infinite; }
@keyframes timerblink { 50%{opacity:.5} }
.quick-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-bottom: 12px; }
.quick-btn { background: var(--card); border: 1px solid var(--border); border-radius: 10px; padding: 10px 6px; text-align: center; cursor: pointer; font-size: 11px; font-weight: 700; color: var(--text); line-height: 1.4; transition: border-color .15s, color .15s; }
.quick-btn span { display: block; font-size: 10px; font-weight: 400; color: var(--muted); margin-top: 2px; }
.quick-btn:hover { border-color: var(--primary); color: var(--primary); }
.bid-form-area { padding: 16px; }
.bid-input-wrap { display: flex; gap: 0; margin-bottom: 10px; border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
.bid-input-wrap:focus-within { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(145,70,255,.15); }
.bid-input-wrap input { flex: 1; padding: 12px 14px; background: transparent; border: none; outline: none; font-size: 15px; font-weight: 700; color: var(--text); min-width: 0; }
.bid-input-wrap input::placeholder { color: var(--muted); font-weight: 400; }
.bid-input-wrap .currency { display: flex; align-items: center; padding: 0 14px; font-size: 14px; font-weight: 700; color: var(--muted); border-left: 1px solid var(--border); }
.bid-error { background: rgba(239,68,68,.08); border: 1px solid rgba(239,68,68,.2); color: #f87171; border-radius: 8px; padding: 9px 12px; font-size: 12px; margin-bottom: 10px; display: none; }
.bid-submit { width: 100%; height: 48px; background: var(--primary); color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: opacity .15s, transform .15s; }
.bid-submit:hover { opacity: .88; transform: translateY(-1px); }
.bid-submit:disabled { opacity: .5; cursor: not-allowed; transform: none; }

/* ═══════════════════════════════════════
   BID FEED
═══════════════════════════════════════ */
.feed-scroll { max-height: 340px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: var(--border) transparent; }
.feed-scroll::-webkit-scrollbar { width: 3px; }
.feed-scroll::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
.bid-item { display: flex; align-items: center; gap: 10px; padding: 11px 18px; border-bottom: 1px solid var(--border); position: relative; transition: background .2s; }
.bid-item:last-child { border-bottom: none; }
.bid-item.bid-new { animation: bidslide .3s ease; }
.bid-item.bid-top { background: rgba(16,185,129,.04); }
@keyframes bidslide { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
.bid-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
.bid-name { font-size: 13px; font-weight: 600; color: var(--text); line-height: 1.2; }
.bid-time { font-size: 11px; color: var(--muted); margin-top: 1px; }
.bid-amount { margin-left: auto; font-size: 13px; font-weight: 700; color: var(--primary); white-space: nowrap; }
.bid-rank { width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 9px; font-weight: 700; flex-shrink: 0; }
.r1 { background: #fbbf24; color: #78350f; }
.r2 { background: #9ca3af; color: #fff; }
.r3 { background: #b87947; color: #fff; }
.rn { background: var(--card); color: var(--muted); border: 1px solid var(--border); }
.top-label { position: absolute; right: 18px; top: 5px; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #10b981; }
.feed-empty { padding: 40px 20px; text-align: center; color: var(--muted); }
.feed-empty i { font-size: 32px; display: block; margin-bottom: 10px; opacity: .25; }
.feed-empty p { font-size: 13px; margin: 0; }

/* ═══════════════════════════════════════
   MOBILE STICKY BAR
═══════════════════════════════════════ */
.bid-sticky-bar { display: none; position: fixed; bottom: 0; left: 0; right: 0; z-index: 9999; background: var(--bg-soft); border-top: 1px solid var(--border); padding: 12px 16px; box-shadow: 0 -12px 32px rgba(0,0,0,.3); backdrop-filter: blur(12px); }
@media(max-width:1100px) { .bid-sticky-bar { display: block; } .bid-column { display: none; } }
.sticky-price-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
.sticky-price { font-size: 1.4rem; font-weight: 800; color: var(--primary); }
.sticky-timer { font-size: 12px; font-weight: 700; color: #f87171; }
.sticky-input-row { display: flex; gap: 8px; }
.sticky-input-row input { flex: 1; background: var(--card); border: 1px solid var(--border); border-radius: 10px; padding: 10px 12px; color: var(--text); font-size: 14px; font-weight: 600; outline: none; }
.sticky-input-row input:focus { border-color: var(--primary); }
.sticky-submit { background: var(--primary); color: #fff; border: none; border-radius: 10px; padding: 0 18px; font-size: 13px; font-weight: 700; cursor: pointer; white-space: nowrap; display: flex; align-items: center; gap: 6px; }
.section-panel { display: none; }
.section-panel.active { display: block; }
</style>
@endpush

@section('content')
<div class="container-fluid py-3" style="max-width:1400px;">

{{-- ── Toolbar ── --}}
<div class="au-toolbar">
    <div>
        <div class="au-title">{{ Str::limit($auction->title, 70) }}</div>
        <div class="au-breadcrumb">
            <a href="{{ route('index') }}">Ana Sayfa</a>
            <span class="sep">/</span>
            <a href="#">Müzayedeler</a>
            <span class="sep">/</span>
            <span>{{ Str::limit($auction->title, 30) }}</span>
        </div>
    </div>
    <div class="au-status-badges">
        @php
            $statusMap = [
                'draft'     => ['Bekliyor', 'warning'],
                'active'    => ['Aktif', 'success'],
                'rejected'  => ['Reddedildi', 'danger'],
                'ended'     => ['Bitti', 'danger'],
                'sold'      => ['Satıldı', 'seller'],
                'cancelled' => ['İptal', 'warning'],
            ];
            [$statusLabel, $statusType] = $statusMap[$auction->status] ?? ['—', 'info'];
        @endphp
        <span class="a-badge {{ $statusType }}">{{ $statusLabel }}</span>

        @if($auction->isActive())
        <span class="live-pill"><span class="live-dot"></span> Canlı</span>
        @endif

        <span class="viewer-pill">
            <i class="bi bi-eye" style="font-size:12px;"></i>
            <span id="viewer-count">—</span> izleyici
        </span>
    </div>
</div>

{{-- ── Main Grid ── --}}
<div class="auction-grid">

    {{-- SOL KOLON --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Mode Toggle --}}
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
            <div class="mode-toggle">
                <button class="mode-btn active" id="tab-gallery" onclick="switchTab('gallery')">
                    <i class="bi bi-images"></i> Fotoğraflar
                </button>
                <button class="mode-btn" id="tab-stream" onclick="switchTab('stream')">
                    <i class="bi bi-camera-video"></i> Canlı İzle
                </button>
            </div>
            <div style="font-size:12px;color:var(--muted);">
                <i class="bi bi-geo-alt" style="margin-right:4px;"></i>{{ $auction->location ?? '—' }}
                &nbsp;·&nbsp;
                <i class="bi bi-tag" style="margin-right:4px;"></i>{{ $auction->category?->name ?? '—' }}
            </div>
        </div>

        {{-- GALLERY PANEL --}}
        <div id="panel-gallery" class="section-panel active au-card" style="overflow:hidden;">
            <div style="padding:14px 18px;">
                <img id="mainImg"
                     src="{{ $auction->cover?->url() ?? asset('assets/media/placeholder.png') }}"
                     class="gallery-main"
                     onclick="openLightbox(this.src)"
                     alt="{{ $auction->title }}">
            </div>
            @if($auction->images->count() > 1)
            <div class="gallery-thumbs">
                @foreach($auction->images as $i => $img)
                <img src="{{ $img->url() }}"
                     onclick="switchImg(this,'{{ $img->url() }}')"
                     class="gallery-thumb {{ $img->is_cover ? 'active' : '' }}"
                     alt="Görsel {{ $i+1 }}">
                @endforeach
            </div>
            @endif
        </div>

        {{-- STREAM PANEL --}}
        <div id="panel-stream" class="section-panel">
            <div class="camera-section">
                <div class="cam-off-banner" id="cam-off-state">
                    <i class="bi bi-camera-video-off"></i>
                    <p>Satıcı henüz yayın başlatmadı</p>
                </div>
                <video id="liveVideo" class="camera-video" autoplay playsinline style="display:none;" muted></video>

                {{-- Satış geri sayım bandı --}}
                <div id="viewer-sell-bar" style="display:none;position:absolute;bottom:0;left:0;right:0;z-index:15;background:rgba(220,38,38,.88);backdrop-filter:blur(6px);padding:10px 18px;display:none;align-items:center;justify-content:center;gap:10px;font-size:14px;font-weight:700;color:#fff;">
                    <i class="bi bi-hourglass-split"></i>
                    <span id="viewer-sell-bar-text">3 saniye sonra satış tamamlanacak…</span>
                </div>

                {{-- Satıldı overlay --}}
                <div id="viewer-sold-overlay" style="display:none;position:absolute;inset:0;background:rgba(0,0,0,.82);z-index:20;border-radius:16px;flex-direction:column;align-items:center;justify-content:center;gap:14px;">
                    <div style="font-size:56px;">🎉</div>
                    <div style="font-size:26px;font-weight:800;color:#10b981;">Satış Tamamlandı!</div>
                    <div id="viewer-sold-sub" style="font-size:14px;color:rgba(255,255,255,.65);">—</div>
                </div>
                <div class="camera-overlay">
                    <div class="camera-top-bar">
                        <div>
                            <span class="live-pill" id="stream-live-pill" style="display:none;">
                                <span class="live-dot"></span> CANLI
                            </span>
                        </div>
                        <div style="display:flex;gap:6px;">
                            <button class="cam-btn-icon" id="vol-btn" onclick="toggleStreamVolume()"
                                    title="Ses aç/kapat" style="display:none;">
                                <i class="bi bi-volume-mute" id="vol-icon"></i>
                            </button>
                            <button class="cam-btn-icon" onclick="toggleFullscreen()"
                                    id="fs-btn" style="display:none;">
                                <i class="bi bi-fullscreen" id="fs-icon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="camera-bottom-bar">
                        <span class="viewer-pill">
                            <i class="bi bi-people" style="font-size:12px;"></i>
                            <span id="viewer-count-stream">—</span> izleyici
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detaylar --}}
        <div class="au-card">
            <div class="au-card-head">
                <div class="au-card-title"><i class="bi bi-info-circle"></i> Ürün Detayları</div>
            </div>
            @foreach([
                ['bi-tag',        'Kategori',        $auction->category?->name ?? '—'],
                ['bi-arrow-up-circle', 'Min. Artış', number_format($auction->min_bid_increment,0,',','.').' ₺'],
                ['bi-star',       'Durum',           match($auction->condition){'new'=>'Sıfır','used'=>'İkinci El','refurbished'=>'Yenilenmiş',default=>'—'}],
                ['bi-geo-alt',    'Konum',           $auction->location ?? '—'],
                ['bi-calendar3',  'Başlangıç',       $auction->starts_at->format('d.m.Y H:i')],
                ['bi-calendar-x', 'Bitiş',           $auction->ends_at->format('d.m.Y H:i')],
                ['bi-eye',        'Görüntülenme',    number_format($auction->view_count).' kez'],
            ] as [$icon,$label,$value])
            <div class="detail-row">
                <div class="detail-icon"><i class="bi {{ $icon }}"></i></div>
                <div>
                    <div class="detail-lbl">{{ $label }}</div>
                    <div class="detail-val">{{ $value }}</div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Açıklama --}}
        <div class="au-card">
            <div class="au-card-head">
                <div class="au-card-title"><i class="bi bi-file-text"></i> Açıklama</div>
            </div>
            <div style="padding:18px;font-size:14px;line-height:1.75;color:var(--text);opacity:.9;">
                {{ $auction->description }}
            </div>
        </div>

    </div>

    {{-- SAĞ KOLON — Teklif Paneli --}}
    <div class="bid-column">

        {{-- Price Hero --}}
        <div class="au-card" style="overflow:hidden;">
            <div class="price-hero">
                <div class="price-lbl">Güncel En Yüksek Teklif</div>
                <div class="price-value" id="live-price">{{ $auction->displayPrice() }}</div>
                <div class="price-start">Başlangıç: {{ number_format($auction->starting_price,0,',','.') }} ₺</div>
                @if($auction->buy_now_price)
                <div class="buy-now-box">
                    <div>
                        <div class="buy-now-lbl">⚡ Hemen Satın Al</div>
                        <div class="buy-now-val">{{ number_format($auction->buy_now_price,0,',','.') }} ₺</div>
                    </div>
                    <button class="cam-btn" style="background:rgba(251,191,36,.15);border-color:rgba(251,191,36,.4);color:#fbbf24;">Hemen Al</button>
                </div>
                @endif
            </div>
            {{-- Stats --}}
            <div class="stats-row">
                <div class="stat-cell">
                    <div class="stat-lbl">Teklif</div>
                    <div class="stat-val" id="live-bid-count">{{ $auction->bidCount() }}</div>
                </div>
                <div class="stat-cell">
                    <div class="stat-lbl">Kalan</div>
                    <div class="stat-val" id="live-timer">—</div>
                </div>
                <div class="stat-cell">
                    <div class="stat-lbl">İzleyici</div>
                    <div class="stat-val" id="live-viewer-stat">—</div>
                </div>
            </div>
            {{-- Bid Form --}}
            <div class="bid-form-area">
                @auth
                    @if($auction->isActive() && $auction->user_id !== auth()->id())
                    @php $minBid = $auction->current_price + $auction->min_bid_increment; @endphp
                    <div class="quick-grid" id="quick-btns">
                        <button class="quick-btn" onclick="setQuick({{ $minBid }})">
                            +{{ number_format($auction->min_bid_increment,0,',','.') }} ₺
                            <span>{{ number_format($minBid,0,',','.') }} ₺</span>
                        </button>
                        <button class="quick-btn" onclick="setQuick({{ $minBid + $auction->min_bid_increment * 4 }})">
                            +{{ number_format($auction->min_bid_increment*5,0,',','.') }} ₺
                            <span>{{ number_format($minBid + $auction->min_bid_increment*4,0,',','.') }} ₺</span>
                        </button>
                        <button class="quick-btn" onclick="setQuick({{ $minBid + $auction->min_bid_increment * 9 }})">
                            +{{ number_format($auction->min_bid_increment*10,0,',','.') }} ₺
                            <span>{{ number_format($minBid + $auction->min_bid_increment*9,0,',','.') }} ₺</span>
                        </button>
                    </div>
                    <div class="bid-input-wrap">
                        <input type="number" id="bid-input"
                               min="{{ $minBid }}" step="{{ $auction->min_bid_increment }}"
                               placeholder="Min: {{ number_format($minBid,0,',','.') }} ₺">
                        <div class="currency">₺</div>
                    </div>
                    <div class="bid-error" id="bid-error"></div>
                    <button class="bid-submit" id="bid-btn" onclick="submitBid()">
                        <i class="bi bi-lightning-charge-fill"></i>
                        <span id="bid-btn-text">Teklif Ver</span>
                    </button>
                    @elseif($auction->user_id === auth()->id())
                    <div class="alert alert-warning mb-0" style="font-size:13px;border-radius:10px;">
                        <i class="bi bi-info-circle me-1"></i> Kendi ilanınıza teklif veremezsiniz.
                    </div>
                    @else
                    <div class="alert alert-danger mb-0" style="font-size:13px;border-radius:10px;">
                        <i class="bi bi-clock me-1"></i> Bu müzayede sona erdi.
                    </div>
                    @endif
                @else
                <a href="{{ route('login') }}" class="bid-submit" style="text-decoration:none;">
                    <i class="bi bi-box-arrow-in-right"></i> Teklif vermek için giriş yap
                </a>
                @endauth
            </div>
        </div>

        {{-- Teklif Feed --}}
        <div class="au-card">
            <div class="au-card-head">
                <div class="au-card-title"><i class="bi bi-activity"></i> Teklif Akışı</div>
                <span class="a-badge info" id="bid-count-badge">{{ $auction->bidCount() }} teklif</span>
            </div>
            <div class="feed-scroll">
                <div id="bid-feed">
                    @forelse($auction->bids->take(15) as $index => $bid)
                    <div class="bid-item {{ $index===0?'bid-top':'' }}">
                        @if($index===0)<span class="top-label">En Yüksek</span>@endif
                        <span class="bid-rank {{ $index===0?'r1':($index===1?'r2':($index===2?'r3':'rn')) }}">{{ $index+1 }}</span>
                        <img class="bid-avatar"
                             src="https://ui-avatars.com/api/?name={{ urlencode($bid->user->name) }}&size=32&background=7c3aed&color=fff"
                             alt="{{ $bid->user->name }}">
                        <div style="flex:1;min-width:0;">
                            <div class="bid-name">{{ $bid->user->name }}</div>
                            <div class="bid-time">{{ $bid->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="bid-amount">{{ number_format($bid->amount,0,',','.') }} ₺</div>
                    </div>
                    @empty
                    <div class="feed-empty" id="feed-empty">
                        <i class="bi bi-inbox"></i>
                        <p>Henüz teklif yok. İlk teklifi sen ver!</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

{{-- MOBİL STICKY BAR --}}
@auth
@if($auction->isActive() && $auction->user_id !== auth()->id())
@php $minBid = $auction->current_price + $auction->min_bid_increment; @endphp
<div class="bid-sticky-bar">
    <div class="sticky-price-row">
        <div>
            <div style="font-size:10px;color:var(--muted);margin-bottom:2px;">Güncel Teklif</div>
            <div class="sticky-price" id="live-price-mobile">{{ $auction->displayPrice() }}</div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:10px;color:var(--muted);margin-bottom:2px;">Kalan Süre</div>
            <div class="sticky-timer" id="live-timer-mobile">—</div>
        </div>
    </div>
    <div class="sticky-input-row">
        <input type="number" id="bid-input-mobile"
               min="{{ $minBid }}" step="{{ $auction->min_bid_increment }}"
               placeholder="Min: {{ number_format($minBid,0,',','.') }} ₺">
        <button class="sticky-submit" onclick="submitBidMobile()">
            <i class="bi bi-lightning-charge-fill"></i> Teklif Ver
        </button>
    </div>
    <div class="bid-error" id="bid-error-mobile" style="margin-top:8px;margin-bottom:0;"></div>
</div>
@endif
@endauth

{{-- Lightbox --}}
<div id="lightbox" onclick="closeLightbox()"
     style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.92);
            align-items:center;justify-content:center;cursor:zoom-out;">
    <img id="lightbox-img" style="max-width:92vw;max-height:92vh;object-fit:contain;border-radius:12px;">
</div>

</div>
@endsection

@push('scripts')
@vite(['resources/js/app.js'])
<script>
/* ─── PHP Sabitleri ─── */
const AUCTION_ID    = {{ $auction->id }};
const MIN_INCREMENT = {{ $auction->min_bid_increment }};
const BID_URL       = "{{ route('bids.store', $auction) }}";
const CSRF          = "{{ csrf_token() }}";
const SELLER_ID     = {{ (int) $auction->user_id }};
const REMAINING_SECS = {{ (int) max(0, $auction->ends_at->diffInSeconds(now(), false) * -1) }};

@auth
const CURRENT_USER_ID = {{ (int) auth()->id() }};
const IS_AUTH = true;
@else
const CURRENT_USER_ID = null;
const IS_AUTH = false;
@endauth

let currentMin = {{ $auction->current_price + $auction->min_bid_increment }};

/* ─── Satıldı / Geri Sayım ─── */
let _cdInterval = null;

function _showSellCountdown(seconds) {
    const bar  = document.getElementById('viewer-sell-bar');
    const text = document.getElementById('viewer-sell-bar-text');
    if (!bar) return;
    bar.style.display = 'flex';
    let rem = seconds;
    text.textContent = rem + ' saniye sonra satış tamamlanacak…';
    clearInterval(_cdInterval);
    _cdInterval = setInterval(() => {
        rem--;
        if (rem <= 0) { clearInterval(_cdInterval); bar.style.display = 'none'; return; }
        text.textContent = rem + ' saniye sonra satış tamamlanacak…';
    }, 1000);
}

function _hideSellCountdown() {
    clearInterval(_cdInterval);
    const bar = document.getElementById('viewer-sell-bar');
    if (bar) bar.style.display = 'none';
}

function _showSoldUi(buyerName, displayPrice) {
    _hideSellCountdown();
    // Overlay
    const overlay = document.getElementById('viewer-sold-overlay');
    if (overlay) {
        document.getElementById('viewer-sold-sub').textContent =
            (buyerName && displayPrice) ? buyerName + ' — ' + displayPrice : (buyerName || displayPrice || '—');
        overlay.style.display = 'flex';
    }
    // Teklif formunu kapat
    const formArea = document.querySelector('.bid-form-area');
    if (formArea) formArea.innerHTML = '<div class="alert alert-success mb-0" style="font-size:13px;border-radius:10px;margin:0;"><i class="bi bi-check-circle me-1"></i> Bu ürün satışa kapatıldı.</div>';
    // Timer durdur
    clearInterval(timerInt);
    ['live-timer','live-timer-mobile'].forEach(id => {
        const el = document.getElementById(id);
        if (el) { el.textContent = 'Satıldı'; el.classList.remove('timer-critical'); el.style.color = '#10b981'; }
    });
    // Mobile sticky bar gizle
    document.querySelector('.bid-sticky-bar')?.remove();
    // Swal
    if (typeof Swal !== 'undefined' && buyerName) {
        Swal.fire({ toast:true, position:'top-end', icon:'success', title:'🎉 Satış Tamamlandı',
            text: buyerName + (displayPrice ? ' — ' + displayPrice : ''),
            showConfirmButton:false, timer:6000, timerProgressBar:true });
    }
}

/* ─── WebRTC ─── */
const ICE_SERVERS = { iceServers: [{ urls: 'stun:stun.l.google.com:19302' }, { urls: 'stun:stun1.l.google.com:19302' }] };
let peerConnection  = null;
let presenceChannel = null;
let streamMuted     = true;

/* ─── Geri Sayım ─── */
let remainingSecs = REMAINING_SECS;
let timerInt = null;
function _startTimer() {
    const tick = () => {
        if (remainingSecs > 0) remainingSecs--;
        const m   = Math.floor(remainingSecs / 60);
        const sec = remainingSecs % 60;
        const txt = String(m).padStart(2,'0') + ':' + String(sec).padStart(2,'0');
        ['live-timer','live-timer-mobile'].forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;
            el.textContent = remainingSecs > 0 ? txt : 'Bitti';
            el.classList.toggle('timer-critical', remainingSecs <= 60 && remainingSecs > 0);
        });
        if (remainingSecs <= 0) clearInterval(timerInt);
    };
    if (remainingSecs <= 0) { ['live-timer','live-timer-mobile'].forEach(id => { const el=document.getElementById(id); if(el) el.textContent='Bitti'; }); return; }
    tick();
    timerInt = setInterval(tick, 1000);
}

/* ─── WebRTC izleyici tarafı ─── */
async function handleOffer(sdp) {
    // Önceki bağlantıyı temiz kapat
    if (peerConnection) {
        peerConnection.ontrack = null;
        peerConnection.onicecandidate = null;
        peerConnection.onconnectionstatechange = null;
        peerConnection.close();
        peerConnection = null;
    }

    peerConnection = new RTCPeerConnection(ICE_SERVERS);

    peerConnection.ontrack = (event) => {
        const video = document.getElementById('liveVideo');
        if (video.srcObject !== event.streams[0]) video.srcObject = event.streams[0];
        _showLiveStream();
    };

    peerConnection.onicecandidate = ({ candidate }) => {
        if (candidate && presenceChannel) {
            presenceChannel.whisper('webrtc-signal', {
                type        : 'ice-candidate',
                candidate   : candidate,
                targetUserId: SELLER_ID,
                fromUserId  : CURRENT_USER_ID,
            });
        }
    };

    peerConnection.onconnectionstatechange = () => {
        console.log('[Viewer] connectionState:', peerConnection?.connectionState);
        if (['disconnected', 'failed'].includes(peerConnection?.connectionState)) _hideLiveStream();
    };

    try {
        // Sadece offer tipinde sdp kabul et
        await peerConnection.setRemoteDescription(new RTCSessionDescription({ type: 'offer', sdp: sdp.sdp ?? sdp }));
        const answer = await peerConnection.createAnswer();
        await peerConnection.setLocalDescription(answer);
        if (presenceChannel) {
            presenceChannel.whisper('webrtc-signal', {
                type        : 'answer',
                sdp         : answer,
                targetUserId: SELLER_ID,
                fromUserId  : CURRENT_USER_ID,
            });
        }
        console.log('[Viewer] Answer gönderildi → satıcıya');
    } catch (err) {
        console.error('[Viewer] handleOffer hatası:', err);
    }
}

async function handleSellerIce(candidate) {
    if (!peerConnection) return;
    if (peerConnection.remoteDescription === null) {
        console.warn('[Viewer] ICE geldi ama remoteDescription henüz yok, bekleniyor...');
        return;
    }
    try {
        await peerConnection.addIceCandidate(new RTCIceCandidate(candidate));
    } catch(e) {
        console.warn('[Viewer] addIceCandidate hatası:', e);
    }
}

function _showLiveStream() {
    const video = document.getElementById('liveVideo');
    video.style.display = 'block';
    document.getElementById('cam-off-state').style.display = 'none';
    document.getElementById('stream-live-pill').style.display = 'inline-flex';
    document.getElementById('vol-btn').style.display = 'inline-flex';
    document.getElementById('fs-btn').style.display  = 'inline-flex';
    document.getElementById('vol-icon').className = 'bi bi-volume-mute';
}

function _hideLiveStream() {
    const video = document.getElementById('liveVideo');
    video.style.display = 'none'; video.srcObject = null;
    document.getElementById('cam-off-state').style.display = 'flex';
    document.getElementById('stream-live-pill').style.display = 'none';
    document.getElementById('vol-btn').style.display = 'none';
    document.getElementById('fs-btn').style.display  = 'none';
}

function toggleStreamVolume() {
    const video = document.getElementById('liveVideo');
    video.muted = !video.muted;
    streamMuted = video.muted;
    document.getElementById('vol-icon').className = video.muted ? 'bi bi-volume-mute' : 'bi bi-volume-up';
}

function toggleFullscreen() {
    const section = document.querySelector('.camera-section');
    if (!document.fullscreenElement) {
        section.requestFullscreen?.();
        document.getElementById('fs-icon').className = 'bi bi-fullscreen-exit';
    } else {
        document.exitFullscreen?.();
        document.getElementById('fs-icon').className = 'bi bi-fullscreen';
    }
}

/* ─── Viewer count ─── */
function setViewerCount(n) {
    ['viewer-count','viewer-count-stream','live-viewer-stat'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.textContent = n;
    });
}

/* ─── Echo / Reverb init ─── */
document.addEventListener('DOMContentLoaded', () => {
    // Geri sayımı başlat
    _startTimer();

    if (typeof window.Echo === 'undefined') {
        console.error('[Auction] window.Echo bulunamadı!');
        return;
    }

    if (IS_AUTH) {
        /* Giriş yapmış kullanıcı — presence kanalı */
        presenceChannel = window.Echo.join(`auction.${AUCTION_ID}`);

        presenceChannel
            .here((users) => {
                console.log('[Auction] Kanalda', users.length, 'üye:', users.map(u => u.id));
                // Satıcıyı hariç tut
                const viewers = users.filter(u => parseInt(u.id, 10) !== SELLER_ID).length;
                setViewerCount(viewers);
            })
            .joining((user) => {
                // Satıcı katılıyorsa sayma
                if (parseInt(user.id, 10) === SELLER_ID) return;
                const el = document.getElementById('viewer-count');
                setViewerCount(parseInt(el?.textContent || '0', 10) + 1);
            })
            .leaving((user) => {
                // Satıcı ayrılıyorsa sayma
                if (parseInt(user.id, 10) === SELLER_ID) return;
                const el = document.getElementById('viewer-count');
                setViewerCount(Math.max(0, parseInt(el?.textContent || '1', 10) - 1));
            })
            .listen('.bid.placed', (data) => {
                console.log('[Auction] Yeni teklif geldi:', data);
                // Kendi teklificinin feed'e çift eklenmesini engelle
                if (data.bidder_id && data.bidder_id === CURRENT_USER_ID) return;
                addBidToFeed(data.bidder_name, data.amount, false);
                updateStats(data);

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        toast: true, position: 'top-end', icon: 'info',
                        title: `🔴 ${data.bidder_name}`,
                        text : `${data.display_price} teklif verdi`,
                        showConfirmButton: false, timer: 4000, timerProgressBar: true,
                    });
                }
            })
            .listen('.auction.sold', (data) => {
                _showSoldUi(data.buyer_name, data.display_price);
            })
            .listenForWhisper('sell-countdown', (data) => {
                if (data.cancelled) {
                    _hideSellCountdown();
                } else {
                    _showSellCountdown(data.seconds ?? 3);
                }
            })
            .listenForWhisper('webrtc-signal', async (data) => {
                if (data.targetUserId !== CURRENT_USER_ID) return;
                if (data.type === 'offer') {
                    await handleOffer(data.sdp);
                } else if (data.type === 'ice-candidate') {
                    await handleSellerIce(data.candidate);
                }
            });

    } else {
        /* Giriş yapmamış kullanıcı — public kanal */
        window.Echo.channel(`auction.${AUCTION_ID}`)
            .listen('.bid.placed', (data) => {
                console.log('[Auction] Teklif (guest):', data);
                addBidToFeed(data.bidder_name, data.amount, false);
                updateStats(data);
            })
            .listen('.auction.sold', (data) => {
                _showSoldUi(data.buyer_name, data.display_price);
            });
        setViewerCount('?');
    }
});

/* ─── Teklif Gönder ─── */
function setQuick(amount) {
    const input = document.getElementById('bid-input');
    if (input) input.value = amount;
}

async function submitBid() {
    await _doSubmit(
        document.getElementById('bid-input'),
        document.getElementById('bid-btn'),
        document.getElementById('bid-btn-text'),
        document.getElementById('bid-error')
    );
}
async function submitBidMobile() {
    await _doSubmit(
        document.getElementById('bid-input-mobile'),
        null, null,
        document.getElementById('bid-error-mobile')
    );
}

async function _doSubmit(input, btn, btnTxt, errEl) {
    const amount = parseFloat(input?.value);
    if (errEl) errEl.style.display = 'none';
    if (!amount || amount < currentMin) {
        if (errEl) { errEl.textContent = `En az ${currentMin.toLocaleString('tr-TR')} ₺ girmelisiniz.`; errEl.style.display = 'block'; }
        return;
    }
    if (btn) btn.disabled = true;
    if (btnTxt) btnTxt.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Gönderiliyor...';

    try {
        const res  = await fetch(BID_URL, {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body    : JSON.stringify({ amount }),
        });
        const data = await res.json();
        if (!res.ok) {
            if (errEl) { errEl.textContent = data.message ?? 'Bir hata oluştu.'; errEl.style.display = 'block'; }
        } else {
            if (input) input.value = '';
            addBidToFeed(data.bidder_name, data.amount, true);
            updateStats(data);
        }
    } catch(e) {
        if (errEl) { errEl.textContent = 'Bağlantı hatası. Tekrar deneyin.'; errEl.style.display = 'block'; }
    }

    if (btn) btn.disabled = false;
    if (btnTxt) btnTxt.innerHTML = '<i class="bi bi-lightning-charge-fill"></i> Teklif Ver';
}

/* ─── Teklif Feed ─── */
function addBidToFeed(name, amount, isMine = false) {
    const feed = document.getElementById('bid-feed');
    document.getElementById('feed-empty')?.remove();

    feed.querySelectorAll('.bid-rank').forEach((el, i) => {
        el.textContent = i + 2;
        el.className   = 'bid-rank ' + (i===0?'r2':i===1?'r3':'rn');
    });
    feed.querySelectorAll('.top-label').forEach(el => el.remove());
    feed.querySelectorAll('.bid-item.bid-top').forEach(el => el.classList.remove('bid-top'));

    const color = isMine ? '10b981' : '7c3aed';
    const item  = document.createElement('div');
    item.className = 'bid-item bid-new bid-top';
    item.innerHTML = `
        <span class="top-label">En Yüksek</span>
        <span class="bid-rank r1">1</span>
        <img class="bid-avatar"
             src="https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&size=32&background=${color}&color=fff">
        <div style="flex:1;min-width:0;">
            <div class="bid-name">${name}${isMine?' <span style="font-size:10px;color:#10b981;">(sen)</span>':''}</div>
            <div class="bid-time">az önce</div>
        </div>
        <div class="bid-amount">${parseFloat(amount).toLocaleString('tr-TR',{minimumFractionDigits:0})} ₺</div>
    `;
    feed.insertBefore(item, feed.firstChild);
    const items = feed.querySelectorAll('.bid-item');
    if (items.length > 15) items[items.length-1].remove();
    document.querySelector('.feed-scroll')?.scrollTo({ top:0, behavior:'smooth' });
}

function updateStats(data) {
    ['live-price','live-price-mobile'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.textContent = data.display_price;
        el.classList.remove('price-flash');
        void el.offsetWidth;
        el.classList.add('price-flash');
    });
    const countEl = document.getElementById('live-bid-count');
    if (countEl) countEl.textContent = data.total_bids;
    const badgeEl = document.getElementById('bid-count-badge');
    if (badgeEl) badgeEl.textContent = data.total_bids + ' teklif';
    currentMin = parseFloat(data.amount) + MIN_INCREMENT;
    ['bid-input','bid-input-mobile'].forEach(id => {
        const el = document.getElementById(id);
        if (el) { el.min = currentMin; el.placeholder = `Min: ${currentMin.toLocaleString('tr-TR')} ₺`; }
    });
    const btns  = document.querySelectorAll('.quick-btn');
    const steps = [0, 4, 9];
    btns.forEach((btn, i) => {
        const val   = currentMin + (MIN_INCREMENT * steps[i]);
        const extra = MIN_INCREMENT * (steps[i] + 1);
        btn.innerHTML = `+${extra.toLocaleString('tr-TR')} ₺<span>${val.toLocaleString('tr-TR')} ₺</span>`;
        btn.onclick   = () => setQuick(val);
    });
}

/* ─── Galeri ─── */
function switchTab(tab) {
    document.querySelectorAll('.section-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.mode-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('panel-' + tab).classList.add('active');
    document.getElementById('tab-' + tab).classList.add('active');
}
function switchImg(el, src) {
    document.getElementById('mainImg').src = src;
    document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}
function openLightbox(src) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox').style.display = 'flex';
}
function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
}
document.addEventListener('keydown', e => { if(e.key==='Escape') closeLightbox(); });

/* ─── Klavye ─── */
document.getElementById('bid-input')?.addEventListener('keydown', e => { if (e.key === 'Enter') submitBid(); });
document.getElementById('bid-input-mobile')?.addEventListener('keydown', e => { if (e.key === 'Enter') submitBidMobile(); });
</script>
@endpush
