@extends('layouts.app')
@section('title', 'Canlı Yayın — ' . $auction->title)

@push('styles')
<style>
.au-card-title {padding:1rem;}
.au-card-head span{padding-left:1rem;}
.lb-root       { display: flex; flex-direction: column; gap: 24px; }
.lb-topbar     { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 16px; }
.lb-topbar-left  { display: flex; flex-direction: column; gap: 4px; }
.lb-topbar-right { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

.lb-grid     { display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start; }
.lb-col-left  { display: flex; flex-direction: column; gap: 16px; }
.lb-col-right { display: flex; flex-direction: column; gap: 16px; }

.lb-cam-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 9px 18px; border-radius: 10px;
    border: 1px solid var(--border); background: var(--bg-soft);
    color: var(--text); font-size: 13px; font-weight: 600;
    cursor: pointer; transition: background .2s, border-color .2s;
}
.lb-cam-btn:hover { border-color: rgba(145,70,255,.4); }
.lb-cam-btn.lb-cam-on { background: rgba(220,38,38,.1); border-color: rgba(220,38,38,.4); color: #dc2626; }
.lb-cam-dot { width: 10px; height: 10px; border-radius: 50%; background: var(--muted); flex-shrink: 0; transition: background .2s; }
.lb-cam-btn.lb-cam-on .lb-cam-dot { background: #dc2626; animation: lb-cam-pulse 1s ease-in-out infinite; }
@keyframes lb-cam-pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.3;transform:scale(1.6)} }

