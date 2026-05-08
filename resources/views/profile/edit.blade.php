@extends('layouts.app')
@section('title', 'Profilim')
@section('content')

    <div class="admin-toolbar">
    <div class="d-flex align-items-center justify-content-between position-relative">
        <div>
            <div class="toolbar-title">Hesap Ayarları</div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Anasayfa</a></li>
                    <li class="breadcrumb-item active">Profilim</li>
                </ol>
            </nav>
        </div>
        
    </div>
</div>

    <div class="row g-6">

        <div class="col-xl-4 animate-in">
            <div class="profile-summary-card card">
                <div class="card-body p-8">

                    <div class="text-center mb-6">
                        <div class="avatar-ring">
                            <img src="{{ $user->profile_img }}" alt="{{ $user->name }}" id="avatarPreview">
                            <div class="avatar-online"></div>
                        </div>
                        <h3 class="text-white fw-bolder fs-4 mb-1">{{ $user->name }}</h3>
                        <div class="text-white opacity-60 fs-7 mb-3">{{ $user->email }}</div>

                        @php
                            $roleClass = match ($user->roles->first()->name) {
                                'admin' => 'role-badge-admin',
                                'seller' => 'role-badge-seller',
                                default => 'role-badge-buyer',
                            };
                            $roleLabel = match ($user->roles->first()->name) {
                                'admin' => '👑 Admin',
                                'seller' => '🏪 Satıcı',
                                default => '🛍️ Alıcı',
                            };
                        @endphp
                        <span class="badge {{ $roleClass }} fw-bold px-3 py-2 fs-8 rounded-pill">
                            {{ $roleLabel }}
                        </span>
                    </div>

                    <div class="row g-3 mb-6">
                        <div class="col-4">
                            <div class="stat-pill text-center">
                                <div class="text-white fw-bolder fs-3">{{ $user->auctions()->count() }}</div>
                                <div class="text-white opacity-50 fs-9 fw-semibold">İLAN</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-pill text-center">
                                <div class="text-white fw-bolder fs-3">{{ $user->bids()->count() }}</div>
                                <div class="text-white opacity-50 fs-9 fw-semibold">TEKLİF</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-pill text-center">
                                <div class="text-white fw-bolder fs-3">{{ $user->watchlist()->count() }}</div>
                                <div class="text-white opacity-50 fs-9 fw-semibold">TAKİP</div>
                            </div>
                        </div>
                    </div>

                    <div>
                        @if ($user->phone)
                            <div class="profile-info-row">
                                <div class="icon-wrap">
                                    <i class="ki-duotone ki-phone fs-5 text-white opacity-70">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                </div>
                                <div>
                                    <div class="text-white opacity-50 fs-9 fw-semibold">TELEFON</div>
                                    <div class="text-white fs-7 fw-semibold">{{ $user->phone }}</div>
                                </div>
                            </div>
                        @endif

                        <div class="profile-info-row">
                            <div class="icon-wrap">
                                <i class="ki-duotone ki-sms fs-5 text-white opacity-70">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </div>
                            <div style="min-width:0">
                                <div class="text-white opacity-50 fs-9 fw-semibold">E-POSTA</div>
                                <div class="text-white fs-7 fw-semibold text-truncate" style="max-width:180px">
                                    {{ $user->email }}</div>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="icon-wrap">
                                <i class="ki-duotone ki-calendar fs-5 text-white opacity-70">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </div>
                            <div>
                                <div class="text-white opacity-50 fs-9 fw-semibold">ÜYELİK</div>
                                <div class="text-white fs-7 fw-semibold">{{ $user->created_at->format('d M Y') }}</div>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="icon-wrap">
                                <i class="ki-duotone ki-shield-tick fs-5 text-white opacity-70">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                            </div>
                            <div>
                                <div class="text-white opacity-50 fs-9 fw-semibold">DOĞRULAMA</div>
                                <div>
                                    @if ($user->email_verified_at)
                                        <span class="badge bg-success text-white fs-9">✓ Doğrulanmış</span>
                                    @else
                                        <span class="badge bg-warning text-dark fs-9">Beklemede</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-8">

            <div class="settings-card animate-in">
                <div class="card-header d-flex align-items-center justify-content-between" data-bs-toggle="collapse"
                    data-bs-target="#collapseProfile">
                    <h3 class="text-white">
                        Kişisel Bilgiler
                    </h3>
                    <i class="ki-duotone ki-down fs-4 text-muted chevron-icon">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                </div>

                <div id="collapseProfile" class="collapse show">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="p-8">
                            @if (session('profile_success'))
                                <div class="alert-au success">
                                    <i class="ki-duotone ki-shield-tick fs-2 text-success mt-1">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    <div>
                                        <div class="fw-bold text-success fs-7">Başarıyla Güncellendi</div>
                                        <div class="text-muted fs-8">{{ session('profile_success') }}</div>
                                    </div>
                                </div>
                            @endif
                            <div class="mb-7">
                                <div class="section-label">Profil Fotoğrafı</div>
                                <label for="profile_image" class="avatar-upload-zone d-flex">
                                    <img src="{{ $user->profile_img }}" alt="" class="avatar-preview"
                                        id="avatarPreviewSmall">
                                    <div class="flex-grow-1">
                                        <div class="fw-bold text-white fs-7 mb-1">Fotoğraf yükle veya değiştir</div>
                                        <div class="text-muted fs-8 mb-3">PNG, JPG, WEBP · Maks. 2MB</div>
                                        <span class="btn btn-sm btn-primary fw-semibold px-4" style="pointer-events:none">
                                            <i class="ki-duotone ki-folder-up fs-5 me-1"><span class="path1"></span><span
                                                    class="path2"></span></i>
                                            Dosya Seç
                                        </span>
                                    </div>
                                    <input type="file" id="profile_image" name="profile_image"
                                        accept=".png,.jpg,.jpeg,.webp" class="d-none">
                                </label>
                            </div>

                            <div class="mb-5">
                                <div class="section-label">Ad Soyad <span class="text-danger">*</span></div>
                                <div class="input-group-icon">
                                    <i class="ki-duotone ki-profile-user fs-4 input-icon">
                                        <span class="path1"></span><span class="path2"></span>
                                        <span class="path3"></span><span class="path4"></span>
                                    </i>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Adınız ve soyadınız" value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback d-block mt-1 fs-8">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-5">
                                <div class="section-label">GSM Numarası <span class="text-danger">*</span></div>
                                <div class="input-group-icon">
                                    <i class="ki-duotone ki-phone fs-4 input-icon">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    <input type="tel" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="05xx xxx xx xx" value="{{ old('phone', $user->phone) }}"
                                        maxlength="20">
                                    @error('phone')
                                        <div class="invalid-feedback d-block mt-1 fs-8">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="section-label">E-posta Adresi</div>
                                <div class="input-group-icon">
                                    <i class="ki-duotone ki-sms fs-4 input-icon">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                </div>
                                <div class="text-muted fs-8 mt-2 ms-1">
                                    <i class="ki-duotone ki-information fs-6 me-1 text-warning">
                                        <span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span>
                                    </i>
                                    E-postayı değiştirmek için "Giriş Güvenliği" bölümünü kullanın.
                                </div>
                            </div>

                        </div>

                        <div class="px-8 pb-8 d-flex justify-content-end gap-3">
                            <button type="reset" class="btn-admin-sec">Sıfırla</button>
                            <button type="submit" class="btn-admin-pri">
                                <span class="indicator-label">
                                    <i class="ki-duotone ki-check fs-5 me-1"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    Değişiklikleri Kaydet
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="settings-card animate-in">
                <div class="card-header d-flex align-items-center justify-content-between" data-bs-toggle="collapse"
                    data-bs-target="#collapseLogin">
                    <h3 class="text-white">
                        Giriş Güvenliği
                    </h3>
                    <i class="ki-duotone ki-down fs-4 text-muted chevron-icon">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                </div>

                <div id="collapseLogin" class="collapse show">
                    <div class="p-8">

                        <div class="security-row">
                            <div id="emailView"
                                class="d-flex align-items-center justify-content-between
                                                    {{ $errors->hasAny(['email', 'confirmemailpassword']) ? 'd-none' : '' }}">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="symbol symbol-40px">
                                        <div class="symbol-label bg-primary bg-opacity-10 rounded-circle">
                                            <i class="ki-duotone ki-sms fs-4 text-primary">
                                                <span class="path1"></span><span class="path2"></span>
                                            </i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-white fs-7">E-posta Adresi</div>
                                        <div class="text-muted fs-8">{{ $user->email }}</div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary fw-semibold px-4"
                                    id="editEmail">
                                    Değiştir
                                </button>
                            </div>

                            <div id="emailEdit"
                                class="{{ $errors->hasAny(['email', 'confirmemailpassword']) ? '' : 'd-none' }}">
                                @if (session('email_success'))
                                    <div class="alert-au success mb-5">
                                        <i class="ki-duotone ki-shield-tick fs-2 text-success"><span
                                                class="path1"></span><span class="path2"></span></i>
                                        <div class="fw-semibold text-success fs-7">{{ session('email_success') }}</div>
                                    </div>
                                @endif

                                <div class="fw-bold  fs-7 mb-4 d-flex align-items-center gap-2">
                                    <i class="ki-duotone ki-sms fs-4 text-primary"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    E-posta Adresini Değiştir
                                </div>

                                <form method="POST" action="{{ route('profile.email') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-4 mb-5">
                                        <div class="col-md-6">
                                            <div class="section-label">Yeni E-posta <span class="text-danger">*</span>
                                            </div>
                                            <div class="input-group-icon">
                                                <i class="ki-duotone ki-sms fs-4 input-icon"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                                <input type="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    placeholder="yeni@eposta.com"
                                                    value="{{ old('email', $user->email) }}">
                                                @error('email')
                                                    <div class="invalid-feedback d-block fs-8 mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="section-label">Mevcut Şifre <span class="text-danger">*</span>
                                            </div>
                                            <div class="input-group-icon" data-kt-password-meter="true">
                                                <i class="ki-duotone ki-lock fs-4 input-icon"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                                <input type="password" name="confirmemailpassword"
                                                    class="form-control pe-10 @error('confirmemailpassword') is-invalid @enderror"
                                                    placeholder="••••••••">
                                                <span
                                                    class="btn btn-sm btn-icon position-absolute top-50 end-0 translate-middle-y"
                                                    data-kt-password-meter-control="visibility">
                                                    <i class="bi bi-eye-slash fs-5"></i>
                                                    <i class="bi bi-eye fs-5 d-none"></i>
                                                </span>
                                                @error('confirmemailpassword')
                                                    <div class="invalid-feedback d-block fs-8 mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-3">
                                        <button type="submit" class="btn-admin-pri">E-postayı Güncelle</button>
                                        <button type="button" class="btn-admin-sec" id="cancelEmail">Vazgeç</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="security-row">
                            <div id="passwordView"
                                class="d-flex align-items-center justify-content-between
                                                       {{ $errors->hasAny(['currentpassword', 'password']) ? 'd-none' : '' }}">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="symbol symbol-40px">
                                        <div class="symbol-label bg-warning bg-opacity-10 rounded-circle">
                                            <i class="ki-duotone ki-lock-3 fs-4 text-warning">
                                                <span class="path1"></span><span class="path2"></span><span
                                                    class="path3"></span>
                                            </i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-white fs-7">Şifre</div>
                                        <div class="text-muted fs-8">Son değişiklik: Bilinmiyor</div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary fw-semibold px-4"
                                    id="editPassword">
                                    Değiştir
                                </button>
                            </div>

                            <div id="passwordEdit"
                                class="{{ $errors->hasAny(['currentpassword', 'password']) ? '' : 'd-none' }}">
                                @if (session('password_success'))
                                    <div class="alert-au success mb-5">
                                        <i class="ki-duotone ki-shield-tick fs-2 text-success"><span
                                                class="path1"></span><span class="path2"></span></i>
                                        <div class="fw-semibold text-success fs-7">{{ session('password_success') }}</div>
                                    </div>
                                @endif

                                <div class="fw-bold fs-7 mb-4 d-flex align-items-center gap-2">
                                    <i class="ki-duotone ki-lock-3 fs-4 text-warning"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span></i>
                                    Şifre Değiştir
                                </div>

                                <form method="POST" action="{{ route('profile.password') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-4 mb-4">
                                        <div class="col-md-4">
                                            <div class="section-label">Mevcut Şifre <span class="text-danger">*</span>
                                            </div>
                                            <div class="input-group-icon" data-kt-password-meter="true">
                                                <i class="ki-duotone ki-lock fs-4 input-icon"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                                <input type="password" name="currentpassword"
                                                    class="form-control pe-10 @error('currentpassword') is-invalid @enderror"
                                                    placeholder="••••••••">
                                                <span
                                                    class="btn btn-sm btn-icon position-absolute top-50 end-0 translate-middle-y"
                                                    data-kt-password-meter-control="visibility">
                                                    <i class="bi bi-eye-slash fs-5"></i>
                                                    <i class="bi bi-eye fs-5 d-none"></i>
                                                </span>
                                                @error('currentpassword')
                                                    <div class="invalid-feedback d-block fs-8 mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="section-label">Yeni Şifre <span class="text-danger">*</span></div>
                                            <div class="input-group-icon" data-kt-password-meter="true">
                                                <i class="ki-duotone ki-lock fs-4 input-icon"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                                <input type="password" name="password"
                                                    class="form-control pe-10 @error('password') is-invalid @enderror"
                                                    placeholder="••••••••">
                                                <span
                                                    class="btn btn-sm btn-icon position-absolute top-50 end-0 translate-middle-y"
                                                    data-kt-password-meter-control="visibility">
                                                    <i class="bi bi-eye-slash fs-5"></i>
                                                    <i class="bi bi-eye fs-5 d-none"></i>
                                                </span>
                                                @error('password')
                                                    <div class="invalid-feedback d-block fs-8 mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="section-label">Tekrar <span class="text-danger">*</span></div>
                                            <div class="input-group-icon" data-kt-password-meter="true">
                                                <i class="ki-duotone ki-lock fs-4 input-icon"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                                <input type="password" name="password_confirmation"
                                                    class="form-control pe-10" placeholder="••••••••">
                                                <span
                                                    class="btn btn-sm btn-icon position-absolute top-50 end-0 translate-middle-y"
                                                    data-kt-password-meter-control="visibility">
                                                    <i class="bi bi-eye-slash fs-5"></i>
                                                    <i class="bi bi-eye fs-5 d-none"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-muted fs-8 mb-5">
                                        <i class="ki-duotone ki-information fs-5 me-1 text-warning">
                                            <span class="path1"></span><span class="path2"></span><span
                                                class="path3"></span>
                                        </i>
                                        En az 8 karakter, büyük/küçük harf ve sembol içermelidir.
                                    </div>
                                    <div class="d-flex gap-3">
                                        <button type="submit" class="btn-admin-pri">Şifreyi Güncelle</button>
                                        <button type="button" class="btn-admin-sec" id="cancelPassword">Vazgeç</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const emailView = document.getElementById('emailView');
        const emailEdit = document.getElementById('emailEdit');

        const passwordView = document.getElementById('passwordView');
        const passwordEdit = document.getElementById('passwordEdit');

        function closeEmail() {
            emailView?.classList.remove('d-none');
            emailEdit?.classList.add('d-none');
        }

        function openEmail() {
            closePassword(); // 🔥 kritik
            emailView?.classList.add('d-none');
            emailEdit?.classList.remove('d-none');
        }

        function closePassword() {
            passwordView?.classList.remove('d-none');
            passwordEdit?.classList.add('d-none');
        }

        function openPassword() {
            closeEmail(); // 🔥 kritik
            passwordView?.classList.add('d-none');
            passwordEdit?.classList.remove('d-none');
        }

        // EMAIL
        document.getElementById('editEmail')?.addEventListener('click', openEmail);

        document.getElementById('cancelEmail')?.addEventListener('click', closeEmail);

        // PASSWORD
        document.getElementById('editPassword')?.addEventListener('click', openPassword);

        document.getElementById('cancelPassword')?.addEventListener('click', closePassword);

        // AVATAR PREVIEW
        document.getElementById('profile_image')?.addEventListener('change', function() {
            if (!this.files || !this.files[0]) return;

            const reader = new FileReader();
            reader.onload = e => {
                ['avatarPreview', 'avatarPreviewSmall'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.src = e.target.result;
                });
            };
            reader.readAsDataURL(this.files[0]);
        });

        // COLLAPSE ICON ROTATION
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(btn => {
            const targetId = btn.getAttribute('data-bs-target');
            const chevron = btn.querySelector('.chevron-icon');
            const target = document.querySelector(targetId);

            if (!target || !chevron) return;

            target.addEventListener('hide.bs.collapse', () => {
                chevron.style.transform = 'rotate(-90deg)';
            });

            target.addEventListener('show.bs.collapse', () => {
                chevron.style.transform = 'rotate(0deg)';
            });
        });
    </script>
@endpush
