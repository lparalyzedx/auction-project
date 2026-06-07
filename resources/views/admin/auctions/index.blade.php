@extends('layouts.app')
@section('title', 'İlan Yönetimi')
@section('content')

<div class="container-fluid py-4 px-4">

    {{-- Toolbar --}}
    <div class="admin-toolbar mb-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <div class="toolbar-title">İlan Yönetimi</div>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}" class="pf-breadcrumb-link">Admin</a>
                        </li>
                        <li class="breadcrumb-item active">İlanlar</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="pf-alert-success mb-3">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Stat Kartları --}}
    <div class="row g-3 mb-4">
        @foreach([
            ['Toplam',     $counts['all'],      'bi-box-seam',  '#7c3aed', 'rgba(124,58,237,.1)', null],
            ['Bekleyen',   $counts['draft'],    'bi-hourglass', '#f59e0b', 'rgba(245,158,11,.1)', 'draft'],
            ['Aktif',      $counts['active'],   'bi-broadcast', '#10b981', 'rgba(16,185,129,.1)', 'active'],
            ['Reddedilen', $counts['rejected'], 'bi-x-circle',  '#ef4444', 'rgba(239,68,68,.1)',  'rejected'],
            ['Biten',      $counts['ended'],    'bi-flag',      '#6b7280', 'rgba(107,114,128,.1)','ended'],
        ] as [$lbl, $num, $icon, $color, $bg, $filter])
        <div class="col-6 col-md">
            <a href="{{ $filter ? route('admin.auctions.index', ['status' => $filter]) : route('admin.auctions.index') }}"
               class="pf-stat-card text-decoration-none d-flex {{ request('status') === $filter ? 'ring-active' : '' }}"
               style="{{ request('status') === $filter ? 'border:1.5px solid '.$color.';' : '' }}">
                <div class="pf-stat-icon-wrapper" style="background:{{ $bg }}">
                    <i class="bi {{ $icon }}" style="color:{{ $color }}"></i>
                </div>
                <div>
                    <div class="pf-stat-number">{{ number_format($num) }}</div>
                    <div class="pf-stat-label">{{ $lbl }}</div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    {{-- Arama Filtresi --}}
    <div class="admin-card mb-3 p-3">
        <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}"
                   class="pf-input" style="max-width:280px;" placeholder="İlan başlığı ara...">
            <button class="pf-btn-save" type="submit">
                <i class="bi bi-search me-1"></i> Ara
            </button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.auctions.index') }}" class="pf-btn-reset">
                    <i class="bi bi-x me-1"></i> Temizle
                </a>
            @endif
        </form>
    </div>

    {{-- Tablo --}}
    <div class="admin-card">
        @if($auctions->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-40"></i>
                Gösterilecek ilan yok.
            </div>
        @else
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>İlan</th>
                        <th>Satıcı</th>
                        <th class="text-center">Başlangıç Fiyatı</th>
                        <th class="text-center">Durum</th>
                        <th class="text-center">Tarih</th>
                        <th class="text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($auctions as $auction)
                        @php
                            $statusMap = [
                                'draft'     => ['Bekliyor',   'warning'],
                                'active'    => ['Aktif',      'success'],
                                'rejected'  => ['Reddedildi', 'danger'],
                                'ended'     => ['Bitti',      'info'],
                                'sold'      => ['Satıldı',    'seller'],
                                'cancelled' => ['İptal',      'warning'],
                            ];
                            [$slabel, $stype] = $statusMap[$auction->status] ?? ['—', 'info'];
                        @endphp
                        <tr>
                            {{-- İlan --}}
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $auction->coverUrl() }}"
                                         style="width:44px;height:44px;border-radius:10px;object-fit:cover;flex-shrink:0;">
                                    <div>
                                        <div style="font-weight:600;font-size:13px;">
                                            {{ Str::limit($auction->title, 45) }}
                                        </div>
                                        <div style="font-size:11px;opacity:.5;">
                                            {{ $auction->category?->name ?? '—' }}
                                            @if($auction->location)
                                                · {{ $auction->location }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Satıcı --}}
                            <td>
                                <div style="font-size:13px;font-weight:500;">{{ $auction->user->name }}</div>
                                <div style="font-size:11px;opacity:.5;">{{ $auction->user->email }}</div>
                            </td>

                            {{-- Fiyat --}}
                            <td class="text-center fw-semibold">
                                {{ number_format($auction->starting_price, 0, ',', '.') }} ₺
                            </td>

                            {{-- Durum --}}
                            <td class="text-center">
                                <span class="a-badge {{ $stype }}">{{ $slabel }}</span>
                            </td>

                            {{-- Tarih --}}
                            <td class="text-center pf-text-muted-sm">
                                {{ $auction->created_at->format('d.m.Y') }}
                            </td>

                            {{-- İşlemler --}}
                            <td>
                                <div class="d-flex gap-1 justify-content-end align-items-center">

                                    {{-- İncele --}}
                                    <a href="{{ route('admin.auctions.show', $auction) }}"
                                       class="pf-btn-icon" title="İncele">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- Düzenle --}}
                                    <a href="{{ route('admin.auctions.edit', $auction) }}"
                                       class="pf-btn-icon" title="Düzenle">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    {{-- Onayla (sadece draft) --}}
                                    @if($auction->status === 'draft')
                                        <form method="POST" action="{{ route('admin.auctions.approve', $auction) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success px-2" title="Onayla">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>

                                        {{-- Reddet (sadece draft) --}}
                                        <button type="button"
                                                class="btn btn-sm btn-danger px-2 js-reject-btn"
                                                data-id="{{ $auction->id }}"
                                                data-title="{{ $auction->title }}"
                                                title="Reddet">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    @endif

                                    {{-- Sil --}}
                                    <form method="POST"
                                          action="{{ route('admin.auctions.destroy', $auction) }}"
                                          class="js-delete-form m-0">
                                        @csrf @method('DELETE')
                                        <button type="button"
                                                class="pf-action-btn-delete js-delete-btn"
                                                data-title="{{ $auction->title }}"
                                                title="Sil">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Sayfalama --}}
        @if($auctions->hasPages())
            <div class="pf-pagination-wrapper">
                <span class="pf-pagination-info">
                    <strong>{{ $auctions->firstItem() }}–{{ $auctions->lastItem() }}</strong>
                    / {{ $auctions->total() }} ilan
                </span>
                <div class="d-flex gap-1">
                    @if(!$auctions->onFirstPage())
                        <a href="{{ $auctions->previousPageUrl() }}" class="pf-btn-icon">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    @endif
                    @foreach($auctions->getUrlRange(
                        max(1, $auctions->currentPage() - 2),
                        min($auctions->lastPage(), $auctions->currentPage() + 2)
                    ) as $page => $url)
                        <a href="{{ $url }}"
                           class="pf-pagination-item {{ $page === $auctions->currentPage() ? 'active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach
                    @if($auctions->hasMorePages())
                        <a href="{{ $auctions->nextPageUrl() }}" class="pf-btn-icon">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @endif
                </div>
            </div>
        @endif
        @endif
    </div>
