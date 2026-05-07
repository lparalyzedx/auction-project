<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="280px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    <div class="px-6 py-5 d-flex align-items-center gap-3" style="border-bottom:1px solid rgba(255,255,255,0.06);">

        <div class="symbol symbol-35px">
            <div class="symbol-label bg-primary text-white fw-bold">M</div>
        </div>

        <div>
            <div class="text-white fw-bold fs-6">MÜZAYEDE</div>
            <div class="text-muted fs-8">live auction</div>
        </div>
    </div>

    <div class="px-3 py-3" style="height:calc(100vh - 160px); overflow:hidden;">

        <a href="/" class="sidebar-link active">
            <i class="bi bi-house"></i> Ana Sayfa
        </a>

        <a href="/auctions" class="sidebar-link">
            <i class="bi bi-tag"></i> Müzayedeler
        </a>

        <a href="/live" class="sidebar-link">
            <i class="bi bi-broadcast"></i> Canlı Açık Artırma
        </a>

        <a href="/explore" class="sidebar-link">
            <i class="bi bi-compass"></i> Keşfet
        </a>

        <div class="sidebar-title">Hesabım</div>

        <a href="/dashboard" class="sidebar-link">
            <i class="bi bi-grid"></i> Dashboard
        </a>

        <a href="/my-bids" class="sidebar-link">
            <i class="bi bi-graph-up"></i> Tekliflerim
        </a>

        <a href="/favorites" class="sidebar-link">
            <i class="bi bi-heart"></i> Favoriler
        </a>

        <a href="/notifications" class="sidebar-link">
            <i class="bi bi-bell"></i> Bildirimler
        </a>

        <div class="sidebar-title">Profil</div>

        <a href="/profile" class="sidebar-link">
            <i class="bi bi-person"></i> Profilim
        </a>

        <a href="/profile/edit" class="sidebar-link">
            <i class="bi bi-gear"></i> Ayarlar
        </a>

    </div>
    @auth
    <div class="px-6 py-3 sidebar-user dropdown">

        <div class="d-flex align-items-center gap-3" data-bs-toggle="dropdown" style="cursor:pointer;">

           <div class="symbol symbol-50px me-5">
    @if(auth()->user()->avatar)
        <img
            src="{{ asset('storage/'.auth()->user()->avatar) }}"
            alt="{{ auth()->user()->name }}"
            class="object-fit-cover"
        >
    @else
        <div class="symbol-label bg-primary text-white fw-bold">
            {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
        </div>
    @endif
</div>

            <div class="flex-grow-1">
                <div class="text-white fs-7 fw-semibold">
                    {{ auth()->user()->name }}
                </div>
                <div class="text-muted fs-8">
                    {{ auth()->user()->email }}
                </div>
            </div>

            <i class="bi bi-chevron-down text-muted"></i>
        </div>

        <ul class="dropdown-menu sidebar-dropdown dropdown-menu-end shadow">

            <li class="sidebar-dropdown-header">
                <div class="name">{{ auth()->user()->name }}</div>
                <div class="email">{{ auth()->user()->email }}</div>
            </li>

            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <a class="dropdown-item" href="/profile">
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
                <a class="dropdown-item" href="/my-bids">
                    <i class="bi bi-graph-up"></i>
                    Tekliflerim
                </a>
            </li>

            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <form method="POST" action="{{route('logout')}}">
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
