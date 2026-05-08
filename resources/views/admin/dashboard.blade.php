@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="admin-fade">

    {{-- TOOLBAR --}}
    <div class="admin-toolbar mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <div class="toolbar-title">Dashboard</div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 mt-1">
                        <li class="breadcrumb-item active">Admin</li>
                    </ol>
                </nav>
            </div>

            <div class="d-flex align-items-center gap-2 px-4 py-2 rounded-pill"
                 style="background:rgba(145,70,255,.12);border:1px solid rgba(145,70,255,.2)">
                <span style="width:8px;height:8px;border-radius:50%;background:var(--primary)"></span>
                <span style="font-size:13px;font-weight:600;color:var(--primary)">
                    Sistem Aktif
                </span>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="row g-4 mb-4">

        <div class="col-6 col-md-3">
            <div class="admin-stat">
                <div class="admin-stat-icon" style="background:rgba(145,70,255,.1)">
                    <i class="bi bi-people fs-3" style="color:var(--primary)"></i>
                </div>
                <div>
                    <div class="admin-stat-num">{{ $stats['users'] ?? 0 }}</div>
                    <div class="admin-stat-lbl">Kullanıcı</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="admin-stat">
                <div class="admin-stat-icon" style="background:rgba(16,185,129,.1)">
                    <i class="bi bi-hammer fs-3" style="color:#10b981"></i>
                </div>
                <div>
                    <div class="admin-stat-num">{{ $stats['auctions'] ?? 0 }}</div>
                    <div class="admin-stat-lbl">Müzayede</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="admin-stat">
                <div class="admin-stat-icon" style="background:rgba(59,130,246,.1)">
                    <i class="bi bi-graph-up fs-3" style="color:#3b82f6"></i>
                </div>
                <div>
                    <div class="admin-stat-num">{{ $stats['bids'] ?? 0 }}</div>
                    <div class="admin-stat-lbl">Teklif</div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="admin-stat">
                <div class="admin-stat-icon" style="background:rgba(251,191,36,.1)">
                    <i class="bi bi-currency-dollar fs-3" style="color:#fbbf24"></i>
                </div>
                <div>
                    <div class="admin-stat-num">{{ $stats['revenue'] ?? 0 }}</div>
                    <div class="admin-stat-lbl">Gelir</div>
                </div>
            </div>
        </div>

    </div>

    {{-- QUICK ACTIONS --}}
    <div class="admin-card mb-4">

        <div class="admin-card-head">
            <div class="admin-card-title">
                Hızlı İşlemler
            </div>
        </div>

       <div class="row g-3">

    <div class="col-12 col-md-4">
        <a href="{{ route('admin.users.index') }}"
           class="admin-card d-flex align-items-center justify-content-between p-4 text-decoration-none">

            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-people fs-2 text-primary"></i>
                <div>
                    <div class="fw-semibold text-white">Kullanıcılar</div>
                    <div class="text-muted fs-8">Tüm kullanıcı yönetimi</div>
                </div>
            </div>

            <i class="bi bi-arrow-right text-muted"></i>

        </a>
    </div>

    <div class="col-12 col-md-4">
        <a href="#"
           class="admin-card d-flex align-items-center justify-content-between p-4 text-decoration-none">

            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-hammer fs-2 text-warning"></i>
                <div>
                    <div class="fw-semibold text-white">Müzayede</div>
                    <div class="text-muted fs-8">İlan & teklif yönetimi</div>
                </div>
            </div>

            <i class="bi bi-arrow-right text-muted"></i>

        </a>
    </div>

    <div class="col-12 col-md-4">
        <a href="#"
           class="admin-card d-flex align-items-center justify-content-between p-4 text-decoration-none">

            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-shield-check fs-2 text-success"></i>
                <div>
                    <div class="fw-semibold text-white">Onaylar</div>
                    <div class="text-muted fs-8">Bekleyen işlemler</div>
                </div>
            </div>

            <i class="bi bi-arrow-right text-muted"></i>

        </a>
    </div>

</div>

    </div>

    {{-- RECENT ACTIVITY --}}
    <div class="admin-card">

        <div class="admin-card-head">
            <div class="admin-card-title">
                Son Aktiviteler
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:12px">

            @forelse($activities ?? [] as $activity)
                <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border)">
                    <div>
                        <div style="font-weight:600;color:var(--text);font-size:14px">
                            {{ $activity->title }}
                        </div>
                        <div style="font-size:12px;color:var(--muted)">
                            {{ $activity->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align:center;color:var(--muted);padding:20px">
                    Aktivite bulunamadı
                </div>
            @endforelse

        </div>

    </div>

</div>

@endsection