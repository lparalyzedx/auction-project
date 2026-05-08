@extends('layouts.app')
@section('title', 'Düzenle — ' . $user->name)
@section('content')
<div class="admin-fade">

<div class="admin-toolbar">
    <div class="d-flex align-items-center justify-content-between position-relative">
        <div>
            <div class="toolbar-title">Kullanıcı Düzenle</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Kullanıcılar</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.show',$user) }}">{{ $user->name }}</a></li>
                    <li class="breadcrumb-item active">Düzenle</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.users.show', $user) }}" class="btn-admin-sec">
            <i class="ki-duotone ki-left fs-5"><span class="path1"></span><span class="path2"></span></i>
            Geri
        </a>
    </div>
</div>

<div class="row g-5">

<div class="col-xl-4">
    <div class="admin-card">
        <div class="admin-hero">
            <div style="position:relative;z-index:1">
                <div class="avatar-ring" style="width:80px;height:80px;margin:0 auto 12px" id="avatarRing">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" id="avatarPreview">
                    @else
                        <div id="avatarPreview" style="width:100%;height:100%;border-radius:50%;background:#1a2e45;display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:800;color:#818cf8">
                            {{ strtoupper(substr($user->name,0,1)) }}
                        </div>
                    @endif
                </div>
                <div id="previewName" style="font-size:16px;font-weight:700;color:#fff;margin-bottom:3px">{{ $user->name }}</div>
                <div id="previewEmail" style="font-size:12px;color:rgba(255,255,255,.5)">{{ $user->email }}</div>
            </div>
        </div>
        <div style="padding:18px 20px">
            @foreach([
                ['icon'=>'ki-fingerprint-scanning','lbl'=>'ID',     'val'=>'#'.$user->id],
                ['icon'=>'ki-calendar',            'lbl'=>'Kayıt',  'val'=>$user->created_at->format('d M Y')],
                ['icon'=>'ki-price-tag',           'lbl'=>'İlan',   'val'=>$user->auctions()->count().' adet'],
                ['icon'=>'ki-graph-up',            'lbl'=>'Teklif', 'val'=>$user->bids()->count().' adet'],
            ] as $row)
            <div style="display:flex;justify-content:space-between;align-items:center;padding:9px 0;border-bottom:1px solid var(--border);font-size:13px">
                <div style="display:flex;align-items:center;gap:8px;color:var(--muted)">
                    <i class="ki-duotone {{ $row['icon'] }} fs-5"><span class="path1"></span><span class="path2"></span></i>
                    {{ $row['lbl'] }}
                </div>
                <span style="font-weight:600;color:var(--text)">{{ $row['val'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="col-xl-8">
    <div class="admin-card">
        <div class="admin-card-head">
            <div class="admin-card-title">
                <i class="ki-duotone ki-pencil fs-4" style="color:var(--primary)">
                    <span class="path1"></span><span class="path2"></span>
                </i>
                Bilgileri Güncelle
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div style="padding:26px">

                @if($errors->any())
                <div class="alert-au danger mb-5">
                    <i class="ki-duotone ki-cross-circle fs-3" style="color:#f87171"><span class="path1"></span><span class="path2"></span></i>
                    <div>
                        @foreach($errors->all() as $err)
                            <div style="color:var(--text);font-size:13px">{{ $err }}</div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div style="margin-bottom:22px">
                    <label class="admin-flabel">Profil Fotoğrafı</label>
                    <label for="avatar" class="admin-upload">
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" id="avatarPreviewSm"
                                 style="width:54px;height:54px;border-radius:10px;object-fit:cover;border:1px solid var(--border);flex-shrink:0" alt="">
                        @else
                            <div id="avatarPreviewSm" style="width:54px;height:54px;border-radius:10px;background:rgba(145,70,255,.12);display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;color:var(--primary);flex-shrink:0">
                                {{ strtoupper(substr($user->name,0,1)) }}
                            </div>
                        @endif
                        <div>
                            <div style="font-size:14px;font-weight:600;color:var(--text);margin-bottom:3px">Fotoğraf yükle</div>
                            <div style="font-size:12px;color:var(--muted);margin-bottom:8px">PNG, JPG, WEBP · Maks. 2MB</div>
                            <div style="display:inline-flex;align-items:center;gap:6px;padding:5px 12px;border-radius:8px;background:var(--bg);border:1px solid var(--border);font-size:13px;font-weight:600;color:var(--text);pointer-events:none">
                                <i class="ki-duotone ki-folder-up fs-5"><span class="path1"></span><span class="path2"></span></i>
                                Seç
                            </div>
                        </div>
                        <input type="file" id="avatar" name="avatar" accept=".png,.jpg,.jpeg,.webp" class="d-none">
                    </label>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="admin-flabel">Ad Soyad <span class="req">*</span></label>
                        <div class="admin-fwrap">
                            <i class="ki-duotone ki-profile-user fs-4 admin-ficon"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                            <input type="text" name="name" id="inputName"
                                   class="admin-finput @error('name') is-invalid @enderror"
                                   value="{{ old('name',$user->name) }}" placeholder="Ad Soyad">
                        </div>
                        @error('name')<div class="admin-ferr">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="admin-flabel">E-posta <span class="req">*</span></label>
                        <div class="admin-fwrap">
                            <i class="ki-duotone ki-sms fs-4 admin-ficon"><span class="path1"></span><span class="path2"></span></i>
                            <input type="email" name="email" id="inputEmail"
                                   class="admin-finput @error('email') is-invalid @enderror"
                                   value="{{ old('email',$user->email) }}" placeholder="eposta@domain.com">
                        </div>
                        @error('email')<div class="admin-ferr">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="admin-flabel">Telefon</label>
                        <div class="admin-fwrap">
                            <i class="ki-duotone ki-phone fs-4 admin-ficon"><span class="path1"></span><span class="path2"></span></i>
                            <input type="tel" name="phone" class="admin-finput"
                                   value="{{ old('phone',$user->phone) }}" placeholder="05xx xxx xx xx" maxlength="20">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="admin-flabel">Rol <span class="req">*</span></label>
                        <div class="admin-fwrap">
                            <i class="ki-duotone ki-crown fs-4 admin-ficon"><span class="path1"></span><span class="path2"></span></i>
                            <select name="role" class="admin-fselect @error('role') is-invalid @enderror">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ old('role',$user->roles->first()?->name)===$role->name?'selected':'' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('role')<div class="admin-ferr">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <label class="admin-flabel">
                            Yeni Şifre
                            <span style="color:var(--muted);font-weight:400;text-transform:none;letter-spacing:0">(boş = değişmez)</span>
                        </label>
                        <div class="admin-fwrap">
                            <i class="ki-duotone ki-lock fs-4 admin-ficon"><span class="path1"></span><span class="path2"></span></i>
                            <input type="password" name="password" id="pw1"
                                   class="admin-finput @error('password') is-invalid @enderror"
                                   placeholder="Yeni şifre" style="padding-right:44px">
                            <button type="button" onclick="togglePw('pw1',this)"
                                    style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--muted);cursor:pointer;padding:4px">
                                <i class="ki-duotone ki-eye-slash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </button>
                        </div>
                        @error('password')<div class="admin-ferr">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="admin-flabel">Şifre Tekrar</label>
                        <div class="admin-fwrap">
                            <i class="ki-duotone ki-lock fs-4 admin-ficon"><span class="path1"></span><span class="path2"></span></i>
                            <input type="password" name="password_confirmation" id="pw2"
                                   class="admin-finput" placeholder="Şifre tekrar" style="padding-right:44px">
                            <button type="button" onclick="togglePw('pw2',this)"
                                    style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--muted);cursor:pointer;padding:4px">
                                <i class="ki-duotone ki-eye-slash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;background:var(--bg-soft);border:1px solid var(--border);border-radius:12px">
                    <div>
                        <div style="font-size:14px;font-weight:600;color:var(--text)">Hesap Doğrulaması</div>
                        <div style="font-size:12px;color:var(--muted);margin-top:2px">Kullanıcıyı manuel doğrula</div>
                    </div>
                    <label class="admin-toggle">
                        <input type="checkbox" name="is_verified" value="1"
                               {{ old('is_verified',$user->is_verified)?'checked':'' }}>
                        <span class="admin-toggle-slider"></span>
                    </label>
                </div>

            </div>

            <div style="padding:18px 26px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;gap:10px">
                <a href="{{ route('admin.users.show',$user) }}" class="btn-admin-sec">İptal</a>
                <button type="submit" class="btn-admin-pri" id="saveBtn">
                    <span class="s-lbl">
                        <i class="ki-duotone ki-save-2 fs-5"><span class="path1"></span><span class="path2"></span></i>
                        Kaydet
                    </span>
                    <span class="s-ldg d-none">
                        <span class="spinner-border spinner-border-sm me-1"></span>Kaydediliyor...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

</div>
</div>
@endsection

@push('scripts')
<script>
function togglePw(id, btn) {
    const inp = document.getElementById(id);
    const icon = btn.querySelector('i');
    inp.type = inp.type === 'password' ? 'text' : 'password';
    icon.className = inp.type === 'password'
        ? 'ki-duotone ki-eye-slash fs-5'
        : 'ki-duotone ki-eye fs-5';
    icon.innerHTML = '<span class="path1"></span><span class="path2"></span><span class="path3"></span>';
}

document.getElementById('avatar')?.addEventListener('change', function() {
    if (!this.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        ['avatarPreview','avatarPreviewSm'].forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;
            if (el.tagName === 'IMG') {
                el.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.id = id;
                img.style.cssText = el.style.cssText + 'border-radius:50%;object-fit:cover;width:100%;height:100%;border:3px solid #1a2e45;display:block';
                el.replaceWith(img);
            }
        });
    };
    reader.readAsDataURL(this.files[0]);
});

document.getElementById('inputName')?.addEventListener('input', function() {
    const el = document.getElementById('previewName');
    if (el) el.textContent = this.value || '{{ addslashes($user->name) }}';
});
document.getElementById('inputEmail')?.addEventListener('input', function() {
    const el = document.getElementById('previewEmail');
    if (el) el.textContent = this.value || '{{ addslashes($user->email) }}';
});

document.querySelector('form')?.addEventListener('submit', function() {
    const btn = document.getElementById('saveBtn');
    if (!btn) return;
    btn.querySelector('.s-lbl').classList.add('d-none');
    btn.querySelector('.s-ldg').classList.remove('d-none');
    btn.disabled = true;
});
</script>
@endpush