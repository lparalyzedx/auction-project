<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="280px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    {{-- LOGO --}}
    <div class="px-6 py-5 d-flex align-items-center gap-3" style="border-bottom:1px solid rgba(255,255,255,0.06);">

        <div class="symbol symbol-35px">
            <div class="symbol-label bg-primary text-white fw-bold">
                M
            </div>
        </div>

        <div>
            <div class="text-white fw-bold fs-6">
                MÜZAYEDE
            </div>
            <div class="text-muted fs-8">
                live auction
            </div>
        </div>

    </div>

    {{-- MENU --}}
    <div class="px-3 py-3" style="height:calc(100vh - 160px); overflow-y:auto;">

        {{-- GENEL --}}
        <a href="/" class="sidebar-link {{ request()->is('/') ? 'active' : '' }}">
            <i class="bi bi-house"></i>
            Ana Sayfa
        </a>

        <a href="/auctions" class="sidebar-link">
            <i class="bi bi-tag"></i>
            Müzayedeler
        </a>

        <a href="/live" class="sidebar-link">
            <i class="bi bi-broadcast"></i>
            Canlı Açık Artırma
        </a>

        <a href="/explore" class="sidebar-link">
            <i class="bi bi-compass"></i>
            Keşfet
        </a>

        @auth

            @role('admin')
                <div class="sidebar-title">
                    Admin Paneli
                </div>

                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>

                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    Kullanıcılar
                </a>

                <a href="#" class="sidebar-link">
                    <i class="bi bi-hammer"></i>
                    Müzayede Yönetimi
                </a>

                <a href="#" class="sidebar-link">
                    <i class="bi bi-shield-check"></i>
                    Onay Bekleyenler
                </a>
            @endrole


            @role('seller')
                <div class="sidebar-title">
                    Satıcı Paneli
                </div>

                <a href="/seller/dashboard" class="sidebar-link">
                    <i class="bi bi-grid"></i>
                    Panel
                </a>

                <a href="/seller/auctions" class="sidebar-link">
                    <i class="bi bi-hammer"></i>
                    İlanlarım
                </a>

                <a href="/seller/create" class="sidebar-link">
                    <i class="bi bi-plus-circle"></i>
                    İlan Oluştur
                </a>
            @endrole


            @role('buyer')
                <div class="sidebar-title">
                    Hesabım
                </div>

                <a href="/dashboard" class="sidebar-link">
                    <i class="bi bi-grid"></i>
                    Dashboard
                </a>

                <a href="/my-bids" class="sidebar-link">
                    <i class="bi bi-graph-up"></i>
                    Tekliflerim
                </a>

                <a href="/favorites" class="sidebar-link">
                    <i class="bi bi-heart"></i>
                    Favoriler
                </a>

                <a href="/notifications" class="sidebar-link">
                    <i class="bi bi-bell"></i>
                    Bildirimler
                </a>
            @endrole


            <div class="sidebar-title">
                Profil
            </div>

            <a href="{{route('profile.edit')}}" class="sidebar-link {{ request()->is('profile') ? 'active' : '' }}">
                <i class="bi bi-person"></i>
                Profilim
            </a>

            <a href="/profile/edit" class="sidebar-link">
                <i class="bi bi-gear"></i>
                Ayarlar
            </a>

        @endauth

    </div>

    {{-- USER --}}
    @auth

        <div class="px-6 py-3 sidebar-user dropdown">

            <div class="d-flex align-items-center gap-3" data-bs-toggle="dropdown" style="cursor:pointer;">

                <div class="symbol symbol-35px">

                    @if (auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}"
                            class="rounded object-fit-cover">
                    @else
                        <div class="symbol-label bg-primary text-white fw-bold">
                            {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif

                </div>

                <div class="flex-grow-1 overflow-hidden">

                    <div class="text-white fs-7 fw-semibold text-truncate">
                        {{ auth()->user()->name }}
                    </div>

                    <div class="text-muted fs-8 text-truncate">
                        {{ auth()->user()->email }}
                    </div>

                </div>

                <i class="bi bi-chevron-down text-muted"></i>

            </div>

            <ul class="dropdown-menu sidebar-dropdown dropdown-menu-end shadow">

                <li class="sidebar-dropdown-header">
                    <div class="name">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="email">
                        {{ auth()->user()->email }}
                    </div>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a class="dropdown-item" href="{{route('profile.edit')}}">
                        <i class="bi bi-person"></i>
                        Profilim
                    </a>
                </li>

                <li>
                    <a class="dropdown-item" href="/profile/edit">
                        <i class="bi bi-gear"></i>
                        Ayarlar
                    </a>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right"></i>
                            Çıkış Yap
                        </button>
                    </form>
                </li>

            </ul>

        </div>

    @endauth

</div>