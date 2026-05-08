@extends('layouts.app')
@section('title', $user->name . ' — Detay')
@section('content')
<div class="admin-fade">

<div class="admin-toolbar">
    <div class="d-flex align-items-center justify-content-between position-relative">
        <div>
            <div class="toolbar-title">Kullanıcı Detayı</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Kullanıcılar</a></li>
                    <li class="breadcrumb-item active">{{ $user->name }}</li>
                </ol>
            </nav>
        </div>
        <div style="display:flex;gap:8px">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn-admin-pri">
                <i class="ki-duotone ki-pencil fs-5"><span class="path1"></span><span class="path2"></span></i>
                Düzenle
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn-admin-sec">
                <i class="ki-duotone ki-left fs-5"><span class="path1"></span><span class="path2"></span></i>
                Geri
            </a>
        </div>
    </div>
</div>

<div class="row g-5">

<div class="col-xl-4">
    <div class="admin-card mb-4">

        <div class="admin-hero">
            <div style="position:relative;z-index:1">
                <div class="avatar-ring" style="width:88px;height:88px;margin:0 auto 12px">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}">
                    @else
                        <div style="width:100%;height:100%;border-radius:50%;background:#1a2e45;display:flex;align-items:center;justify-content:center;font-size:26px;font-weight:800;color:#818cf8">
                            {{ strtoupper(substr($user->name,0,1)) }}
                        </div>
                    @endif
                </div>
                <div style="font-size:17px;font-weight:700;color:#fff;margin-bottom:4px">{{ $user->name }}</div>
                <div style="font-size:13px;color:rgba(255,255,255,.5);margin-bottom:10px">{{ $user->email }}</div>
                @foreach($user->roles as $role)
                    <span class="a-badge {{ $role->name }}" style="font-size:12px;padding:5px 14px">
                        {{ ucfirst($role->name) }}
                    </span>
                @endforeach
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:var(--border)">
            @foreach([['num'=>$user->auctions_count,'lbl'=>'İlan'],['num'=>$user->bids_count,'lbl'=>'Teklif'],['num'=>$user->watchlist_count,'lbl'=>'Takip']] as $s)
            <div style="background:var(--bg-soft);padding:14px 8px;text-align:center">
                <div style="font-size:20px;font-weight:800;color:var(--text)">{{ $s['num'] }}</div>
                <div style="font-size:10px;font-weight:700;letter-spacing:.7px;text-transform:uppercase;color:var(--muted);margin-top:3px">{{ $s['lbl'] }}</div>
            </div>
            @endforeach
        </div>

        <div style="padding:18px 20px">
            @foreach([
                ['icon'=>'ki-phone',        'lbl'=>'Telefon',   'val'=>$user->phone ?? '—'],
                ['icon'=>'ki-sms',          'lbl'=>'E-posta',   'val'=>$user->email],
                ['icon'=>'ki-calendar',     'lbl'=>'Üyelik',    'val'=>$user->created_at->format('d M Y')],
            ] as $row)
            <div class="admin-info-row">
                <div class="admin-info-icon">
                    <i class="ki-duotone {{ $row['icon'] }} fs-5"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <div>
                    <div class="admin-info-lbl">{{ $row['lbl'] }}</div>
                    <div class="admin-info-val">{{ $row['val'] }}</div>
                </div>
            </div>
            @endforeach
            <div class="admin-info-row">
                <div class="admin-info-icon">
                    <i class="ki-duotone ki-shield-tick fs-5"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <div>
                    <div class="admin-info-lbl">Doğrulama</div>
                    @if($user->is_verified)
                        <span class="a-badge success" style="margin-top:4px;display:inline-flex">✓ Doğrulanmış</span>
                    @else
                        <span class="a-badge warning" style="margin-top:4px;display:inline-flex">Beklemede</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="admin-card mb-5">
        <div class="admin-card-head">
            <div class="admin-card-title">
                <i class="ki-duotone ki-setting-2 fs-4" style="color:var(--primary)">
                    <span class="path1"></span><span class="path2"></span>
                </i>
                Hızlı İşlemler
            </div>
        </div>
        <div style="padding:16px 18px;display:flex;flex-direction:column;gap:8px">
            @if($user->is_verified)
            <form method="POST" action="{{ route('admin.users.unverify', $user) }}" class="verify-form">
                @csrf
                <button type="submit" class="btn-admin-danger" style="width:100%;justify-content:center"
                        data-name="{{ $user->name }}" data-action="unverify">
                    <i class="ki-duotone ki-shield-cross fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    Doğrulamayı Kaldır
                </button>
            </form>
            @else
            <form method="POST" action="{{ route('admin.users.verify', $user) }}" class="verify-form">
                @csrf
                <button type="submit" class="btn-admin-success" style="width:100%;justify-content:center"
                        data-name="{{ $user->name }}" data-action="verify">
                    <i class="ki-duotone ki-shield-tick fs-5"><span class="path1"></span><span class="path2"></span></i>
                    Hesabı Doğrula
                </button>
            </form>
            @endif

            <a href="{{ route('admin.users.edit', $user) }}" class="btn-admin-pri" style="justify-content:center">
                <i class="ki-duotone ki-pencil fs-5"><span class="path1"></span><span class="path2"></span></i>
                Kullanıcıyı Düzenle
            </a>

            @if($user->id !== auth()->id())
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="delete-form">
                @csrf @method('DELETE')
                <button type="button" class="btn-admin-danger delete-btn" style="width:100%;justify-content:center"
                        data-name="{{ $user->name }}">
                    <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                    Kullanıcıyı Sil
                </button>
            </form>
            @endif
        </div>
    </div>
