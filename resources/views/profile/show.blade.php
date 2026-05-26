@extends('layouts.app')
@section('title', $user->name . ' — Profil')

@section('content')

<div class="container-fluid px-4 px-xl-5 py-4" style="max-width:1200px; margin:0 auto;">

    {{-- ── HERO ── --}}
    <div class="card mb-4 p-4 p-md-5" style="border-radius:20px; position:relative; overflow:hidden;">
        {{-- dekoratif glow --}}
        <div style="position:absolute;inset:0;background:radial-gradient(ellipse 55% 60% at 90% -10%, rgba(145,70,255,.15), transparent 70%);pointer-events:none;"></div>

        <div class="d-flex align-items-start gap-4 flex-wrap" style="position:relative;">

            {{-- Avatar --}}
            <div style="position:relative;flex-shrink:0;">
                <div style="width:110px;height:110px;border-radius:50%;background:conic-gradient(var(--primary),#4f46e5,var(--primary));padding:3px;">
                    <img src="{{ $user->profile_img ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=6366f1&color=fff&size=256' }}"
                         alt="{{ $user->name }}"
                         style="width:100%;height:100%;border-radius:50%;object-fit:cover;border:3px solid var(--bg-soft);">
                </div>
                @if(method_exists($user, 'isOnline') && $user->isOnline())
                    <span style="position:absolute;bottom:6px;right:6px;width:16px;height:16px;background:#10b981;border-radius:50%;border:3px solid var(--bg-soft);animation:pulse 2s infinite;"></span>
                @endif
            </div>

            {{-- Bilgiler --}}
            <div class="flex-grow-1">

                {{-- İsim + Badge --}}
                <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                    <h2 class="fw-bold mb-0" style="color:var(--text);letter-spacing:-.03em;">{{ $user->name }}</h2>
                    @php
                        $roleKey   = $user->roles->first()?->name ?? 'user';
                        $roleLabel = match($roleKey) { 'admin' => '👑 Admin', 'seller' => '🏪 Onaylı Satıcı', default => '🛍️ Üye' };
                        $roleStyle = match($roleKey) {
                            'admin'  => 'background:rgba(248,113,113,.15);color:#f87171;border:1px solid rgba(248,113,113,.3);',
                            'seller' => 'background:rgba(145,70,255,.15);color:var(--primary);border:1px solid rgba(145,70,255,.3);',
                            default  => 'background:var(--card);color:var(--muted);border:1px solid var(--border);',
                        };
                    @endphp
                    <span style="font-size:.7rem;font-weight:700;padding:.25rem .75rem;border-radius:99px;{{ $roleStyle }}">{{ $roleLabel }}</span>
                </div>

                <p style="color:var(--muted);font-size:.9rem;margin-bottom:.4rem;max-width:520px;">
                    {{ $user->bio ?? 'Koleksiyon parçaları ve güvenli açık artırmanın adresi.' }}
                </p>
                <small style="color:var(--muted);font-size:.72rem;">
                    <i class="bi bi-calendar3 me-1"></i>{{ $user->created_at->format('M Y') }} tarihinden beri üye
                </small>

                {{-- Stats --}}
                <div class="d-flex gap-4 align-items-center my-3">
                    <div>
                        <div style="font-size:1.4rem;font-weight:800;color:var(--text);line-height:1;">{{ $user->auctions()->count() }}</div>
                        <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.07em;font-weight:700;color:var(--muted);">İlan</div>
                    </div>
                    <div style="width:1px;height:28px;background:var(--border);"></div>
                    <div>
                        <div style="font-size:1.4rem;font-weight:800;color:var(--text);line-height:1;">0</div>
                        <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.07em;font-weight:700;color:var(--muted);">Teklif</div>
                    </div>
                    <div style="width:1px;height:28px;background:var(--border);"></div>
                    <div>
                        <div style="font-size:1.4rem;font-weight:800;color:var(--text);line-height:1;">0</div>
                        <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.07em;font-weight:700;color:var(--muted);">Takipçi</div>
                    </div>
                </div>

                {{-- Butonlar --}}
                <div class="d-flex gap-2 flex-wrap">
                    @if(auth()->check() && auth()->id() !== $user->id)
                        <button class="btn-header-register" style="height:36px;padding:0 18px;border-radius:10px;font-size:.85rem;">
                            <i class="bi bi-person-plus me-1"></i> Takip Et
                        </button>
                        <button class="btn-header-login" style="height:36px;padding:0 18px;border-radius:10px;font-size:.85rem;">
                            <i class="bi bi-chat-dots me-1"></i> Mesaj
                        </button>
                    @elseif(auth()->id() === $user->id)
                        <button class="btn-header-login" style="height:36px;padding:0 18px;border-radius:10px;font-size:.85rem;">
                            <i class="bi bi-pencil me-1"></i> Profili Düzenle
                        </button>
                        <button class="btn-header-login" style="height:36px;padding:0 14px;border-radius:10px;font-size:.85rem;">
                            <i class="bi bi-share"></i>
                        </button>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- ── TABS ── --}}
    <div class="d-flex gap-1 p-1 mb-4" style="background:var(--card);border:1px solid var(--border);border-radius:14px;position:relative;">
        <button onclick="switchTab('posts',this)"   class="pf-tab pf-tab-active" id="tab-posts">
            <i class="bi bi-grid-3x3-gap-fill me-1"></i> Vitrin
        </button>
        <button onclick="switchTab('reviews',this)" class="pf-tab" id="tab-reviews">
            <i class="bi bi-star me-1"></i> Değerlendirmeler
        </button>
        <button onclick="switchTab('activity',this)" class="pf-tab" id="tab-activity">
            <i class="bi bi-activity me-1"></i> Aktivite
        </button>
    </div>

    {{-- ── TAB PANELLERİ ── --}}
    <div id="panel-posts">
        @if($user->auctions()->count() > 0)
            <div class="row g-3 row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-xl-5">
                @foreach($user->auctions as $auction)
                    <div class="col">
                        <a href="#" class="auction-card d-flex flex-column text-decoration-none" style="border-radius:14px;overflow:hidden;background:var(--card);border:1px solid var(--border);transition:transform .22s,border-color .22s;color:var(--text);"
                           onmouseenter="this.style.transform='translateY(-4px)';this.style.borderColor='rgba(145,70,255,.4)'"
                           onmouseleave="this.style.transform='';this.style.borderColor='var(--border)'">
                            <div style="position:relative;aspect-ratio:1;overflow:hidden;background:var(--bg-soft);">
                                <img src="{{ $auction->featured_img ?? asset('assets/media/placeholder.png') }}"
                                     style="width:100%;height:100%;object-fit:cover;transition:transform .4s;"
                                     onmouseenter="this.style.transform='scale(1.06)'"
                                     onmouseleave="this.style.transform=''"
                                     alt="{{ $auction->title }}">
                                <div style="position:absolute;bottom:.5rem;left:.5rem;background:rgba(0,0,0,.7);backdrop-filter:blur(6px);color:#fff;font-size:.72rem;font-weight:700;padding:.2rem .55rem;border-radius:8px;">
                                    {{ number_format($auction->current_bid ?? $auction->start_price, 0, ',', '.') }} ₺
                                </div>
                                <div style="position:absolute;top:.5rem;right:.5rem;background:rgba(16,185,129,.15);border:1px solid rgba(16,185,129,.35);color:#10b981;font-size:.6rem;font-weight:700;padding:.18rem .5rem;border-radius:6px;display:flex;align-items:center;gap:4px;text-transform:uppercase;letter-spacing:.04em;">
                                    <span style="width:5px;height:5px;background:#10b981;border-radius:50%;animation:pulse 2s infinite;"></span> Aktif
                                </div>
                            </div>
                            <div style="padding:.75rem;">
                                <div style="font-size:.82rem;font-weight:600;color:var(--text);overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;line-height:1.4;margin-bottom:.5rem;">{{ $auction->title }}</div>
                                <div class="d-flex justify-content-between align-items-center" style="font-size:.7rem;color:var(--muted);">
                                    <span style="color:#f59e0b;font-weight:600;"><i class="bi bi-clock me-1"></i>2 gün</span>
                                    <span><i class="bi bi-people me-1"></i>3 teklif</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card text-center py-5" style="border-radius:18px;border-style:dashed;">
                <div style="width:56px;height:56px;border-radius:50%;background:rgba(145,70,255,.12);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:1.4rem;color:var(--primary);">
                    <i class="bi bi-box-seam"></i>
                </div>
                <h5 style="font-weight:700;color:var(--text);margin-bottom:.3rem;">Henüz aktif ilan yok</h5>
                <p style="color:var(--muted);font-size:.85rem;margin-bottom:1.25rem;">Bu kullanıcı henüz ilan yayınlamamış.</p>
                @if(auth()->id() === $user->id)
                    <div><a href="#" class="btn-header-register" style="height:36px;padding:0 18px;border-radius:10px;font-size:.85rem;display:inline-flex;align-items:center;">
                        <i class="bi bi-plus-lg me-1"></i> İlan Oluştur
                    </a></div>
                @endif
            </div>
        @endif
    </div>

    <div id="panel-reviews" style="display:none;">
        <div class="card text-center py-5" style="border-radius:18px;border-style:dashed;">
            <div style="width:56px;height:56px;border-radius:50%;background:rgba(145,70,255,.12);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:1.4rem;color:var(--primary);">
                <i class="bi bi-star"></i>
            </div>
            <h5 style="font-weight:700;color:var(--text);margin-bottom:.3rem;">Henüz değerlendirme yok</h5>
            <p style="color:var(--muted);font-size:.85rem;margin:0;">İlk değerlendirmeyi sen yap.</p>
        </div>
    </div>

    <div id="panel-activity" style="display:none;">
        <div class="card text-center py-5" style="border-radius:18px;border-style:dashed;">
            <div style="width:56px;height:56px;border-radius:50%;background:rgba(145,70,255,.12);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:1.4rem;color:var(--primary);">
                <i class="bi bi-activity"></i>
            </div>
            <h5 style="font-weight:700;color:var(--text);margin-bottom:.3rem;">Aktivite bulunamadı</h5>
            <p style="color:var(--muted);font-size:.85rem;margin:0;">Son aktiviteler burada görünecek.</p>
        </div>
    </div>

</div>

<style>
@keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.6)} }

.pf-tab {
    flex:1; padding:.55rem 1rem; border:none; background:transparent;
    border-radius:10px; font-size:.8rem; font-weight:600; cursor:pointer;
    color:var(--muted); transition:all .2s; text-align:center;
}
.pf-tab.pf-tab-active {
    background:var(--bg-soft); color:var(--text);
    box-shadow:0 1px 4px rgba(0,0,0,.15);
}
.pf-tab:hover:not(.pf-tab-active) { color:var(--text); }
</style>

<script>
const panels = { posts:'panel-posts', reviews:'panel-reviews', activity:'panel-activity' };
function switchTab(key, btn) {
    document.querySelectorAll('.pf-tab').forEach(b => b.classList.remove('pf-tab-active'));
    btn.classList.add('pf-tab-active');
    Object.values(panels).forEach(id => document.getElementById(id).style.display = 'none');
    document.getElementById(panels[key]).style.display = '';
}
</script>

@endsection
