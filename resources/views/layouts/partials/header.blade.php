<div id="kt_app_header" class="app-header modern-header"
     data-kt-sticky="true"
     data-kt-sticky-activate="{default: true, lg: true}">

    <div class="app-container container-xxl d-flex align-items-center justify-content-between">

        {{-- MOBILE SIDEBAR --}}
        <div class="d-flex align-items-center d-lg-none gap-2">

            <div class="btn modern-icon"
                 id="kt_app_sidebar_mobile_toggle">
                <i class="bi bi-list fs-3"></i>
            </div>

        </div>

        {{-- SEARCH --}}
        <div class="d-flex align-items-center flex-grow-1">
            <div class="search-box position-relative">
                <i class="bi bi-search search-icon"></i>

                <input type="text"
                       class="form-control search-input"
                       placeholder="Müzayede, ilan veya kullanıcı ara...">
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="d-flex align-items-center gap-2">

            {{-- THEME TOGGLE (YENİ) --}}
            <button class="btn modern-icon" id="themeToggle">
                <i class="bi bi-moon fs-5"></i>
            </button>

            @auth

            {{-- CREATE --}}
            <a href="#create-auction" class="btn btn-primary btn-sm modern-btn">
                <i class="bi bi-plus-lg me-1"></i>
                İlan Ver
            </a>

            {{-- NOTIFICATIONS --}}
            <div class="dropdown">
                <button class="btn modern-icon position-relative"
                        data-bs-toggle="dropdown">

                    <i class="bi bi-bell fs-5"></i>
                    <span class="notif-dot"></span>

                </button>

                <div class="dropdown-menu dropdown-menu-end modern-dropdown">

                    <div class="user-box fw-semibold">
                        Bildirimler
                    </div>

                    <div class="text-center text-muted py-4">
                        Yeni bildirim yok
                    </div>

                </div>
            </div>

            {{-- USER --}}
            <div class="dropdown">

                <div class="modern-icon"
                     data-bs-toggle="dropdown"
                     style="cursor:pointer; width:38px;height:38px;">

                    <div class="bg-primary text-white w-100 h-100 d-flex align-items-center justify-content-center rounded">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U',0,1)) }}
                    </div>

                </div>

                <div class="dropdown-menu dropdown-menu-end modern-dropdown">

                    <div class="user-box">
                        <div class="fw-bold">{{ auth()->user()->name }}</div>
                        <div class="text-muted fs-8">{{ auth()->user()->email }}</div>
                    </div>

                    <a class="dropdown-item" href="/profile">Profil</a>
                    <a class="dropdown-item" href="/profile/edit">Profil Düzenle</a>
                    <a class="dropdown-item" href="/my-listings">İlanlarım</a>
                    <a class="dropdown-item" href="/my-bids">Tekliflerim</a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item text-danger" href="/logout">
                        Çıkış Yap
                    </a>

                </div>
            </div>

            @else

            <a href="/login" class="btn btn-light btn-sm">Giriş</a>
            <a href="/register" class="btn btn-primary btn-sm">Kayıt</a>

            @endauth

        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const btn = document.getElementById("themeToggle");
    const body = document.body;

    let theme = localStorage.getItem("theme");

    if (!theme) {
        theme = "dark";
        localStorage.setItem("theme", "dark");
    }

    body.classList.add(theme + "-mode");

    function updateIcon() {
        const isDark = body.classList.contains("dark-mode");

        btn.innerHTML = isDark
            ? '<i class="bi bi-moon fs-5"></i>'
            : '<i class="bi bi-sun fs-5"></i>';
    }

    updateIcon();

    btn.addEventListener("click", function () {

        if (body.classList.contains("dark-mode")) {
            body.classList.remove("dark-mode");
            body.classList.add("light-mode");
            localStorage.setItem("theme", "light");
        } else {
            body.classList.remove("light-mode");
            body.classList.add("dark-mode");
            localStorage.setItem("theme", "dark");
        }

        updateIcon();
    });

});
</script>