@extends('layouts.app')
@section('title','Profil')
@section('content')
@php
    $roleKey   = $user->roles->first()?->name ?? 'user';
    $roleLabel = match($roleKey) { 'admin' => '👑 Admin', 'seller' => '🏪 Onaylı Satıcı', default => '🛍️ Üye' };
    $isOwner   = auth()->id() === $user->id;
@endphp

<div class="pf-root">

    <div class="pf-top">

        <div class="pf-cover"></div>

        <div class="pf-identity">

            <div class="pf-avatar-wrap">
                <div class="pf-avatar-outer">
                    <img src="{{ $user->profile_img ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=7c3aed&color=fff&size=256' }}"
                         alt="{{ $user->name }}"
                         id="heroAvatar"
                         class="pf-avatar-img">
                </div>
                @if(method_exists($user,'isOnline') && $user->isOnline())
                    <span class="pf-online-dot"></span>
                @endif
            </div>

            <div class="pf-identity-right">
                <div>
                    <div class="pf-uname-row">
                        <span class="pf-uname" id="heroName">{{ $user->name }}</span>
                        <span class="pf-role-badge">{{ $roleLabel }}</span>
                    </div>
                    @if($user->username)
                        <div class="pf-handle" id="heroHandle">{{"@" . $user->username }}</div>
                    @endif
                    <div class="pf-bio" id="heroBio">
                        {{ $user->bio ?? 'Koleksiyon parçaları ve güvenli açık artırmanın adresi.' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="pf-stats-row">
            <div class="pf-stat">
                <div class="pf-stat-num">{{ $user->auctions()->count() }}</div>
                <div class="pf-stat-label">İLAN</div>
            </div>
            <div class="pf-stat">
                <div class="pf-stat-num">{{ $user->bids()->count() }}</div>
                <div class="pf-stat-label">TEKLİF</div>
            </div>
            <div class="pf-stat">
                <div class="pf-stat-num">{{ $user->watchlist()->count() }}</div>
                <div class="pf-stat-label">TAKİP</div>
            </div>
            <div class="pf-stat">
                <div class="pf-stat-num">4.8</div>
                <div class="pf-stat-label">PUAN</div>
            </div>
        </div>

        <div class="pf-action-row">
            @if($isOwner)
                <button class="pf-btn-edit" id="editToggle" onclick="toggleEdit()">
                    <i class="bi bi-pencil me-1"></i> Profili Düzenle
                </button>
                <button class="pf-btn-icon" aria-label="Paylaş">
                    <i class="bi bi-share"></i>
                </button>
            @else
                @auth
                    <button class="pf-btn-primary">
                        <i class="bi bi-person-plus me-1"></i> Takip Et
                    </button>
                    <button class="pf-btn-secondary">
                        <i class="bi bi-chat-dots me-1"></i> Mesaj
                    </button>
                @endauth
            @endif
        </div>
    </div>

    @if($isOwner)
    <div class="pf-edit-drawer" id="editDrawer">

        <div class="pf-edit-tabs">
            <button class="pf-etab active" onclick="switchETab('genel',this)">
                <i class="bi bi-person me-1"></i> Genel
            </button>
            <button class="pf-etab" onclick="switchETab('guvenlik',this)">
                <i class="bi bi-shield me-1"></i> Güvenlik
            </button>
            <button class="pf-etab" onclick="switchETab('gizlilik',this)">
                <i class="bi bi-eye-slash me-1"></i> Gizlilik
            </button>
            <button class="pf-etab" onclick="switchETab('sosyal',this)">
                <i class="bi bi-link-45deg me-1"></i> Sosyal
            </button>
        </div>

        <div id="ep-genel" class="pf-epanel active">

            @if(session('profile_success'))
                <div class="pf-alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('profile_success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="pf-avatar-upload-row">
                    <label for="profile_image" class="pf-upload-avatar" style="cursor:pointer;" title="Fotoğraf değiştir">
                        <img src="{{ $user->profile_img ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=7c3aed&color=fff&size=256' }}"
                             alt="{{ $user->name }}" id="avatarPreviewSmall" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                        <input type="file" id="profile_image" name="profile_image" accept=".png,.jpg,.jpeg,.webp" class="d-none">
                    </label>
                    <div>
                        <div class="pf-upload-title">Profil fotoğrafı</div>
                        <div class="pf-upload-desc">PNG, JPG, WEBP · Maks. 2MB</div>
                        <label for="profile_image" class="pf-btn-photo mt-2 d-inline-flex align-items-center gap-1" style="cursor:pointer;">
                            <i class="bi bi-upload"></i> Fotoğraf yükle
                        </label>
                    </div>
                </div>

                <div class="pf-two-col">
                    <div class="pf-field">
                        <label class="pf-label">Ad <span class="pf-req">*</span></label>
                        <input class="pf-input" type="text" name="name"
                               value="{{ old('name', explode(' ', $user->name)[0]) }}"
                               placeholder="Ad">
                        @error('name') <div class="pf-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="pf-field">
                        <label class="pf-label">Soyad</label>
                        <input class="pf-input" type="text" name="surname"
                               value="{{ old('surname', implode(' ', array_slice(explode(' ', $user->name), 1))) }}"
                               placeholder="Soyad">
                    </div>
                </div>

                <div class="pf-field">
                    <label class="pf-label">Kullanıcı adı <span class="pf-req">*</span></label>
                    <div class="pf-input-pre">
                        <span class="pf-pre-label">@</span>
                        <input type="text" name="username" id="edit_username"
                               value="{{ old('username', $user->username) }}"
                               maxlength="30" placeholder="kullanici_adi">
                    </div>
                    <div class="pf-hint">Sadece harf, rakam, nokta ve alt çizgi · 3–30 karakter</div>
                    @error('username') <div class="pf-error">{{ $message }}</div> @enderror
                </div>

                <div class="pf-field">
                    <label class="pf-label">GSM numarası</label>
                    <div class="pf-input-pre">
                        <span class="pf-pre-label">+90</span>
                        <input type="tel" name="phone"
                               value="{{ old('phone', $user->phone) }}"
                               maxlength="15" placeholder="5xx xxx xx xx">
                    </div>
                    @error('phone') <div class="pf-error">{{ $message }}</div> @enderror
                </div>

                <div class="pf-field">
                    <label class="pf-label">Hakkımda</label>
                    <div style="position:relative;">
                        <textarea class="pf-input" name="bio" id="bio_input" rows="3"
                                  maxlength="300"
                                  oninput="bioCount(this)">{{ old('bio', $user->bio) }}</textarea>
                        <span id="bio_counter" class="pf-char-cnt">{{ strlen(old('bio', $user->bio ?? '')) }}/300</span>
                    </div>
                    @error('bio') <div class="pf-error">{{ $message }}</div> @enderror
                </div>

                <div class="pf-field">
                    <label class="pf-label">E-posta</label>
                    <input class="pf-input" type="email" value="{{ $user->email }}" disabled style="opacity:.4;cursor:not-allowed;">
                    <div class="pf-hint">E-postayı değiştirmek için Güvenlik sekmesini kullan.</div>
                </div>

                <div class="pf-footer">
                    <span class="pf-save-info" id="saveInfo">
                        <i class="bi bi-clock"></i> Kaydedilmedi
                    </span>
                    <div class="d-flex gap-2">
                        <button type="reset" class="pf-btn-reset">Sıfırla</button>
                        <button type="submit" class="pf-btn-save">
                            <i class="bi bi-floppy me-1"></i> Kaydet
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div id="ep-guvenlik" class="pf-epanel">

            <div class="pf-sec-item">
                <div class="pf-sec-icon" style="background:rgba(99,102,241,.12);">
                    <i class="bi bi-envelope" style="color:#818cf8;"></i>
                </div>
                <div class="pf-sec-info">
                    <div class="pf-sec-title">E-posta adresi</div>
                    <div class="pf-sec-sub">{{ $user->email }}</div>
                </div>
                <button class="pf-btn-change" onclick="toggleInline('email-form')">Değiştir</button>
            </div>
            <div class="pf-inline-form" id="email-form">
                @if(session('email_success'))
                    <div class="pf-alert-success mb-3">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('email_success') }}</span>
                    </div>
                @endif
                <form method="POST" action="{{ route('profile.email') }}">
                    @csrf @method('PUT')
                    <div class="pf-two-col mb-3">
                        <div class="pf-field" style="margin-bottom:0;">
                            <label class="pf-label">Yeni e-posta <span class="pf-req">*</span></label>
                            <input class="pf-input" type="email" name="email"
                                   placeholder="yeni@eposta.com"
                                   value="{{ old('email') }}">
                            @error('email') <div class="pf-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="pf-field" style="margin-bottom:0;">
                            <label class="pf-label">Mevcut şifre <span class="pf-req">*</span></label>
                            <input class="pf-input" type="password" name="confirmemailpassword" placeholder="••••••••">
                            @error('confirmemailpassword') <div class="pf-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="pf-btn-save" style="font-size:.8rem;">
                            <i class="bi bi-check me-1"></i> Güncelle
                        </button>
                        <button type="button" class="pf-btn-reset" onclick="toggleInline('email-form')">Vazgeç</button>
                    </div>
                </form>
            </div>

            <div class="pf-sec-item">
                <div class="pf-sec-icon" style="background:rgba(245,158,11,.1);">
                    <i class="bi bi-lock" style="color:#fbbf24;"></i>
                </div>
                <div class="pf-sec-info">
                    <div class="pf-sec-title">Şifre</div>
                    <div class="pf-sec-sub">Son değişim: bilinmiyor</div>
                </div>
                <button class="pf-btn-change" onclick="toggleInline('pass-form')">Değiştir</button>
            </div>
            <div class="pf-inline-form" id="pass-form">
                @if(session('password_success'))
                    <div class="pf-alert-success mb-3">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('password_success') }}</span>
                    </div>
                @endif
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf @method('PUT')
                    <div class="pf-field">
                        <label class="pf-label">Mevcut şifre <span class="pf-req">*</span></label>
                        <input class="pf-input" type="password" name="currentpassword" placeholder="••••••••">
                        @error('currentpassword') <div class="pf-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="pf-two-col">
                        <div class="pf-field" style="margin-bottom:0;">
                            <label class="pf-label">Yeni şifre <span class="pf-req">*</span></label>
                            <input class="pf-input" type="password" name="password"
                                   id="new_pass" placeholder="••••••••"
                                   oninput="passStrength(this)">
                            <div class="pf-pass-bars">
                                <div class="pf-pbar" id="pb1"></div>
                                <div class="pf-pbar" id="pb2"></div>
                                <div class="pf-pbar" id="pb3"></div>
                                <div class="pf-pbar" id="pb4"></div>
                            </div>
                            @error('password') <div class="pf-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="pf-field" style="margin-bottom:0;">
                            <label class="pf-label">Tekrar <span class="pf-req">*</span></label>
                            <input class="pf-input" type="password" name="password_confirmation" placeholder="••••••••">
                        </div>
                    </div>
                    <div class="pf-hint mt-2 mb-3">En az 8 karakter, büyük/küçük harf ve sembol içermeli.</div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="pf-btn-save" style="font-size:.8rem;">
                            <i class="bi bi-check me-1"></i> Güncelle
                        </button>
                        <button type="button" class="pf-btn-reset" onclick="toggleInline('pass-form')">Vazgeç</button>
                    </div>
                </form>
            </div>

            <div class="pf-sec-item" style="border-bottom:none;">
                <div class="pf-sec-icon" style="background:rgba(239,68,68,.1);">
                    <i class="bi bi-exclamation-triangle" style="color:#f87171;"></i>
                </div>
                <div class="pf-sec-info">
                    <div class="pf-sec-title" style="color:#f87171;">Hesabı sil</div>
                    <div class="pf-sec-sub">Tüm veriler kalıcı olarak silinir</div>
                </div>
                <button class="pf-btn-change" style="border-color:rgba(239,68,68,.3);color:#f87171;">Sil</button>
            </div>
        </div>

        <div id="ep-gizlilik" class="pf-epanel">
            <form method="POST" action="{{ route('profile.privacy') }}">
                @csrf @method('PUT')
                <div class="pf-toggle-list">
                    <label class="pf-trow">
                        <div class="pf-trow-info">
                            <div class="pf-trow-title">Profil herkese açık</div>
                            <div class="pf-trow-desc">Arama sonuçlarında görünsün</div>
                        </div>
                        <input type="hidden" name="profile_public" value="0">
                        <input type="checkbox" name="profile_public" value="1" class="pf-tog-input"
                               {{ $user->profile_public ? 'checked' : '' }}>
                    </label>
                    <label class="pf-trow">
                        <div class="pf-trow-info">
                            <div class="pf-trow-title">Teklif geçmişi gizli</div>
                            <div class="pf-trow-desc">Verilen teklifler gizlensin</div>
                        </div>
                        <input type="hidden" name="bids_hidden" value="0">
                        <input type="checkbox" name="bids_hidden" value="1" class="pf-tog-input"
                               {{ $user->bids_hidden ? 'checked' : '' }}>
                    </label>
                    <label class="pf-trow">
                        <div class="pf-trow-info">
                            <div class="pf-trow-title">Çevrimiçi göster</div>
                            <div class="pf-trow-desc">Diğer kullanıcılar sizi görebilsin</div>
                        </div>
                        <input type="hidden" name="show_online" value="0">
                        <input type="checkbox" name="show_online" value="1" class="pf-tog-input"
                               {{ $user->show_online ? 'checked' : '' }}>
                    </label>
                    <label class="pf-trow">
                        <div class="pf-trow-info">
                            <div class="pf-trow-title">E-posta bildirimleri</div>
                            <div class="pf-trow-desc">Teklif ve ilan güncellemeleri</div>
                        </div>
                        <input type="hidden" name="email_notifications" value="0">
                        <input type="checkbox" name="email_notifications" value="1" class="pf-tog-input"
                               {{ $user->email_notifications ? 'checked' : '' }}>
                    </label>
                    <label class="pf-trow" style="border-bottom:none;">
                        <div class="pf-trow-info">
                            <div class="pf-trow-title">Sadece takipten mesaj</div>
                            <div class="pf-trow-desc">Yabancılardan mesaj gelmesin</div>
                        </div>
                        <input type="hidden" name="messages_followers_only" value="0">
                        <input type="checkbox" name="messages_followers_only" value="1" class="pf-tog-input"
                               {{ $user->messages_followers_only ? 'checked' : '' }}>
                    </label>
                </div>
                <div class="pf-footer">
                    <span></span>
                    <button type="submit" class="pf-btn-save">
                        <i class="bi bi-floppy me-1"></i> Kaydet
                    </button>
                </div>
            </form>
        </div>

        <div id="ep-sosyal" class="pf-epanel">
            <form method="POST" action="{{ route('profile.social') }}">
                @csrf @method('PUT')
                @foreach([
                    ['instagram','bi-instagram','instagram.com/'],
                    ['twitter','bi-twitter-x','x.com/'],
                    ['youtube','bi-youtube','youtube.com/@'],
                    ['linkedin','bi-linkedin','linkedin.com/in/'],
                ] as [$key,$icon,$prefix])
                <div class="pf-social-row">
                    <div class="pf-social-icon">
                        <i class="bi {{ $icon }}"></i>
                    </div>
                    <div class="pf-input-pre" style="flex:1;">
                        <span class="pf-pre-label">{{ $prefix }}</span>
                        <input type="text" name="social[{{ $key }}]"
                               value="{{ old('social.'.$key, $user->social[$key] ?? '') }}"
                               placeholder="kullanici_adi">
                    </div>
                </div>
                @endforeach
                <div class="pf-footer">
                    <span></span>
                    <button type="submit" class="pf-btn-save">
                        <i class="bi bi-floppy me-1"></i> Kaydet
                    </button>
                </div>
            </form>
        </div>

    </div>
    @endif

    <div class="pf-content-area">
        <div class="pf-tab-bar">
            <button class="pf-ptab active" onclick="switchPTab('vitrin',this)">
                <i class="bi bi-grid-3x3-gap-fill me-1"></i> Vitrin
            </button>
            <button class="pf-ptab" onclick="switchPTab('degerlendirmeler',this)">
                <i class="bi bi-star me-1"></i> Değerlendirmeler
            </button>
            <button class="pf-ptab" onclick="switchPTab('aktivite',this)">
                <i class="bi bi-activity me-1"></i> Aktivite
            </button>
        </div>

        <div id="pc-vitrin">
            @if($user->auctions()->count() > 0)
                <div class="pf-grid">
                    @foreach($user->auctions as $auction)
                        <a href="{{ route('auctions.show', $auction) }}" class="pf-auction-card">
                            <div class="pf-card-img-wrap">
                                <img src="{{ $auction->featured_img ?? asset('assets/media/placeholder.png') }}"
                                     alt="{{ $auction->title }}">
                                <div class="pf-card-price">
                                    {{ number_format($auction->current_bid ?? $auction->start_price, 0, ',', '.') }} ₺
                                </div>
                                <div class="pf-card-badge">
                                    <span class="pf-pulse-dot"></span> Aktif
                                </div>
                            </div>
                            <div class="pf-card-body">
                                <div class="pf-card-title">{{ $auction->title }}</div>
                                <div class="pf-card-meta">
                                    <span><i class="bi bi-clock me-1"></i>2 gün</span>
                                    <span><i class="bi bi-people me-1"></i>3 teklif</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="pf-empty">
                    <div class="pf-empty-icon"><i class="bi bi-box-seam"></i></div>
                    <div class="pf-empty-title">Henüz aktif ilan yok</div>
                    <div class="pf-empty-sub">
                        @if($isOwner) İlan oluştur ve vitrininde görünsün.
                        @else Bu kullanıcı henüz ilan yayınlamamış.
                        @endif
                    </div>
                    @if($isOwner)
                        <a href="#" class="pf-btn-save mt-3 d-inline-flex align-items-center gap-1">
                            <i class="bi bi-plus-lg"></i> İlan Oluştur
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <div id="pc-degerlendirmeler" style="display:none;">
            <div class="pf-empty">
                <div class="pf-empty-icon"><i class="bi bi-star"></i></div>
                <div class="pf-empty-title">Henüz değerlendirme yok</div>
                <div class="pf-empty-sub">İlk değerlendirmeyi sen yap.</div>
            </div>
        </div>

        <div id="pc-aktivite" style="display:none;">
            <div class="pf-empty">
                <div class="pf-empty-icon"><i class="bi bi-activity"></i></div>
                <div class="pf-empty-title">Aktivite bulunamadı</div>
                <div class="pf-empty-sub">Son aktiviteler burada görünecek.</div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>

    document.querySelector('[aria-label="Paylaş"]')?.addEventListener('click', function () {
    const url = "{{ route('profile.public',$user->username) }}";
    navigator.clipboard.writeText(url).then(() => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Profil bağlantısı kopyalandı!',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            heightAuto: false,
            didOpen: () => {
                document.body.classList.remove('swal2-height-auto');
            },
        });
    }).catch(() => {
        const input = document.createElement('input');
        input.value = url;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: 'success',
            title: 'Profil bağlantısı kopyalandı!',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            heightAuto: false,
            didOpen: () => {
                document.body.classList.remove('swal2-height-auto');
            },
        });
    });
});
function toggleEdit() {
    const d = document.getElementById('editDrawer');
    const b = document.getElementById('editToggle');
    const open = d.classList.toggle('open');
    b.classList.toggle('active', open);
    b.innerHTML = open
        ? '<i class="bi bi-x-lg me-1"></i> Kapat'
        : '<i class="bi bi-pencil me-1"></i> Profili Düzenle';
    if (open) d.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function switchETab(key, btn) {
    document.querySelectorAll('.pf-etab').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');
    else {
        document.querySelectorAll('.pf-etab').forEach(b => {
            if (b.getAttribute('onclick')?.includes("'" + key + "'")) b.classList.add('active');
        });
    }
    document.querySelectorAll('.pf-epanel').forEach(p => p.classList.remove('active'));
    const panel = document.getElementById('ep-' + key);
    if (panel) panel.classList.add('active');
}

function switchPTab(key, btn) {
    document.querySelectorAll('.pf-ptab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    ['vitrin', 'degerlendirmeler', 'aktivite'].forEach(k => {
        const el = document.getElementById('pc-' + k);
        if (el) el.style.display = k === key ? '' : 'none';
    });
}

