@extends('layouts.app')
@section('title', 'Kullanıcı Yönetimi')
@section('content')

<div class="admin-fade">
<div class="admin-toolbar">
    <div class="d-flex align-items-center justify-content-between position-relative">
        <div>
            <div class="toolbar-title">Kullanıcı Yönetimi</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item active">Kullanıcılar</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center gap-2 px-4 py-2 rounded-pill"
             style="background:rgba(145,70,255,.12);border:1px solid rgba(145,70,255,.2)">
            <span style="width:8px;height:8px;border-radius:50%;background:var(--primary);display:inline-block"></span>
            <span style="font-size:13px;font-weight:600;color:var(--primary)">{{ number_format($stats['total']) }} Üye</span>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    @foreach([
        ['lbl'=>'Toplam Üye',  'num'=>$stats['total'],    'icon'=>'ki-people',       'color'=>'var(--primary)',  'bg'=>'rgba(145,70,255,.1)'],
        ['lbl'=>'Doğrulanmış', 'num'=>$stats['verified'], 'icon'=>'ki-shield-tick',  'color'=>'#10b981', 'bg'=>'rgba(16,185,129,.1)'],
        ['lbl'=>'Beklemede',   'num'=>$stats['pending'],  'icon'=>'ki-time',         'color'=>'#fbbf24', 'bg'=>'rgba(251,191,36,.1)'],
        ['lbl'=>'Satıcı',      'num'=>$stats['sellers'],  'icon'=>'ki-shop',         'color'=>'#06b6d4', 'bg'=>'rgba(6,182,212,.1)'],
        ['lbl'=>'Alıcı',       'num'=>$stats['buyers'],   'icon'=>'ki-profile-user', 'color'=>'var(--primary)',  'bg'=>'rgba(145,70,255,.08)'],
        ['lbl'=>'Admin',       'num'=>$stats['admins'],   'icon'=>'ki-crown',        'color'=>'#f87171', 'bg'=>'rgba(248,113,113,.1)'],
    ] as $s)
    <div class="col-6 col-md-4 col-xl-2">
        <div class="admin-stat">
            <div class="admin-stat-icon" style="background:{{ $s['bg'] }}">
                <i class="ki-duotone {{ $s['icon'] }} fs-2x" style="color:{{ $s['color'] }}">
                    <span class="path1"></span><span class="path2"></span>
                </i>
            </div>
            <div>
                <div class="admin-stat-num">{{ number_format($s['num']) }}</div>
                <div class="admin-stat-lbl">{{ $s['lbl'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="admin-card">
    <div class="admin-card-head">
        <div class="admin-card-title">
            <span style="width:8px;height:8px;border-radius:50%;background:var(--primary);display:inline-block"></span>
            Tüm Kullanıcılar
        </div>

        <form method="GET" action="{{ route('admin.users.index') }}"
              style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
            <div class="admin-input-wrap">
                <i class="ki-duotone ki-magnifier fs-5 admin-input-icon">
                    <span class="path1"></span><span class="path2"></span>
                </i>
                <input type="text" name="q" class="admin-filter-input" style="width:200px"
                       placeholder="İsim, e-posta..." value="{{ request('q') }}">
            </div>

            <select name="role" class="admin-filter-select" style="width:120px">
                <option value="">Tüm Roller</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ request('role')===$role->name?'selected':'' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>

            <select name="verified" class="admin-filter-select" style="width:140px">
                <option value="">Tüm Durum</option>
                <option value="yes" {{ request('verified')==='yes'?'selected':'' }}>Doğrulanmış</option>
                <option value="no"  {{ request('verified')==='no' ?'selected':'' }}>Beklemede</option>
            </select>

            <button type="submit" class="btn-admin-pri">
                <i class="ki-duotone ki-filter-search fs-5"><span class="path1"></span><span class="path2"></span></i>
                Filtrele
            </button>

            @if(request()->hasAny(['q','role','verified']))
            <a href="{{ route('admin.users.index') }}" class="btn-admin-sec">
                <i class="ki-duotone ki-cross fs-5"><span class="path1"></span><span class="path2"></span></i>
            </a>
            @endif
        </form>
    </div>

    <div style="overflow-x:auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Kullanıcı</th>
                    <th>Rol</th>
                    <th>İlan</th>
                    <th>Teklif</th>
                    <th>Durum</th>
                    <th>Kayıt</th>
                    <th style="text-align:right">İşlem</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" class="a-avatar" alt="">
                            @else
                                <div class="a-avatar-init">{{ strtoupper(substr($user->name,0,1)) }}</div>
                            @endif
                            <div>
                                <div style="font-weight:600;color:var(--text);font-size:14px">{{ $user->name }}</div>
                                <div style="font-size:12px;color:var(--muted)">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @foreach($user->roles as $role)
                        <span class="a-badge {{ $role->name }}">{{ ucfirst($role->name) }}</span>
                        @endforeach
                    </td>
                    <td style="font-weight:600">{{ $user->auctions_count }}</td>
                    <td style="font-weight:600">{{ $user->bids_count }}</td>
                    <td>
                        @if($user->is_verified)
                            <span class="a-badge success">
                                <i class="ki-duotone ki-shield-tick fs-8"><span class="path1"></span><span class="path2"></span></i>
                                Doğrulandı
                            </span>
                        @else
                            <span class="a-badge warning">
                                <i class="ki-duotone ki-time fs-8"><span class="path1"></span><span class="path2"></span></i>
                                Beklemede
                            </span>
                        @endif
                    </td>
                    <td style="color:var(--muted);font-size:13px">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:5px">
                            <a href="{{ route('admin.users.show', $user) }}"
                               class="btn-admin-sec btn-sm-icon" title="Detay">
                                <i class="ki-duotone ki-eye fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="btn-admin-pri btn-sm-icon" title="Düzenle">
                                <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>
                            </a>

                            @if($user->is_verified)
                            <form method="POST" action="{{ route('admin.users.unverify', $user) }}" class="verify-form">
                                @csrf
                                <button type="submit" class="btn-admin-danger btn-sm-icon"
                                        data-name="{{ $user->name }}" data-action="unverify" title="Doğrulamayı kaldır">
                                    <i class="ki-duotone ki-shield-cross fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                </button>
                            </form>
                            @else
                            <form method="POST" action="{{ route('admin.users.verify', $user) }}" class="verify-form">
                                @csrf
                                <button type="submit" class="btn-admin-success btn-sm-icon"
                                        data-name="{{ $user->name }}" data-action="verify" title="Doğrula">
                                    <i class="ki-duotone ki-shield-tick fs-6"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                            </form>
                            @endif

                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="delete-form">
                                @csrf @method('DELETE')
                                <button type="button" class="btn-admin-danger btn-sm-icon delete-btn"
                                        data-name="{{ $user->name }}" title="Sil">
                                    <i class="ki-duotone ki-trash fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:52px;color:var(--muted)">
                        Kullanıcı bulunamadı
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div style="padding:14px 20px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between">
        <span style="font-size:13px;color:var(--muted)">
            <strong style="color:var(--text)">{{ $users->firstItem() }}–{{ $users->lastItem() }}</strong> / {{ $users->total() }}
        </span>
        <div class="admin-pages">
            @if(!$users->onFirstPage())
            <a href="{{ $users->previousPageUrl() }}" class="admin-page">
                <i class="ki-duotone ki-left fs-6"><span class="path1"></span><span class="path2"></span></i>
            </a>
            @endif
            @foreach($users->getUrlRange(max(1,$users->currentPage()-2),min($users->lastPage(),$users->currentPage()+2)) as $page => $url)
            <a href="{{ $url }}" class="admin-page {{ $page===$users->currentPage()?'active':'' }}">{{ $page }}</a>
            @endforeach
            @if($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}" class="admin-page">
                <i class="ki-duotone ki-right fs-6"><span class="path1"></span><span class="path2"></span></i>
            </a>
            @endif
        </div>
    </div>
    @endif
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
        }).then(result => { if (result.isConfirmed) form.submit(); });
    });
});

document.querySelectorAll('.verify-form button').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const name   = this.dataset.name;
        const action = this.dataset.action;
        const form   = this.closest('form');
        const isVerify = action === 'verify';
        Swal.fire({
            title: isVerify ? 'Hesabı doğrula?' : 'Doğrulamayı kaldır?',
            html: `<strong>${name}</strong> ${isVerify ? 'doğrulanmış olarak işaretlenecek.' : 'doğrulaması kaldırılacak.'}`,
            icon: isVerify ? 'success' : 'warning',
            showCancelButton: true,
            confirmButtonText: isVerify ? 'Doğrula' : 'Kaldır',
            cancelButtonText: 'Vazgeç',
            reverseButtons: true,
        }).then(result => { if (result.isConfirmed) form.submit(); });
    });
});
</script>
@endpush