</div>

{{-- Reddet Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content"
             style="border-radius:16px;border:1px solid var(--search-border);background:var(--search-bg);">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">İlanı Reddet</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted mb-3" id="rejectModalDesc" style="font-size:13px;"></p>
                    <label class="pf-label">
                        Gerekçe
                        <span class="pf-hint ms-1">(isteğe bağlı, kullanıcıya iletilir)</span>
                    </label>
                    <textarea name="reason" class="pf-input mt-1" rows="3"
                              placeholder="Örn: Görsel kalitesi yetersiz, açıklama eksik..."></textarea>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="pf-btn-reset" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="btn btn-danger btn-sm px-4">Reddet</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Reddet modal
document.querySelectorAll('.js-reject-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('rejectModalDesc').textContent =
            `"${this.dataset.title}" ilanı reddedilecek ve satıcıya bildirim gönderilecek.`;
        document.getElementById('rejectForm').action =
            `/admin/auctions/${this.dataset.id}/reject`;
        new bootstrap.Modal(document.getElementById('rejectModal')).show();
    });
});

// Sil onayı
document.querySelectorAll('.js-delete-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const form = this.closest('.js-delete-form');
        Swal.fire({
            title: 'İlan silinsin mi?',
            html: `<strong>${this.dataset.title}</strong> kalıcı olarak kaldırılacak.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Evet, sil',
            cancelButtonText: 'Vazgeç',
            reverseButtons: true,
        }).then(r => { if (r.isConfirmed) form.submit(); });
    });
});
</script>
@endpush
@endsection
