@extends('layouts.app')
@section('title', 'Satıcı Paneli')

@section('content')

<div class="pf-root container-fluid px-2 px-md-4 py-4">

    {{-- ── Toolbar ── --}}
    <div class="pf-toolbar mb-3">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <h1 class="pf-toolbar-title mb-1">Satıcı Paneli</h1>
                <div class="pf-text-muted-sm">
                    Merhaba <strong style="color:var(--text)">{{ auth()->user()->name }}</strong>,
                    performansını ve ilanlarını tek yerden yönet
                </div>
            </div>
            <span class="pf-badge pf-badge-success d-inline-flex align-items-center gap-1" style="font-size:var(--fs-xs); padding:6px 14px; border-radius:20px;">
                <span class="pf-pulse-dot"></span> Canlı
            </span>
        </div>
    </div>

    {{-- ── 4 Stat Kartı ── --}}
    <div class="row g-3 mb-3">
        <div class="col-6 col-xl-3">
            <div class="pf-stat-card" style="position:relative;overflow:hidden;">
                <div class="pf-stat-icon-wrapper" style="background:rgba(145,70,255,.12)">
                    <i class="bi bi-box-seam" style="color:var(--primary); font-size:var(--fs-md)"></i>
                </div>
                <div>
                    <div class="pf-stat-number">{{ $stats['auctions'] ?? 0 }}</div>
                    <div class="pf-stat-label">Toplam İlan</div>
                    <div class="pf-text-muted-sm" style="color:#10b981;margin-top:3px">
                        ↑ {{ $stats['auctions_this_month'] ?? 0 }} bu ay
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="pf-stat-card">
                <div class="pf-stat-icon-wrapper" style="background:rgba(16,185,129,.12)">
                    <i class="bi bi-broadcast" style="color:#10b981; font-size:var(--fs-md)"></i>
                </div>
                <div>
                    <div class="pf-stat-number">{{ $stats['active'] ?? 0 }}</div>
                    <div class="pf-stat-label">Aktif İlan</div>
                    <div class="pf-text-muted-sm" style="color:#10b981;margin-top:3px">
                        ↑ {{ $stats['active_this_week'] ?? 0 }} bu hafta
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="pf-stat-card">
                <div class="pf-stat-icon-wrapper" style="background:rgba(251,191,36,.12)">
                    <i class="bi bi-hand-index-thumb" style="color:#fbbf24; font-size:var(--fs-md)"></i>
                </div>
                <div>
                    <div class="pf-stat-number">{{ $stats['bids'] ?? 0 }}</div>
                    <div class="pf-stat-label">Toplam Teklif</div>
                    <div class="pf-text-muted-sm" style="color:#10b981;margin-top:3px">
                        ↑ {{ $stats['bids_today'] ?? 0 }} bugün
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="pf-stat-card">
                <div class="pf-stat-icon-wrapper" style="background:rgba(6,182,212,.12)">
                    <i class="bi bi-cash-coin" style="color:#06b6d4; font-size:var(--fs-md)"></i>
                </div>
                <div>
                    <div class="pf-stat-number">{{ $stats['sales'] ?? 0 }}</div>
                    <div class="pf-stat-label">Satış</div>
                    <div class="pf-text-muted-sm" style="color:#06b6d4;margin-top:3px">
                        {{ $stats['sales_this_month'] ?? 0 }} bu ay
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Mini İstatistikler ── --}}
    <div class="row g-3 mb-3">
        <div class="col-4">
            <div class="pf-stat-card flex-column text-center gap-1" style="padding:14px 8px;">
                <div class="pf-stat-number" style="font-size:var(--fs-xl); color:#10b981">
                    {{ $stats['completion_rate'] ?? 84 }}%
                </div>
                <div class="pf-stat-label">Tamamlanma</div>
                <div class="pf-text-muted-sm" style="color:#10b981">↑ %3 geçen ay</div>
            </div>
        </div>
        <div class="col-4">
            <div class="pf-stat-card flex-column text-center gap-1" style="padding:14px 8px;">
                <div class="pf-stat-number" style="font-size:var(--fs-xl)">
                    {{ $stats['seller_rating'] ?? '4.8' }} ★
                </div>
                <div class="pf-stat-label">Satıcı Puanı</div>
                <div class="pf-text-muted-sm">{{ $stats['review_count'] ?? 72 }} değerlendirme</div>
            </div>
        </div>
        <div class="col-4">
            <div class="pf-stat-card flex-column text-center gap-1" style="padding:14px 8px;">
                <div class="pf-stat-number" style="font-size:var(--fs-xl); color:var(--primary)">
                    ₺{{ number_format($stats['avg_price'] ?? 1240, 0, ',', '.') }}
                </div>
                <div class="pf-stat-label">Ort. Satış</div>
                <div class="pf-text-muted-sm" style="color:#10b981">↑ ₺80 geçen ay</div>
            </div>
        </div>
    </div>

    {{-- ── Grafik + Cüzdan ── --}}
    <div class="row g-3 mb-3">
        <div class="col-12 col-lg-8">
            <div class="admin-card h-100">
                <div class="admin-card-head">
                    <div class="admin-card-title">
                        <i class="bi bi-graph-up-arrow" style="color:var(--primary)"></i>
                        Satış Performansı
                    </div>
                    <span class="pf-text-muted-sm">Son 30 gün</span>
                </div>
                <div style="padding:16px 20px;">
                    <div style="position:relative; width:100%; height:200px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="admin-card h-100 d-flex flex-column">
                <div class="admin-card-head">
                    <div class="admin-card-title">
                        <i class="bi bi-wallet2" style="color:var(--primary)"></i>
                        Cüzdan
                    </div>
                </div>
                <div style="padding:18px 20px; flex:1; display:flex; flex-direction:column; justify-content:space-between;">
                    <div>
                        <div style="font-size:var(--fs-2xl); font-weight:800; color:var(--primary); line-height:1; margin-bottom:4px;">
                            {{ number_format($walletBalance, 2, ',', '.') }} ₺
                        </div>
                        <div class="pf-text-muted-sm mb-3">Kullanılabilir bakiye</div>
                        <div style="height:5px; border-radius:10px; background:var(--border); margin-bottom:18px; overflow:hidden;">
                            @php $pct = $walletBalance > 0 ? min(100, round(($walletBalance / 10000) * 100)) : 3; @endphp
                            <div style="height:100%; border-radius:10px; background:var(--primary); width:{{ $pct }}%;"></div>
                        </div>

                        {{-- Cüzdan mini istatistikleri --}}
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="s-info-item text-center">
                                    <div class="s-info-lbl" style="font-size:var(--fs-xs)">Bu ay kazanılan</div>
                                    <div class="s-info-val" style="font-size:var(--fs-sm); color:#10b981">
                                        ₺{{ number_format($stats['earned_this_month'] ?? 3200, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="s-info-item text-center">
                                    <div class="s-info-lbl" style="font-size:var(--fs-xs)">Bekleyen</div>
                                    <div class="s-info-val" style="font-size:var(--fs-sm); color:#fbbf24">
                                        ₺{{ number_format($stats['pending_balance'] ?? 850, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-7">
                            <a href="#" class="pf-btn-save w-100 d-flex align-items-center justify-content-center gap-1" style="padding:10px 0;">
                                <i class="bi bi-arrow-down-circle"></i> Para Çek
                            </a>
                        </div>
                        <div class="col-5">
                            <a href="#" class="pf-btn-secondary w-100 d-flex align-items-center justify-content-center gap-1" style="padding:10px 0; text-decoration:none; font-size:var(--fs-sm);">
                                <i class="bi bi-clock-history"></i> Geçmiş
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── En Çok Teklif Alan + Aktivite ── --}}
    <div class="row g-3 mb-3">

        {{-- En çok teklif --}}
        <div class="col-12 col-lg-6">
            <div class="admin-card h-100">
                <div class="admin-card-head">
                    <div class="admin-card-title">
                        <i class="bi bi-trophy" style="color:#fbbf24"></i>
                        En Çok Teklif Alan İlanlar
                    </div>
                    <a href="{{ route('seller.auctions.index') }}" class="pf-link-primary" style="font-size:var(--fs-xs); text-decoration:none;">Tümü →</a>
                </div>
                <div style="padding:6px 20px 16px;">
                    @php
                        $topAuctions = $topBidAuctions ?? collect([
                            ['title'=>'Vintage Kol Saati', 'bids'=>47, 'max'=>47],
                            ['title'=>'Deri Ceket (L)',     'bids'=>34, 'max'=>47],
                            ['title'=>'iPhone 14 Pro',      'bids'=>27, 'max'=>47],
                            ['title'=>'Antika Vazo Seti',   'bids'=>19, 'max'=>47],
                            ['title'=>'DeLonghi Kahve Mak.','bids'=>11, 'max'=>47],
                        ]);
                    @endphp
                    @foreach($topAuctions as $i => $item)
                    @php
                        $bidCount = is_array($item) ? $item['bids'] : $item->bids_count;
                        $maxBid   = is_array($topAuctions->first()) ? $topAuctions->first()['bids'] : $topAuctions->first()->bids_count;
                        $title    = is_array($item) ? $item['title'] : $item->title;
                        $pct      = $maxBid > 0 ? round(($bidCount / $maxBid) * 100) : 0;
                    @endphp
                    <div class="d-flex align-items-center gap-3 py-2" style="border-bottom:1px solid var(--border)">
                        <span class="pf-text-muted-sm" style="width:18px; text-align:center; font-weight:700;">{{ $i+1 }}</span>
                        <div style="flex:1; min-width:0;">
                            <div style="font-size:var(--fs-sm); font-weight:600; color:var(--text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ Str::limit($title, 32) }}
                            </div>
                            <div style="height:3px; border-radius:4px; background:var(--border); margin-top:5px; overflow:hidden;">
                                <div style="height:100%; border-radius:4px; background:var(--primary); width:{{ $pct }}%;"></div>
                            </div>
                        </div>
                        <span class="pf-badge pf-badge-success">{{ $bidCount }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Son Aktivite --}}
        <div class="col-12 col-lg-6">
            <div class="admin-card h-100">
                <div class="admin-card-head">
                    <div class="admin-card-title">
                        <i class="bi bi-activity" style="color:var(--primary)"></i>
                        Son Aktivite
                    </div>
                </div>
                <div style="padding:4px 20px 16px;">
                    @php
                        $activities = $recentActivities ?? collect([
                            ['type'=>'bid',   'color'=>'#10b981', 'text'=>'Yeni teklif: <strong>Vintage Kol Saati</strong> — ₺2.450',  'time'=>'2 dakika önce'],
                            ['type'=>'sale',  'color'=>'var(--primary)', 'text'=>'Satış tamamlandı: <strong>Deri Ceket (L)</strong>',  'time'=>'1 saat önce'],
                            ['type'=>'ended', 'color'=>'#fbbf24', 'text'=>'İlan sona erdi: <strong>Kahve Makinesi</strong>',           'time'=>'3 saat önce'],
                            ['type'=>'review','color'=>'#10b981', 'text'=>'Yeni yorum: <strong>5 yıldız</strong> — Çok hızlı kargo',   'time'=>'5 saat önce'],
                            ['type'=>'return','color'=>'#f87171', 'text'=>'İade talebi: <strong>Antika Vazo Seti</strong>',            'time'=>'Dün 18:30'],
                        ]);
                    @endphp
                    @foreach($activities as $act)
                    @php
                        $actColor = is_array($act) ? $act['color'] : '#10b981';
                        $actText  = is_array($act) ? $act['text']  : $act->text;
                        $actTime  = is_array($act) ? $act['time']  : $act->created_at->diffForHumans();
                    @endphp
                    <div class="d-flex align-items-start gap-3 py-2" style="border-bottom:1px solid var(--border)">
                        <div style="width:8px;height:8px;border-radius:50%;background:{{ $actColor }};flex-shrink:0;margin-top:5px;"></div>
                        <div style="flex:1;">
                            <div style="font-size:var(--fs-sm); color:var(--text); line-height:1.5;">{!! $actText !!}</div>
                            <div class="pf-text-muted-sm" style="margin-top:2px;">{{ $actTime }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ── Son İlanlar + Hızlı İşlemler ── --}}
    <div class="row g-3">
        <div class="col-12 col-lg-8">
            <div class="admin-card h-100">
                <div class="admin-card-head">
                    <div class="admin-card-title">
                        <i class="bi bi-box-seam" style="color:var(--primary)"></i>
                        Son İlanlar
                    </div>
                    <a href="{{ route('seller.auctions.index') }}" class="pf-link-primary" style="font-size:var(--fs-xs); text-decoration:none;">
                        Tümünü Gör →
                    </a>
                </div>

                @php
                    $sMap = [
                        'active'    => 'pf-badge-success',
                        'draft'     => 'pf-badge-warning',
                        'ended'     => 'pf-badge-dark',
                        'sold'      => 'pf-badge-cyan',
                        'cancelled' => 'pf-badge-danger',
                        'rejected'  => 'pf-badge-danger',
                    ];
                    $sLbl = [
                        'active'    => 'Aktif',
                        'draft'     => 'Taslak',
                        'ended'     => 'Bitti',
                        'sold'      => 'Satıldı',
                        'cancelled' => 'İptal',
                        'rejected'  => 'Reddedildi',
                    ];
                @endphp

                @if($latestAuctions->isEmpty())
                    <div class="pf-empty">
                        <div class="pf-empty-icon"><i class="bi bi-box-seam"></i></div>
                        <div class="pf-empty-title">Henüz ilan yok</div>
                        <div class="pf-empty-sub">İlk ilanını oluşturmak için "Yeni İlan Oluştur" butonunu kullan.</div>
                    </div>
                @else
                    {{-- Masaüstü tablo --}}
                    <div class="d-none d-md-block">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>İlan</th>
                                    <th class="text-end">Fiyat</th>
                                    <th class="text-center">Durum</th>
                                    <th class="text-center">Teklif</th>
                                    <th class="text-center">Süre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestAuctions as $auction)
                                <tr>
                                    <td>
                                        <div class="pf-cat-info">
                                            <img src="{{ $auction->coverUrl() }}"
                                                 class="pf-cat-img"
                                                 alt="{{ $auction->title }}">
                                            <div>
                                                <div class="pf-cat-name">{{ Str::limit($auction->title, 38) }}</div>
                                                <div class="pf-cat-slug">{{ $auction->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end" style="font-weight:700; color:var(--text);">
                                        {{ $auction->displayPrice() }}
                                    </td>
                                    <td class="text-center">
                                        <span class="pf-badge {{ $sMap[$auction->status] ?? 'pf-badge-dark' }}">
                                            {{ $sLbl[$auction->status] ?? ucfirst($auction->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center" style="font-weight:600; color:var(--text);">
                                        {{ $auction->bidCount() }}
                                    </td>
                                    <td class="text-center pf-text-muted-sm">
                                        @if($auction->status === 'active' && $auction->ends_at)
                                            {{ $auction->ends_at->diffForHumans() }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobil liste --}}
                    <div class="d-flex flex-column gap-2 d-md-none p-3">
                        @foreach($latestAuctions as $auction)
                        <div class="d-flex align-items-center gap-3 p-2"
                             style="border:1px solid var(--border); border-radius:12px; background:var(--bg-soft);">
                            <img src="{{ $auction->coverUrl() }}"
                                 style="width:44px;height:44px;border-radius:10px;object-fit:cover;flex-shrink:0;border:1px solid var(--border);"
                                 alt="{{ $auction->title }}">
                            <div style="flex:1;min-width:0;">
                                <div class="pf-cat-name">{{ Str::limit($auction->title, 26) }}</div>
                                <div style="font-size:var(--fs-sm); font-weight:700; color:var(--primary);">{{ $auction->displayPrice() }}</div>
                            </div>
                            <span class="pf-badge {{ $sMap[$auction->status] ?? 'pf-badge-dark' }}" style="flex-shrink:0;">
                                {{ $sLbl[$auction->status] ?? ucfirst($auction->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Hızlı İşlemler --}}
        <div class="col-12 col-lg-4">
            <div class="admin-card h-100">
                <div class="admin-card-head">
                    <div class="admin-card-title">
                        <i class="bi bi-lightning-charge" style="color:#fbbf24"></i>
                        Hızlı İşlemler
                    </div>
                </div>
                <div style="padding:16px 20px; display:flex; flex-direction:column; gap:10px;">
                    <a href="{{ route('seller.auctions.create') }}"
                       class="pf-btn-save w-100 d-flex align-items-center justify-content-center gap-2"
                       style="padding:12px;">
                        <i class="bi bi-plus-lg"></i> Yeni İlan Oluştur
                    </a>

                    <div class="s-action-grid" style="grid-template-columns:1fr 1fr;">
                        <a href="{{ route('seller.auctions.index') }}" class="s-action-btn text-decoration-none">
                            <i class="bi bi-list-ul" style="color:var(--primary); font-size:var(--fs-md)"></i>
                            <div class="s-info-lbl mt-1" style="font-size:10px;">İlanlar</div>
                        </a>
                        <a href="{{ route('seller.profile.edit') }}" class="s-action-btn text-decoration-none">
                            <i class="bi bi-person" style="color:var(--primary); font-size:var(--fs-md)"></i>
                            <div class="s-info-lbl mt-1" style="font-size:10px;">Profil</div>
                        </a>
                        <a href="#" class="s-action-btn text-decoration-none">
                            <i class="bi bi-graph-up" style="color:#10b981; font-size:var(--fs-md)"></i>
                            <div class="s-info-lbl mt-1" style="font-size:10px;">Raporlar</div>
                        </a>
                        <a href="#" class="s-action-btn text-decoration-none">
                            <i class="bi bi-chat-dots" style="color:#06b6d4; font-size:var(--fs-md)"></i>
                            <div class="s-info-lbl mt-1" style="font-size:10px;">Mesajlar</div>
                        </a>
                        <a href="#" class="s-action-btn text-decoration-none">
                            <i class="bi bi-gear" style="color:var(--muted); font-size:var(--fs-md)"></i>
                            <div class="s-info-lbl mt-1" style="font-size:10px;">Ayarlar</div>
                        </a>
                        <a href="#" class="s-action-btn text-decoration-none">
                            <i class="bi bi-question-circle" style="color:var(--muted); font-size:var(--fs-md)"></i>
                            <div class="s-info-lbl mt-1" style="font-size:10px;">Yardım</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const raw    = {!! json_encode($chartData ?? []) !!};
    const labels = {!! json_encode($chartLabels ?? []) !!};
    const hasData = Array.isArray(raw) && raw.some(v => v > 0);

    /* Geçici demo verisi — controller'dan gerçek veri gelince kaldır */
    const demoData   = [320,480,210,760,540,890,430,1100,670,940,1250,820,1490,760,1830,1640,
                        900,1120,680,1380,970,1540,820,1700,1100,1430,890,1960,1280,2100];
    const demoLabels = Array.from({length:30}, (_,i) => (i+1)+'.');

    const finalData   = hasData ? raw   : demoData;
    const finalLabels = labels.length   ? labels : demoLabels;

    const ctx = document.getElementById('salesChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: finalLabels,
            datasets: [{
                label: 'Satış (₺)',
                data: finalData,
                backgroundColor: 'rgba(145,70,255,.2)',
                hoverBackgroundColor: 'rgba(145,70,255,.65)',
                borderRadius: 5,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    padding: 10,
                    callbacks: {
                        label: ctx => ' ' + ctx.parsed.y.toLocaleString('tr-TR') + ' ₺'
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 10 },
                        color: '#94a3b8',
                        maxRotation: 0,
                        autoSkip: true,
                        maxTicksLimit: 10
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255,255,255,.05)' },
                    ticks: {
                        font: { size: 10 },
                        color: '#94a3b8',
                        callback: v => v >= 1000 ? (v/1000).toFixed(1)+'K' : v
                    }
                }
            }
        }
    });

});
</script>
@endpush