function bioCount(el) {
    const c = document.getElementById('bio_counter');
    if (c) c.textContent = el.value.length + '/300';
}

function passStrength(el) {
    const v = el.value;
    const s = [v.length >= 8, /[A-Z]/.test(v), /[0-9]/.test(v), /[^a-z0-9]/i.test(v)].filter(Boolean).length;
    const col = ['', '#ef4444', '#f59e0b', '#10b981', '#6366f1'];
    for (let i = 1; i <= 4; i++) {
        const bar = document.getElementById('pb' + i);
        if (bar) bar.style.background = i <= s ? col[s] : 'var(--border)';
    }
}

function toggleInline(id) {
    document.getElementById(id)?.classList.toggle('open');
}

document.getElementById('profile_image')?.addEventListener('change', function () {
    if (!this.files?.[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        ['heroAvatar', 'avatarPreviewSmall'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.src = e.target.result;
        });
    };
    reader.readAsDataURL(this.files[0]);
});

document.getElementById('edit_username')?.addEventListener('input', function () {
    const pos = this.selectionStart;
    this.value = this.value.toLowerCase().replace(/[^a-z0-9_.]/g, '');
    try { this.setSelectionRange(pos, pos); } catch (e) {}
});

document.addEventListener('DOMContentLoaded', () => {

    const fieldTabMap = {
        name:          'genel',
        surname:       'genel',
        username:      'genel',
        phone:         'genel',
        bio:           'genel',
        email:                'guvenlik',
        confirmemailpassword: 'guvenlik',
        currentpassword:      'guvenlik',
        password:             'guvenlik',
        password_confirmation:'guvenlik',
        'social[instagram]': 'sosyal',
        'social[twitter]':   'sosyal',
        'social[youtube]':   'sosyal',
        'social[linkedin]':  'sosyal',
    };

    const errorFields = @json($errors->keys());

    if (errorFields.length > 0) {
        const drawer = document.getElementById('editDrawer');
        const toggleBtn = document.getElementById('editToggle');
        if (drawer) drawer.classList.add('open');
        if (toggleBtn) {
            toggleBtn.classList.add('active');
            toggleBtn.innerHTML = '<i class="bi bi-x-lg me-1"></i> Kapat';
        }

        const tabOrder = ['genel', 'guvenlik', 'gizlilik', 'sosyal'];
        let targetTab = null;

        for (const tab of tabOrder) {
            if (errorFields.some(f => fieldTabMap[f] === tab)) {
                targetTab = tab;
                break;
            }
        }

        const needsEmailForm = errorFields.some(f =>
            ['email', 'confirmemailpassword'].includes(f)
        );
        const needsPassForm = errorFields.some(f =>
            ['currentpassword', 'password', 'password_confirmation'].includes(f)
        );

        if (targetTab) {
            switchETab(targetTab, null);

            if (targetTab === 'guvenlik') {
                if (needsEmailForm) document.getElementById('email-form')?.classList.add('open');
                if (needsPassForm)  document.getElementById('pass-form')?.classList.add('open');
            }
        }

        const firstErrorField = errorFields[0];
        const input = document.querySelector(
            `[name="${firstErrorField}"], [name="${firstErrorField.replace(/\./g, '[')}"]`
        );

        if (input) {
            setTimeout(() => {
                input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                input.focus({ preventScroll: true });
                input.classList.add('pf-input-error-focus');
                setTimeout(() => input.classList.remove('pf-input-error-focus'), 1000);
            }, 300);
        }

    } else {
        @if(session('profile_success'))
            const d = document.getElementById('editDrawer');
            if (d) d.classList.add('open');
            const b = document.getElementById('editToggle');
            if (b) { b.classList.add('active'); b.innerHTML = '<i class="bi bi-x-lg me-1"></i> Kapat'; }
        @endif

        @if(session('email_success') || session('password_success'))
            switchETab('guvenlik', null);
            const d2 = document.getElementById('editDrawer');
            if (d2) d2.classList.add('open');
            const b2 = document.getElementById('editToggle');
            if (b2) { b2.classList.add('active'); b2.innerHTML = '<i class="bi bi-x-lg me-1"></i> Kapat'; }
        @endif
    }
});
</script>
@endpush

@endsection