</div>

<div class="col-xl-8">

    <div class="admin-card mb-4">
        <div class="admin-card-head">
            <div class="admin-card-title">
                <i class="ki-duotone ki-price-tag fs-4" style="color:#10b981">
                    <span class="path1"></span><span class="path2"></span>
                </i>
                Son İlanlar
                <span class="a-badge info">{{ $user->auctions_count }} toplam</span>
            </div>
        </div>
        <table class="admin-table">
            <thead>
                <tr><th>İlan</th><th>Fiyat</th><th>Durum</th><th>Tarih</th></tr>
            </thead>
            <tbody>
                @forelse($user->auctions as $auction)
                <tr>
                    <td style="font-weight:500;font-size:13px">{{ Str::limit($auction->title,45) }}</td>
                    <td style="font-weight:700;color:#10b981">{{ number_format($auction->current_price,2) }} ₺</td>
                    <td>
                        <span class="a-badge {{ match($auction->status){'active'=>'success','draft'=>'warning','ended'=>'info','cancelled'=>'danger',default=>'info'} }}">
                            {{ match($auction->status){'active'=>'Aktif','draft'=>'Taslak','ended'=>'Bitti','cancelled'=>'İptal',default=>$auction->status} }}
                        </span>
                    </td>
                    <td style="color:var(--muted);font-size:12px">{{ $auction->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;padding:28px;color:var(--muted)">İlan yok</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="admin-card">
        <div class="admin-card-head">
            <div class="admin-card-title">
                <i class="ki-duotone ki-graph-up fs-4" style="color:var(--primary)">
                    <span class="path1"></span><span class="path2"></span>
                </i>
                Son Teklifler
                <span class="a-badge info">{{ $user->bids_count }} toplam</span>
            </div>
        </div>
        <table class="admin-table">
            <thead>
                <tr><th>Müzayede</th><th>Tutar</th><th>Tarih</th></tr>
            </thead>
            <tbody>
                @forelse($user->bids as $bid)
                <tr>
                    <td style="font-size:13px">{{ Str::limit($bid->auction->title ?? '—',50) }}</td>
                    <td style="font-weight:700;color:#10b981">{{ number_format($bid->amount,2) }} ₺</td>
                    <td style="color:var(--muted);font-size:12px">{{ $bid->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;padding:28px;color:var(--muted)">Teklif yok</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const name = this.dataset.name;
        const form = this.closest('form');
        Swal.fire({
            title: 'Emin misin?',
            html: `<strong>${name}</strong> kalıcı olarak silinecek.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Evet, sil',
            cancelButtonText: 'Vazgeç',
            reverseButtons: true,
        }).then(r => { if (r.isConfirmed) form.submit(); });
    });
});

document.querySelectorAll('.verify-form button').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('form');
        const isVerify = this.dataset.action === 'verify';
        Swal.fire({
            title: isVerify ? 'Hesabı doğrula?' : 'Doğrulamayı kaldır?',
            icon: isVerify ? 'success' : 'warning',
            showCancelButton: true,
            confirmButtonText: isVerify ? 'Doğrula' : 'Kaldır',
            cancelButtonText: 'Vazgeç',
            reverseButtons: true,
        }).then(r => { if (r.isConfirmed) form.submit(); });
    });
});
</script>
@endpush