<!DOCTYPE html>
<html lang="tr" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — @yield('title', 'Müzayede')</title>

    <link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script>
        (function() {
            const theme = localStorage.getItem("theme") || "dark";
            document.documentElement.classList.add(theme + "-mode");
        })();

        document.addEventListener("DOMContentLoaded", function() {

            const btn = document.getElementById("themeToggle");

            function setTheme(mode) {
                document.documentElement.classList.remove("light-mode", "dark-mode");
                document.documentElement.classList.add(mode + "-mode");
                localStorage.setItem("theme", mode);
            }

            let theme = localStorage.getItem("theme") || "dark";
            setTheme(theme);

            function updateIcon() {
                btn.innerHTML = document.documentElement.classList.contains("dark-mode") ?
                    '<i class="bi bi-moon fs-5"></i>' :
                    '<i class="bi bi-sun fs-5"></i>';
            }

            updateIcon();

            btn.addEventListener("click", function() {
                const isDark = document.documentElement.classList.contains("dark-mode");
                setTheme(isDark ? "light" : "dark");
                updateIcon();
            });

        });
    </script>


    @stack('styles')
</head>

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true">
    
    <div class="loading">
    <svg width="48" height="48" viewBox="0 0 48 48">
        <g fill="none">
            <path fill="#9146ff"
                d="M24,48 C10.7,48 0,37.2 0,24 C0,10.7 10.7,0 24,0 C37.2,0 48,10.7 48,24 C48,37.2 37.2,48 24,48 Z"/>
        </g>
    </svg>
</div>

    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">

            @include('layouts.partials.header')

            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">

                @include('layouts.partials.sidebar')

                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <div class="d-flex flex-column flex-column-fluid">
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-xxl">

                                @if (session('success'))
                                    <div class="alert alert-success d-flex align-items-center p-5 mt-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        <div class="d-flex flex-column">
                                            <span>{{ session('success') }}</span>
                                        </div>
                                        <button type="button"
                                            class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                                            data-bs-dismiss="alert">
                                            <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span
                                                    class="path2"></span></i>
                                        </button>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger d-flex align-items-center p-5 mt-5">
                                        <i class="ki-duotone ki-cross-circle fs-2hx text-danger me-4">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        <div class="d-flex flex-column">
                                            <span>{{ session('error') }}</span>
                                        </div>
                                        <button type="button"
                                            class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                                            data-bs-dismiss="alert">
                                            <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span
                                                    class="path2"></span></i>
                                        </button>
                                    </div>
                                @endif

                                @yield('content')

                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div id="kt_app_footer" class="app-footer">
                        <div
                            class="app-container container-xxl d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                            <div class="text-dark order-2 order-md-1">
                                <span class="text-muted fw-semibold me-1">{{ date('Y') }} &copy;</span>
                                <a href="#" class="text-gray-800 text-hover-primary">Müzayede</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    @stack('scripts')
</body>

</html>
