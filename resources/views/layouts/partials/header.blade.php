<div id="kt_app_header" class="app-header modern-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}">

    <div class="app-container container-xxl d-flex align-items-center justify-content-between" style="gap:8px; padding-left:12px; padding-right:12px;">

        <div class="d-flex align-items-center d-lg-none">
            <div class="btn modern-icon" id="kt_app_sidebar_mobile_toggle">
                <i class="bi bi-list fs-3"></i>
            </div>
        </div>

        <div class="d-flex align-items-center mhdr-search-wrap position-relative">
            <div class="search-box position-relative">
                <i class="bi bi-search search-icon"></i>
                <input type="text" id="mhdr-input" class="form-control search-input" name="q" placeholder="Müzayede, ilan veya kullanıcı ara..." value="{{ request()->get('q', '') }}" autocomplete="off">
                <div id="search-results" class="mhdr-search-results d-none"></div>

            </div>
        </div>

        <div class="d-flex align-items-center" style="gap:4px; flex-shrink:0;">

            <button class="btn modern-icon" id="themeToggle">
                <i class="bi bi-moon fs-5"></i>
            </button>

            @auth
            @role('seller')
            <a href="{{ route('seller.auctions.create') }}" class="btn btn-primary btn-sm modern-btn d-none d-lg-inline-flex align-items-center">
                <i class="bi bi-plus-lg me-1 d-flex"></i>
                <span>İlan Ver</span>
            </a>
            <a href="{{ route('seller.auctions.create') }}" class="btn modern-icon d-flex d-lg-none" style="color:#7F77DD">
                <i class="bi bi-plus-lg fs-5"></i>
            </a>
            @endrole

            @auth
            <div class="d-flex align-items-center gap-2 me-1">

                <a href="{{ route('general.balance.index') }}" class="balance-pill d-none d-md-flex align-items-center">
                    <i class="bi bi-wallet2 me-1"></i>
                    <span>{{ number_format(auth()->user()->balance ?? 0, 2, ',', '.') }} ₺</span>
                </a>

                <a href="{{ route('general.balance.index') }}" class="btn modern-icon d-flex d-md-none" title="Bakiye Yükle">
                    <i class="bi bi-wallet2 fs-5"></i>
                </a>

            </div>
            @endauth

            <div class="dropdown">
                <button class="btn modern-icon position-relative" data-bs-toggle="dropdown" id="notifToggle">
                    <i class="bi bi-bell fs-5"></i>
                    @auth
                    @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="notif-dot"></span>
                    @endif
                    @endauth
                </button>

                <div class="dropdown-menu dropdown-menu-end modern-dropdown" style="width:340px; padding:0;">

                    <div class="user-box fw-semibold d-flex align-items-center justify-content-between">
                        <span>Bildirimler</span>
                        <a href="{{ route('notifications.index') }}" class="fs-8 text-muted text-decoration-none">
                            Tümünü gör
                        </a>
                    </div>

                    @auth
                    @php
                    $headerNotifs = auth()->user()->notifications()->latest()->take(6)->get();
                    @endphp

                    @if($headerNotifs->isEmpty())
                    <div class="text-center text-muted py-4" style="font-size:12px;">
                        <i class="bi bi-bell-slash d-block mb-2 opacity-50 fs-5"></i>
                        Yeni bildirim yok
                    </div>
                    @else
                    <div style="max-height:340px; overflow-y:auto;">
                        @foreach($headerNotifs as $notif)
                        @php
                        $data = $notif->data;
                        $type = $data['type'] ?? 'follow';
                        $unread = is_null($notif->read_at);

                        $meta = match($type) {
                        'follow' => ['bi-person-plus-fill', '#7F77DD'],
                        'new_bid' => ['bi-currency-lira', '#10b981'],
                        'auction_approved' => ['bi-check-circle-fill', '#22c55e'],
                        'auction_rejected' => ['bi-x-circle-fill', '#ef4444'],
                        'auction_ended' => ['bi-flag-fill', '#6b7280'],
                        'buy_now' => ['bi-lightning-fill', '#f59e0b'],
                        default => ['bi-bell-fill', '#7F77DD'],
                        };
                        [$icon, $color] = $meta;

                        $avatarName = $data['follower_name'] ?? $data['bidder_name'] ?? $data['buyer_name'] ?? null;
                        $avatarImg = $data['follower_avatar'] ?? $data['bidder_avatar'] ?? $data['buyer_avatar'] ?? null;
                        $avatarUser = $data['follower_username'] ?? $data['bidder_username'] ?? $data['buyer_username'] ?? null;

                        $link = match($type) {
                        'follow' => $avatarUser ? route('profile.public', $avatarUser) : '#',
                        'new_bid','auction_approved','auction_rejected',
                        'auction_ended','buy_now' => isset($data['auction_slug']) ? route('seller.auctions.show', $data['auction_slug']) : '#',
                        default => '#',
                        };
                        @endphp

                        <a href="{{ $link }}" class="dropdown-item d-flex align-items-center gap-2 py-2 px-3" style="white-space:normal; background: {{ $unread ? '#7F77DD0a' : 'transparent' }};">

                            <div style="position:relative; width:34px; height:34px; flex-shrink:0;">
                                @if($avatarImg)
                                <img src="{{ $avatarImg }}" style="width:34px;height:34px;border-radius:50%;object-fit:cover;" alt="">
                                @elseif($avatarName)
                                <div style="width:34px;height:34px;border-radius:50%;background:#7F77DD;
                                            color:#fff;font-weight:700;font-size:13px;
                                            display:flex;align-items:center;justify-content:center;">
                                    {{ strtoupper(mb_substr($avatarName, 0, 1)) }}
                                </div>
                                @else
                                <div style="width:34px;height:34px;border-radius:50%;background:{{ $color }}22;
                                            color:{{ $color }};font-size:14px;
                                            display:flex;align-items:center;justify-content:center;">
                                    <i class="bi {{ $icon }}"></i>
                                </div>
                                @endif

                                <div style="position:absolute;bottom:-2px;right:-3px;
                                        width:16px;height:16px;border-radius:50%;
                                        background:{{ $color }};border:2px solid var(--search-bg);
                                        display:flex;align-items:center;justify-content:center;">
                                    <i class="bi {{ $icon }}" style="font-size:7px;color:#fff;"></i>
                                </div>
                            </div>

                            <div style="flex:1;min-width:0;">
                                <div style="font-size:12.5px; {{ $unread ? 'font-weight:600;' : '' }} color:var(--search-text-main); line-height:1.35;">
                                    {{ $data['message'] }}
                                </div>
                                <div style="font-size:11px;color:var(--search-text-muted);margin-top:2px;">
                                    {{ $notif->created_at->diffForHumans() }}
                                </div>
                            </div>

                            @if($unread)
                            <div style="width:7px;height:7px;border-radius:50%;background:#7F77DD;flex-shrink:0;"></div>
                            @endif
                        </a>
                        @endforeach
                    </div>

                    <div class="px-3 py-2 border-top" style="border-color:var(--search-border)!important;">
                        <a href="{{ route('notifications.index') }}" class="d-block text-center text-decoration-none" style="font-size:12px;color:var(--search-text-muted);">
                            Tüm bildirimleri gör
                        </a>
                    </div>
                    @endif
                    @endauth

                </div>
            </div>

            <div class="dropdown">
                <a class="d-flex align-items-center justify-content-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="width:36px; height:36px; border-radius:50%; overflow:hidden; cursor:pointer; flex-shrink:0;">
                    @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" style="width:36px; height:36px; object-fit:cover;">
                    @else
                    <div class="bg-primary text-white fw-bold d-flex align-items-center justify-content-center w-100 h-100">
                        {{ strtoupper(mb_substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end modern-dropdown">
                    <div class="user-box">
                        <div class="fw-bold">{{ auth()->user()->name }}</div>
                        <div class="text-muted fs-8">{{ auth()->user()->email }}</div>
                    </div>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a>
                    <a class="dropdown-item" href="{{ route('seller.auctions.index') }}">İlanlarım</a>
                    <a class="dropdown-item" href="/my-bids">Tekliflerim</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item">Çıkış Yap</button>
                    </form>
                </div>
            </div>

            @else
            <div class="mhdr-divider d-none d-sm-block"></div>
            <a href="/login" class="btn btn-light btn-sm">Giriş</a>
            <a href="/register" class="btn btn-primary btn-sm">Kayıt</a>
            @endauth

        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const btn = document.getElementById("themeToggle");
        const body = document.body;
        let theme = localStorage.getItem("theme") || "dark";
        localStorage.setItem("theme", theme);
        body.classList.add(theme + "-mode");
        updateIcon();

        btn.addEventListener("click", function() {
            const isDark = body.classList.contains("dark-mode");
            body.classList.toggle("dark-mode", !isDark);
            body.classList.toggle("light-mode", isDark);
            localStorage.setItem("theme", isDark ? "light" : "dark");
            updateIcon();
        });

        function updateIcon() {
            const isDark = body.classList.contains("dark-mode");
            btn.innerHTML = isDark ?
                '<i class="bi bi-moon fs-5"></i>' :
                '<i class="bi bi-sun fs-5"></i>';
        }

        const searchInput = document.getElementById('mhdr-input');
        const resultsBox = document.getElementById('search-results');
        const RECENT_KEY = 'mhdr_recent_searches';
        const MAX_RECENT = 6;

        let debounceTimeout;
        const queryCache = {};

        const urlParams = new URLSearchParams(window.location.search);
        const qParam = urlParams.get('q');
        if (qParam) searchInput.value = qParam;

        function getRecent() {
            try {
                return JSON.parse(localStorage.getItem(RECENT_KEY)) || [];
            } catch {
                return [];
            }
        }

        function saveRecent(query) {
            let list = getRecent().filter(q => q !== query);
            list.unshift(query);
            list = list.slice(0, MAX_RECENT);
            localStorage.setItem(RECENT_KEY, JSON.stringify(list));
        }

        function clearRecent() {
            localStorage.removeItem(RECENT_KEY);
        }

        function showRecentSearches() {
            const list = getRecent();
            if (!list.length) return;

            resultsBox.innerHTML = '';
            const header = document.createElement('div');
            header.className = 'search-recent-header';
            header.textContent = 'Son Aramalar';
            resultsBox.appendChild(header);

            list.forEach(q => {
                const item = document.createElement('div');
                item.className = 'search-recent-item';
                item.innerHTML = `
                <i class="bi bi-clock-history search-recent-icon"></i>
                <span style="flex:1">${escapeHtml(q)}</span>
                <i class="bi bi-chevron-right" style="font-size:10px;opacity:0.3"></i>
            `;
                item.addEventListener('mousedown', (e) => {
                    e.preventDefault();
                    searchInput.value = q;
                    resultsBox.classList.add('d-none');
                    triggerSearch(q);
                });
                resultsBox.appendChild(item);
            });

            const clearBtn = document.createElement('div');
            clearBtn.className = 'search-recent-clear';
            clearBtn.textContent = 'Temizle';
            clearBtn.addEventListener('mousedown', (e) => {
                e.preventDefault();
                clearRecent();
                resultsBox.classList.add('d-none');
            });
            resultsBox.appendChild(clearBtn);
            resultsBox.classList.remove('d-none');
        }

        function escapeHtml(str) {
            return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        }

        searchInput.addEventListener('focus', function() {
            if (!this.value.trim()) showRecentSearches();
        });

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimeout);
            const query = this.value.trim();

            if (!query) {
                showRecentSearches();
                return;
            }

            if (queryCache[query]) {
                renderResults(queryCache[query]);
                return;
            }

            debounceTimeout = setTimeout(() => triggerSearch(query), 80);
        });

        function triggerSearch(query) {
            if (queryCache[query]) {
                renderResults(queryCache[query]);
                return;
            }

            fetch(`/live-search?q=${encodeURIComponent(query)}`)
                .then(r => r.json())
                .then(data => {
                    queryCache[query] = data;
                    renderResults(data);
                })
                .catch(err => console.error('Arama hatası:', err));
        }

        function renderResults(data) {
            resultsBox.innerHTML = '';

            if (!data.length) {
                resultsBox.innerHTML = '<div class="search-no-result">Sonuç bulunamadı.</div>';
                resultsBox.classList.remove('d-none');
                return;
            }

            data.forEach(item => {
                const a = document.createElement('a');
                a.href = item.url;
                a.className = 'search-result-item';
                a.innerHTML = `
                <div class="search-result-avatar">
                    <img src="${item.avatar}" alt="${item.title}">
                </div>
                <div class="search-result-info">
                    <span class="search-result-title">${item.title}</span>
                    <span class="search-result-badge">${item.username}</span>
                </div>
                <div class="search-result-arrow"><i class="bi bi-chevron-right"></i></div>
            `;

                a.addEventListener('click', () => {
                    saveRecent(item.title);
                });

                resultsBox.appendChild(a);
            });

            resultsBox.classList.remove('d-none');
        }

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
                resultsBox.classList.add('d-none');
            }
        });
    });

</script>

<script>
    document.getElementById('notifToggle') ? .addEventListener('click', function() {
        fetch('/notifications/read-all', {
            method: 'POST'
            , headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                , 'Accept': 'application/json'
            , }
        }).then(() => {
            this.querySelector('.notif-dot') ? .remove();
        });
    });

</script>