.lb-live-badge { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 20px; background: #dc2626; color: #fff; font-size: 11px; font-weight: 700; letter-spacing: .4px; }
.lb-live-dot { width: 8px; height: 8px; border-radius: 50%; background: #fff; animation: lb-cam-pulse .9s ease-in-out infinite; }
.lb-viewer-pill { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 20px; background: var(--bg-soft); border: 1px solid var(--border); color: var(--muted); font-size: 11px; font-weight: 600; }

.lb-video-wrap { background: #08080f; border-radius: 14px; overflow: hidden; aspect-ratio: 16/9; position: relative; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); }
.lb-video-stream { width: 100%; height: 100%; object-fit: cover; display: none; }
.lb-video-stream.active { display: block; }
.lb-video-off-state { display: flex; flex-direction: column; align-items: center; gap: 10px; color: rgba(255,255,255,.3); }
.lb-video-off-state.hidden { display: none; }
.lb-video-off-icon { width: 56px; height: 56px; border-radius: 50%; background: rgba(255,255,255,.06); display: flex; align-items: center; justify-content: center; font-size: 22px; }
.lb-video-off-text { font-size: 13px; }

.lb-overlay-live { position: absolute; top: 14px; left: 14px; display: flex; align-items: center; gap: 6px; padding: 5px 12px; background: rgba(220,38,38,.88); border-radius: 20px; font-size: 11px; font-weight: 700; color: #fff; letter-spacing: .3px; }
.lb-overlay-live .lb-live-dot { width: 7px; height: 7px; }
.lb-overlay-viewers { position: absolute; top: 14px; right: 14px; display: flex; align-items: center; gap: 5px; padding: 5px 12px; background: rgba(0,0,0,.5); border-radius: 20px; font-size: 11px; color: rgba(255,255,255,.85); }

.lb-toast-wrap { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; pointer-events: none; }
.lb-toast { background: rgba(39,80,10,.92); color: #d4edbd; border-radius: 14px; padding: 20px 32px; text-align: center; opacity: 0; transform: scale(.88); transition: opacity .3s ease, transform .3s ease; pointer-events: none; }
.lb-toast.lb-toast-show { opacity: 1; transform: scale(1); }
.lb-toast-title { font-size: 18px; font-weight: 700; margin-bottom: 6px; color: #d4edbd; }
.lb-toast-sub   { font-size: 13px; color: rgba(212,237,189,.8); }

.lb-item-img { width: 52px; height: 52px; border-radius: 10px; object-fit: cover; border: 1px solid var(--border); flex-shrink: 0; }
.lb-item-img-placeholder { width: 52px; height: 52px; border-radius: 10px; background: rgba(145,70,255,.1); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 22px; color: var(--primary); }
.lb-item-title  { font-size: 15px; font-weight: 700; color: var(--text); }
.lb-item-meta   { font-size: 13px; color: var(--muted); margin-top: 3px; }
.lb-item-price  { font-size: 22px; font-weight: 800; color: var(--primary); line-height: 1; }
.lb-item-price-label { font-size: 11px; color: var(--muted); margin-top: 3px; }

.lb-timer       { font-size: 22px; font-weight: 800; color: #ef4444; font-variant-numeric: tabular-nums; line-height: 1; padding-left:1rem; }
.lb-timer.lb-timer-safe { color: #10b981; }
.lb-timer-label { font-size: 11px; color: var(--muted); margin-top: 3px; }

.lb-tip { display: flex; align-items: flex-start; gap: 10px; padding: 12px 16px; background: rgba(145,70,255,.06); border: 1px solid rgba(145,70,255,.18); border-radius: 10px; font-size: 13px; color: var(--muted); line-height: 1.6; }
.lb-tip i { font-size: 15px; color: var(--primary); flex-shrink: 0; margin-top: 1px; }

.lb-bid-row { display: flex; align-items: center; gap: 12px; padding: 12px 20px; border-bottom: 1px solid var(--border); transition: background .15s; cursor: pointer; }
.lb-bid-row:last-child { border-bottom: none; }
.lb-bid-row:hover { background: var(--bg-soft); }
.lb-bid-row.lb-bid-new { animation: lb-flash-in .5s ease; }
@keyframes lb-flash-in { 0%{background:rgba(145,70,255,.15)} 100%{background:transparent} }

.lb-bid-radio { width: 18px; height: 18px; border-radius: 50%; border: 2px solid var(--border); flex-shrink: 0; cursor: pointer; transition: background .15s, border-color .15s; position: relative; }
.lb-bid-radio::after { content: ''; position: absolute; inset: 3px; border-radius: 50%; background: transparent; transition: background .15s; }
.lb-bid-radio.lb-selected { border-color: var(--primary); background: rgba(145,70,255,.12); }
.lb-bid-radio.lb-selected::after { background: var(--primary); }

.lb-bid-avatar { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0; }
.lb-bid-name   { font-size: 14px; font-weight: 600; color: var(--text); }
.lb-bid-time   { font-size: 11px; color: var(--muted); margin-top: 2px; }
.lb-bid-amount { font-size: 15px; font-weight: 800; color: #10b981; white-space: nowrap; }

.lb-sell-section { padding: 16px 20px; border-top: 1px solid var(--border); display: flex; flex-direction: column; gap: 12px; }
.lb-sell-meta { display: flex; align-items: center; justify-content: space-between; }
.lb-sell-meta-label { font-size: 13px; color: var(--muted); }
.lb-sell-meta-value { font-size: 13px; font-weight: 700; color: var(--text); }

.lb-sell-btn { width: 100%; padding: 12px; border-radius: 10px; border: none; background: var(--primary); color: #fff; font-size: 14px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: opacity .15s, background .2s; }
.lb-sell-btn:hover:not(:disabled) { opacity: .88; }
.lb-sell-btn:disabled { opacity: .45; cursor: not-allowed; }
.lb-sell-btn.lb-sell-confirming { background: #92400e; cursor: not-allowed; }
.lb-sell-btn.lb-sell-done       { background: #166534; cursor: not-allowed; }

.lb-cbar-wrap { height: 4px; border-radius: 4px; background: var(--border); overflow: hidden; }
.lb-cbar      { height: 100%; border-radius: 4px; background: #f59e0b; width: 0; transition: width .1s linear, background .3s; }
.lb-cbar.lb-cbar-done { background: #22c55e; }

.lb-ctrl-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.lb-ctrl-btn { display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 16px 8px; border-radius: 10px; border: 1px solid var(--border); background: var(--bg-soft); color: var(--muted); font-size: 11px; font-weight: 600; cursor: pointer; text-align: center; transition: background .15s, border-color .15s; }
.lb-ctrl-btn i { font-size: 22px; color: var(--muted); transition: color .15s; }
.lb-ctrl-btn:hover { background: rgba(145,70,255,.08); border-color: rgba(145,70,255,.3); }
.lb-ctrl-btn:hover i { color: var(--primary); }
.lb-ctrl-btn.lb-ctrl-active { background: rgba(145,70,255,.1); border-color: rgba(145,70,255,.35); color: var(--primary); }
.lb-ctrl-btn.lb-ctrl-active i { color: var(--primary); }
.lb-ctrl-btn.lb-ctrl-danger { border-color: rgba(239,68,68,.3); }
.lb-ctrl-btn.lb-ctrl-danger i { color: #ef4444; }
.lb-ctrl-btn.lb-ctrl-danger:hover { background: rgba(239,68,68,.08); border-color: rgba(239,68,68,.5); }

.lb-av-purple { background: rgba(145,70,255,.15);  color: var(--primary); }
.lb-av-green  { background: rgba(16,185,129,.15);  color: #059669; }
.lb-av-amber  { background: rgba(251,191,36,.15);  color: #d97706; }
.lb-av-pink   { background: rgba(236,72,153,.15);  color: #db2777; }
.lb-av-blue   { background: rgba(59,130,246,.15);  color: #2563eb; }

@media(max-width:1024px) { .lb-grid { grid-template-columns: 1fr; } }
@media(max-width:640px) {
    .lb-topbar { flex-direction: column; align-items: flex-start; }
    .lb-bid-row { padding: 10px 14px; gap: 8px; }
    .lb-ctrl-grid { grid-template-columns: 1fr 1fr; }
}
</style>
@endpush

@section('content')
@auth
@if(auth()->id() === $auction->user_id)

@php
    $bids      = $auction->bids->sortByDesc('amount');
    $topBid    = $bids->first();
    $bidCount  = $bids->count();
    $sellRoute = route('seller.auctions.sell', $auction);
    $endRoute  = route('seller.auctions.end-broadcast', $auction);
@endphp

<div class="pf-root container-fluid px-2 px-md-4 py-4">
<div class="lb-root">

    {{-- TOP BAR --}}
    <div class="lb-topbar">
        <div class="lb-topbar-left">
            <h1 class="pf-toolbar-title">Canlı Yayın</h1>
            <div style="font-size:13px;color:var(--muted);">
                {{ $auction->title }} — #{{ $auction->id }}
            </div>
        </div>
        <div class="lb-topbar-right">
            <button class="lb-cam-btn" id="camBtn" onclick="LB.toggleCamera()">
                <span class="lb-cam-dot" id="camDot"></span>
                <span id="camBtnLabel">Kamera Başlat</span>
            </button>
            <div class="lb-live-badge" id="liveBadge" style="display:none;">
                <div class="lb-live-dot"></div> CANLI
            </div>
            <div class="lb-viewer-pill">
                <i class="bi bi-eye"></i>
                <span id="viewerCount">0</span> izleyici
            </div>
        </div>
    </div>

    {{-- ANA GRID --}}
    <div class="lb-grid">

        {{-- SOL KOLON --}}
        <div class="lb-col-left">

            {{-- Video --}}
            <div class="lb-video-wrap" id="videoWrap">
                <video class="lb-video-stream" id="videoStream" autoplay muted playsinline></video>

                <div class="lb-video-off-state" id="camOffState">
                    <div class="lb-video-off-icon"><i class="bi bi-camera-video-off"></i></div>
                    <span class="lb-video-off-text">Kamera kapalı</span>
                </div>

                <div class="lb-overlay-live" id="liveOverlay" style="display:none;">
                    <div class="lb-live-dot"></div> CANLI
                </div>

                <div class="lb-overlay-viewers">
                    <i class="bi bi-eye"></i>
                    <span id="viewerCount2">0</span>
                </div>

                <div class="lb-toast-wrap">
                    <div class="lb-toast" id="soldToast">
                        <div class="lb-toast-title" id="toastTitle">Satış Tamamlandı! 🎉</div>
                        <div class="lb-toast-sub"   id="toastSub">—</div>
                    </div>
                </div>
            </div>

            {{-- Güncel İlan --}}
            <div class="au-card">
                <div class="au-card-head">
                    <div class="au-card-title"><i class="bi bi-box-seam"></i> Güncel İlan</div>
                    <div class="lb-timer lb-timer-safe" id="auctionTimer">--:--</div>
                </div>
                <div style="padding:20px 24px;">
                    <div style="display:flex;align-items:center;gap:16px;">
                        @if($auction->cover?->url())
                            <img src="{{ $auction->cover->url() }}" class="lb-item-img" alt="{{ $auction->title }}">
                        @else
                            <div class="lb-item-img-placeholder"><i class="bi bi-image"></i></div>
                        @endif
                        <div style="flex:1;min-width:0;">
                            <div class="lb-item-title">{{ Str::limit($auction->title, 55) }}</div>
                            <div class="lb-item-meta">
                                Başlangıç: {{ number_format($auction->starting_price, 0, ',', '.') }} ₺
                                &nbsp;·&nbsp; <span id="bidCountInline">{{ $bidCount }}</span> teklif
                            </div>
                        </div>
                        <div style="text-align:right;flex-shrink:0;">
                            <div class="lb-item-price" id="topBidPrice">
                                {{ $topBid ? number_format($topBid->amount,0,',','.') . ' ₺' : number_format($auction->starting_price,0,',','.') . ' ₺' }}
                            </div>
                            <div class="lb-item-price-label">En yüksek teklif</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bilgi --}}
            <div class="lb-tip">
                <i class="bi bi-info-circle"></i>
                <span>
                    Listeden bir teklif seçin, ardından <strong>Bu Teklife Sat</strong> butonuna basın.
                    <strong>3 saniyelik</strong> geri sayım sonrası satış tamamlanır — iptal etmek için süre içinde tekrar tıklayın.
                </span>
            </div>

        </div>

        {{-- SAĞ KOLON --}}
        <div class="lb-col-right">

            {{-- Teklif Listesi --}}
            <div class="au-card">
                <div class="au-card-head">
                    <div class="au-card-title"><i class="bi bi-hammer"></i> Teklifler</div>
                    <span style="font-size:12px;color:var(--muted);" id="bidCountLabel">{{ $bidCount }} teklif</span>
                </div>

                <div id="bidList" style="overflow-y:auto;max-height:360px;">
                    @forelse($bids as $i => $bid)
                    <div class="lb-bid-row {{ $i === 0 ? 'lb-bid-selected' : '' }}"
                         data-bid-id="{{ $bid->id }}"
                         data-amount="{{ $bid->amount }}"
                         data-name="{{ $bid->user->name }}"
                         onclick="LB.selectBid(this)">
                        <div class="lb-bid-radio {{ $i === 0 ? 'lb-selected' : '' }}" id="radio-{{ $bid->id }}"></div>
                        <div class="lb-bid-avatar lb-av-{{ ['purple','green','amber','pink','blue'][$i % 5] }}">
                            {{ strtoupper(mb_substr($bid->user->name, 0, 1)) }}{{ strtoupper(mb_substr(explode(' ', $bid->user->name)[1] ?? 'X', 0, 1)) }}
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div class="lb-bid-name">{{ $bid->user->name }}</div>
                            <div class="lb-bid-time">{{ $bid->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="lb-bid-amount">{{ number_format($bid->amount, 0, ',', '.') }} ₺</div>
                    </div>
                    @empty
                    <div style="padding:40px 20px;text-align:center;color:var(--muted);" id="bidListEmpty">
                        <i class="bi bi-hammer" style="font-size:28px;display:block;margin-bottom:10px;opacity:.25;"></i>
                        <p style="font-size:13px;margin:0;">Henüz teklif yok</p>
                    </div>
                    @endforelse
                </div>

                {{-- Sat bölümü --}}
                <div class="lb-sell-section">
                    <div class="lb-sell-meta">
                        <span class="lb-sell-meta-label">Seçili teklif:</span>
                        <span class="lb-sell-meta-value" id="selectedLabel">
                            @if($topBid)
                                {{ $topBid->user->name }} — {{ number_format($topBid->amount, 0, ',', '.') }} ₺
                            @else
                                Seçilmedi
                            @endif
                        </span>
                    </div>

                    <button class="lb-sell-btn" id="sellBtn"
                            onclick="LB.startSell()"
                            @if($bids->isEmpty()) disabled @endif>
                        <i class="bi bi-check-lg" id="sellBtnIcon"></i>
                        <span id="sellBtnText">Bu Teklife Sat</span>
                    </button>

                    <div class="lb-cbar-wrap">
                        <div class="lb-cbar" id="sellCbar"></div>
                    </div>
                </div>
            </div>

            {{-- Yayın Kontrolleri --}}
            <div class="au-card">
                <div class="au-card-head">
                    <div class="au-card-title"><i class="bi bi-sliders"></i> Yayın Kontrolleri</div>
                </div>
                <div style="padding:16px 20px;">
                    <div class="lb-ctrl-grid">
                        <button class="lb-ctrl-btn" id="micBtn" onclick="LB.toggleMic()">
                            <i class="bi bi-mic" id="micIcon"></i>
                            <span id="micLabel">Mikrofon</span>
                        </button>
                        <button class="lb-ctrl-btn" id="screenBtn" onclick="LB.toggleScreen()">
                            <i class="bi bi-display" id="screenIcon"></i>
                            <span id="screenLabel">Ekran Paylaş</span>
                        </button>
                        <button class="lb-ctrl-btn" id="camFlipBtn" onclick="LB.flipCamera()" style="display:none;">
                            <i class="bi bi-arrow-repeat"></i>
                            <span>Kamerayı Çevir</span>
                        </button>
                        <button class="lb-ctrl-btn lb-ctrl-danger" onclick="LB.endBroadcast()">
                            <i class="bi bi-stop-circle"></i>
                            <span>Yayını Bitir</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
</div>

@push('scripts')
@vite(['resources/js/app.js'])
<script>
const LB_CONFIG = Object.freeze({
    auctionId    : {{ (int) $auction->id }},
    sellEndpoint : @json($sellRoute),
    endEndpoint  : @json($endRoute),
    csrfToken    : @json(csrf_token()),
    remainingSecs: {{ (int) max(0, $auction->ends_at->diffInSeconds(now(), false) * -1) }},
    topBidId     : {{ $topBid ? (int) $topBid->id     : 'null' }},
    topBidName   : @json($topBid?->user->name ?? ''),
    topBidAmount : {{ $topBid ? (int) $topBid->amount : 0 }},
    userId       : {{ (int) auth()->id() }},
    isSold       : {{ in_array($auction->status, ['sold','ended']) ? 'true' : 'false' }},
});

const ICE_SERVERS = {
    iceServers: [
        { urls: 'stun:stun.l.google.com:19302' },
        { urls: 'stun:stun1.l.google.com:19302' },
    ]
};

const LB = (() => {
    'use strict';

    const s = {
        cameraOn       : false,
        micOn          : false,
        screenOn       : false,
        facingMode     : 'user',
        selectedBidId  : LB_CONFIG.topBidId,
        selectedName   : LB_CONFIG.topBidName,
        selectedAmount : LB_CONFIG.topBidAmount,
        selling        : false,
        sellInterval   : null,
        sellTimeout    : null,
        timerInterval  : null,
        remainingSecs  : LB_CONFIG.remainingSecs,
        mediaStream    : null,
        avatarIdx      : {{ $bidCount }},
        peers          : {},
        presenceChannel: null,
        // Presence kanalındaki tüm üyeler (id => true)
        memberIds      : new Set(),
    };

    const AVATAR_CLASSES = ['lb-av-purple','lb-av-green','lb-av-amber','lb-av-pink','lb-av-blue'];

    /* ════ KAMERA ════ */
    async function toggleCamera() {
        s.cameraOn ? stopCamera() : await startCamera();
    }

    async function startCamera(facingOverride) {
        try {
            const constraints = {
                video : { facingMode: facingOverride ?? s.facingMode, width: { ideal: 1280 }, height: { ideal: 720 } },
                audio : true,
            };
            const stream = await navigator.mediaDevices.getUserMedia(constraints);
            _applyStream(stream);
            s.micOn = true;
            document.getElementById('camFlipBtn').style.display = '';
            // Kanalda bekleyen herkese offer gönder
            _offerToAllViewers();
        } catch (err) {
            _showToast('Kamera Hatası', err.message);
        }
    }

    function _applyStream(stream) {
        if (s.mediaStream) s.mediaStream.getTracks().forEach(t => t.stop());
        s.mediaStream = stream;
        s.cameraOn    = true;
        const video = document.getElementById('videoStream');
        video.srcObject = stream;
        video.classList.add('active');
        document.getElementById('camOffState').classList.add('hidden');
        document.getElementById('camBtn').classList.add('lb-cam-on');
        document.getElementById('camBtnLabel').textContent = 'Kamerayı Kapat';
        document.getElementById('liveOverlay').style.display = '';
        document.getElementById('liveBadge').style.display   = '';
    }

    function stopCamera() {
        if (s.mediaStream) { s.mediaStream.getTracks().forEach(t => t.stop()); s.mediaStream = null; }
        s.cameraOn = false; s.micOn = false; s.screenOn = false;
        Object.values(s.peers).forEach(pc => pc.close());
        s.peers = {};
        const video = document.getElementById('videoStream');
        video.srcObject = null; video.classList.remove('active');
        document.getElementById('camOffState').classList.remove('hidden');
        document.getElementById('camBtn').classList.remove('lb-cam-on');
        document.getElementById('camBtnLabel').textContent = 'Kamera Başlat';
        document.getElementById('liveOverlay').style.display = 'none';
        document.getElementById('liveBadge').style.display   = 'none';
        document.getElementById('camFlipBtn').style.display  = 'none';
        document.getElementById('screenBtn').classList.remove('lb-ctrl-active');
        document.getElementById('screenLabel').textContent = 'Ekran Paylaş';
        document.getElementById('micBtn').classList.remove('lb-ctrl-danger');
        document.getElementById('micIcon').className   = 'bi bi-mic';
        document.getElementById('micLabel').textContent = 'Mikrofon';
    }

    async function flipCamera() {
        s.facingMode = s.facingMode === 'user' ? 'environment' : 'user';
        await startCamera(s.facingMode);
    }

    function toggleMic() {
        if (!s.mediaStream) return;
        const track = s.mediaStream.getAudioTracks()[0];
        if (!track) return;
        s.micOn = !s.micOn;
        track.enabled = s.micOn;
        const btn = document.getElementById('micBtn');
        const icon = document.getElementById('micIcon');
        const label = document.getElementById('micLabel');
        if (s.micOn) { btn.classList.remove('lb-ctrl-danger'); icon.className = 'bi bi-mic'; label.textContent = 'Mikrofon'; }
        else { btn.classList.add('lb-ctrl-danger'); icon.className = 'bi bi-mic-mute'; label.textContent = 'Sessiz'; }
    }

    async function toggleScreen() {
        if (s.screenOn) { stopCamera(); return; }
        try {
            const stream = await navigator.mediaDevices.getDisplayMedia({ video: true, audio: true });
            _applyStream(stream);
            s.screenOn = true;
            document.getElementById('screenBtn').classList.add('lb-ctrl-active');
            document.getElementById('screenLabel').textContent = 'Paylaşımı Durdur';
            stream.getVideoTracks()[0].onended = stopCamera;
            _offerToAllViewers();
        } catch (err) { /* kullanıcı iptal etti */ }
    }

    /* ════ WEBRTC — SATICI TARAFI ════ */

    /**
     * s.memberIds setindeki tüm izleyicilere offer gönder.
     * Bu set _initEcho içinde here/joining/leaving ile güncellenir.
     */
    function _offerToAllViewers() {
        s.memberIds.forEach(uid => {
            if (uid !== LB_CONFIG.userId) {
                _createOfferForViewer(uid);
            }
        });
    }

    async function _createOfferForViewer(viewerUserId) {
        if (s.peers[viewerUserId]) { s.peers[viewerUserId].close(); }

        const pc = new RTCPeerConnection(ICE_SERVERS);
        s.peers[viewerUserId] = pc;

        if (s.mediaStream) {
            s.mediaStream.getTracks().forEach(track => pc.addTrack(track, s.mediaStream));
        }

        pc.onicecandidate = ({ candidate }) => {
            if (candidate && s.presenceChannel) {
                s.presenceChannel.whisper('webrtc-signal', {
                    type        : 'ice-candidate',
                    candidate   : candidate,
                    targetUserId: viewerUserId,
                    fromUserId  : LB_CONFIG.userId,
                });
            }
        };

        const offer = await pc.createOffer();
        await pc.setLocalDescription(offer);

        if (s.presenceChannel) {
            s.presenceChannel.whisper('webrtc-signal', {
                type        : 'offer',
                sdp         : offer,
                targetUserId: viewerUserId,
                fromUserId  : LB_CONFIG.userId,
            });
        }
    }

    async function _handleAnswer(viewerUserId, sdp) {
        const pc = s.peers[viewerUserId];
        if (!pc) {
            console.warn('[LB] _handleAnswer: peer yok, userId:', viewerUserId);
            return;
        }
        // Sadece have-local-offer state'inde answer kabul et
        if (pc.signalingState !== 'have-local-offer') {
            console.warn('[LB] _handleAnswer: yanlış state:', pc.signalingState, 'userId:', viewerUserId);
            return;
        }
        try {
            await pc.setRemoteDescription(new RTCSessionDescription({ type: 'answer', sdp: sdp.sdp ?? sdp }));
            console.log('[LB] Answer alındı, izleyici:', viewerUserId);
        } catch (err) {
            console.error('[LB] _handleAnswer hatası:', err);
        }
    }

    async function _handleViewerIce(viewerUserId, candidate) {
        const pc = s.peers[viewerUserId];
        if (!pc) return;
        if (pc.remoteDescription === null) {
            console.warn('[LB] ICE geldi ama remoteDescription henüz yok, userId:', viewerUserId);
            return;
        }
        try { await pc.addIceCandidate(new RTCIceCandidate(candidate)); } catch(e) {
            console.warn('[LB] addIceCandidate hatası:', e);
        }
    }

    /* ════ TEKLİF SEÇ ════ */
    function selectBid(row) {
        if (s.selling) return;
        document.querySelectorAll('#bidList .lb-bid-radio').forEach(r => r.classList.remove('lb-selected'));
        row.querySelector('.lb-bid-radio').classList.add('lb-selected');
        s.selectedBidId  = parseInt(row.dataset.bidId, 10);
        s.selectedName   = row.dataset.name;
        s.selectedAmount = parseInt(row.dataset.amount, 10);
        document.getElementById('selectedLabel').textContent =
            s.selectedName + ' — ' + s.selectedAmount.toLocaleString('tr-TR') + ' ₺';
        _resetSellBtn();
    }

    /* ════ SATIŞ AKIŞI ════ */
    function startSell() {
        if (s.selling || !s.selectedBidId) return;
        s.selling = true;
        const DURATION = 3000; const STEPS = 100; const INTERVAL = DURATION / STEPS;
        let step = 0;
        const btn  = document.getElementById('sellBtn');
        const cbar = document.getElementById('sellCbar');
        btn.className = 'lb-sell-btn lb-sell-confirming';
        btn.disabled  = true;
        btn.onclick   = _cancelSell;
        const _updateLabel = (r) => { document.getElementById('sellBtnText').textContent = 'Satılıyor... İptal için tıkla (' + r + ')'; };
        _updateLabel(3);
        s.sellInterval = setInterval(() => {
            step++;
            cbar.style.width = (step / STEPS * 100) + '%';
            _updateLabel(Math.ceil((DURATION - step * INTERVAL) / 1000));
            if (step >= STEPS) { clearInterval(s.sellInterval); s.sellInterval = null; }
        }, INTERVAL);
        s.sellTimeout = setTimeout(_completeSell, DURATION);
    }

    function _cancelSell() {
        clearInterval(s.sellInterval); s.sellInterval = null;
        clearTimeout(s.sellTimeout);   s.sellTimeout  = null;
        s.selling = false;
        document.getElementById('sellCbar').style.width = '0';
        _resetSellBtn();
    }

    function _resetSellBtn() {
        const btn = document.getElementById('sellBtn');
        btn.className = 'lb-sell-btn';
        btn.disabled  = !s.selectedBidId;
        btn.onclick   = LB.startSell;
        document.getElementById('sellBtnText').textContent = 'Bu Teklife Sat';
        document.getElementById('sellBtnIcon').className   = 'bi bi-check-lg';
    }

    async function _completeSell() {
        s.selling = false;
        const btn  = document.getElementById('sellBtn');
        const cbar = document.getElementById('sellCbar');
        btn.className = 'lb-sell-btn lb-sell-done';
        btn.disabled  = true;
        document.getElementById('sellBtnText').textContent = 'Satış Tamamlandı!';
        document.getElementById('sellBtnIcon').className   = 'bi bi-check-circle';
        cbar.classList.add('lb-cbar-done');
        cbar.style.width = '100%';
        _showToast('Satış Tamamlandı! 🎉', s.selectedName + ' — ' + s.selectedAmount.toLocaleString('tr-TR') + ' ₺');
        // Her durumda UI'ı kilitle
        _lockUiAfterSale();

        try {
            const res = await fetch(LB_CONFIG.sellEndpoint, {
                method  : 'POST',
                headers : { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': LB_CONFIG.csrfToken, 'Accept': 'application/json' },
                body    : JSON.stringify({ bid_id: s.selectedBidId }),
            });
            const data = await res.json().catch(() => ({}));
            console.log('[LB] Satış response:', res.status, data);
            if (!res.ok) {
                _showToast('Sunucu Hatası', data.message ?? 'Satış kaydedilemedi.');
            }
        } catch (err) {
            console.error('[LB] Satış fetch hatası:', err);
            _showToast('Bağlantı Hatası', 'Sunucuya ulaşılamadı.');
        }
    }

    /* ════ SATIŞ SONRASI UI KİLİTLE ════ */
    function _lockUiAfterSale() {
        // Kamerayı kapat
        stopCamera();

        // Kamera butonunu devre dışı bırak
        const camBtn = document.getElementById('camBtn');
        if (camBtn) { camBtn.disabled = true; camBtn.style.opacity = '.4'; camBtn.style.cursor = 'not-allowed'; camBtn.onclick = null; }

        // Sat butonunu tamamen kilitle
        const sellBtn = document.getElementById('sellBtn');
        if (sellBtn) {
            sellBtn.disabled = true;
            sellBtn.onclick  = null;
            sellBtn.className = 'lb-sell-btn lb-sell-done';
            sellBtn.style.opacity = '.45';
            sellBtn.style.cursor  = 'not-allowed';
            document.getElementById('sellBtnText').textContent = 'Satış Tamamlandı';
            document.getElementById('sellBtnIcon').className   = 'bi bi-check-circle';
        }

        // Tüm yayın kontrol butonlarını devre dışı bırak
        document.querySelectorAll('.lb-ctrl-btn').forEach(btn => {
            btn.disabled = true;
            btn.style.opacity = '.4';
            btn.style.cursor  = 'not-allowed';
            btn.onclick = null;
        });

        // Teklif listesindeki tıklamayı devre dışı bırak
        document.querySelectorAll('#bidList .lb-bid-row').forEach(row => {
            row.onclick = null;
            row.style.cursor = 'default';
        });

        // Timer'ı durdur
        if (s.timerInterval) { clearInterval(s.timerInterval); s.timerInterval = null; }
        const timerEl = document.getElementById('auctionTimer');
        if (timerEl) { timerEl.textContent = 'Satıldı'; timerEl.classList.remove('lb-timer-safe'); timerEl.style.color = '#10b981'; }

        // Satıldı banner'ı göster
        const wrap = document.getElementById('videoWrap');
        if (wrap) {
            const banner = document.createElement('div');
            banner.style.cssText = 'position:absolute;inset:0;background:rgba(0,0,0,.7);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:12px;z-index:10;border-radius:14px;';
            banner.innerHTML = `
                <div style="font-size:48px;">🎉</div>
                <div style="font-size:22px;font-weight:800;color:#10b981;">Satış Tamamlandı!</div>
                <div style="font-size:14px;color:rgba(255,255,255,.7);">${_esc(s.selectedName)} — ${s.selectedAmount.toLocaleString('tr-TR')} ₺</div>
                <a href="{{ route('seller.dashboard') }}" style="margin-top:12px;padding:10px 28px;background:#9146ff;color:#fff;border-radius:10px;font-weight:700;text-decoration:none;font-size:13px;">Dashboard'a Dön</a>
            `;
            wrap.appendChild(banner);
        }
    }

    /* ════ TOAST ════ */
    function _showToast(title, sub) {
        document.getElementById('toastTitle').textContent = title;
        document.getElementById('toastSub').textContent   = sub;
        const toast = document.getElementById('soldToast');
        toast.classList.add('lb-toast-show');
        setTimeout(() => toast.classList.remove('lb-toast-show'), 5000);
    }

    /* ════ GERİ SAYIM ════ */
    function _startTimer() {
        const el = document.getElementById('auctionTimer');
        const _tick = () => {
            if (s.remainingSecs > 0) s.remainingSecs--;
            const m   = Math.floor(s.remainingSecs / 60);
            const sec = s.remainingSecs % 60;
            el.textContent = String(m).padStart(2,'0') + ':' + String(sec).padStart(2,'0');
            el.classList.toggle('lb-timer-safe', s.remainingSecs > 120);
            if (s.remainingSecs <= 0) { clearInterval(s.timerInterval); el.textContent = 'Bitti'; el.classList.remove('lb-timer-safe'); }
        };
        if (s.remainingSecs <= 0) { el.textContent = 'Bitti'; return; }
        _tick();
        s.timerInterval = setInterval(_tick, 1000);
    }

    /* ════ TEKLİF SATIRI EKLE ════ */
    function _addBidRow(bidId, name, amount, timeLabel) {
        const list = document.getElementById('bidList');
        document.getElementById('bidListEmpty')?.remove();

        const avClass  = AVATAR_CLASSES[s.avatarIdx % AVATAR_CLASSES.length];
        s.avatarIdx++;
        const parts    = name.trim().split(' ');
        const initials = (parts[0]?.[0] ?? 'X').toUpperCase() + (parts[1]?.[0] ?? 'X').toUpperCase();

        const row = document.createElement('div');
        row.className     = 'lb-bid-row lb-bid-new';
        row.dataset.bidId = bidId;
        row.dataset.amount = amount;
        row.dataset.name   = name;
        row.onclick        = () => LB.selectBid(row);
        row.innerHTML = `
            <div class="lb-bid-radio" id="radio-${bidId}"></div>
            <div class="lb-bid-avatar ${avClass}">${_esc(initials)}</div>
            <div style="flex:1;min-width:0;">
                <div class="lb-bid-name">${_esc(name)}</div>
                <div class="lb-bid-time">${_esc(timeLabel)}</div>
            </div>
            <div class="lb-bid-amount">${parseInt(amount,10).toLocaleString('tr-TR')} ₺</div>
        `;
        list.insertBefore(row, list.firstChild);

        const count = list.querySelectorAll('.lb-bid-row').length;
        document.getElementById('bidCountLabel').textContent  = count + ' teklif';
        document.getElementById('bidCountInline').textContent = count;

        // En üstteki fiyatı güncelle
        document.getElementById('topBidPrice').textContent =
            parseInt(amount, 10).toLocaleString('tr-TR') + ' ₺';

        if (!s.selectedBidId) LB.selectBid(row);
        document.getElementById('sellBtn').disabled = false;
    }

    function _esc(str) {
        return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    /* ════ ECHO / REVERB ════ */
    function _initEcho() {
        if (typeof window.Echo === 'undefined') {
            console.error('[LB] window.Echo bulunamadı! app.js yüklendi mi?');
            return;
        }

        s.presenceChannel = window.Echo.join('auction.' + LB_CONFIG.auctionId);

        s.presenceChannel
            .here((users) => {
                // Tüm üyeleri kaydet
                users.forEach(u => s.memberIds.add(parseInt(u.id, 10)));
                // Satıcının kendisi hariç izleyici sayısı
                const viewers = users.filter(u => parseInt(u.id,10) !== LB_CONFIG.userId).length;
                _setViewers(viewers);
                console.log('[LB] Kanalda', users.length, 'üye:', users.map(u => u.id));
            })
            .joining((user) => {
                const uid = parseInt(user.id, 10);
                s.memberIds.add(uid);
                if (uid === LB_CONFIG.userId) return;
                // Kendi id'si hariç kalanları say
                const viewers = [...s.memberIds].filter(id => id !== LB_CONFIG.userId).length;
                _setViewers(viewers);
                console.log('[LB] Katıldı:', uid, '→ izleyici:', viewers);
                // Kamera açıksa yeni izleyiciye offer gönder
                if (s.cameraOn) {
                    setTimeout(() => _createOfferForViewer(uid), 800);
                }
            })
            .leaving((user) => {
                const uid = parseInt(user.id, 10);
                s.memberIds.delete(uid);
                if (uid === LB_CONFIG.userId) return;
                const viewers = [...s.memberIds].filter(id => id !== LB_CONFIG.userId).length;
                _setViewers(Math.max(0, viewers));
                // Bu izleyicinin peer bağlantısını kapat
                if (s.peers[uid]) { s.peers[uid].close(); delete s.peers[uid]; }
            })
            .listen('.bid.placed', (data) => {
                console.log('[LB] Yeni teklif:', data);
                _addBidRow(data.bid_id, data.bidder_name, data.amount, 'az önce');
            })
            .listenForWhisper('webrtc-signal', async (data) => {
                if (data.targetUserId !== LB_CONFIG.userId) return;
                if (data.type === 'answer') {
                    await _handleAnswer(data.fromUserId, data.sdp);
                } else if (data.type === 'ice-candidate') {
                    await _handleViewerIce(data.fromUserId, data.candidate);
                }
            });

        // Bağlantı hata ayıklama
        window.Echo.connector.pusher?.connection?.bind('error', (err) => {
            console.error('[LB] Echo bağlantı hatası:', err);
        });
    }

    function _setViewers(n) {
        ['viewerCount','viewerCount2'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = n;
        });
    }

    /* ════ YAYINI BİTİR ════ */
    function endBroadcast() {
        if (!confirm('Yayını sonlandırmak istiyor musunuz?')) return;
        stopCamera();
        fetch(LB_CONFIG.endEndpoint, {
            method  : 'POST',
            headers : { 'X-CSRF-TOKEN': LB_CONFIG.csrfToken, 'Accept': 'application/json' },
        }).finally(() => { window.location.href = '{{ route('seller.dashboard') }}'; });
    }

    /* ════ INIT ════ */
    function _init() {
        _startTimer();
        _initEcho();
        if (s.selectedBidId) {
            document.getElementById('sellBtn').disabled = false;
        }
        // Sayfa açılışında ürün zaten satılmış/bitmişse UI'ı kilitle
        if (LB_CONFIG.isSold) {
            _lockUiAfterSale();
        }
    }

    document.addEventListener('DOMContentLoaded', _init);

    return { toggleCamera, flipCamera, toggleMic, toggleScreen, selectBid, startSell, endBroadcast };
})();
</script>
@endpush

@else
<div class="container py-5 text-center">
    <h2>Erişim Engellendi</h2>
    <p class="text-muted">Bu sayfayı görüntüleme yetkiniz yok.</p>
    <a href="{{ route('index') }}" class="btn btn-primary">Ana Sayfaya Dön</a>
</div>
@endif
@else
    <script>location.href = '{{ route('login') }}';</script>
@endauth

@endsection
