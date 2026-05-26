@extends('auth.layouts.master')

@section('content')
    <div class="text-center w-100 auth-form">

        <div class="mb-6">
            <img
                src="{{ asset('assets/media/logos/logo-light.svg') }}"
                class="logo-light auth-logo"
                alt="Artirdim"
            >
            <img
                src="{{ asset('assets/media/logos/logo-dark.svg') }}"
                class="logo-dark auth-logo"
                alt="Artirdim"
            >
        </div>

        <div class="error-code-wrapper mb-2">
            <h1 class="fw-bolder" style="font-size: 110px; line-height: 0.95; letter-spacing: -4px; background: linear-gradient(90deg, #9146ff 0%, #00f2fe 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                404
            </h1>
        </div>

        <h2 class="fw-bold fs-2 mb-3 text-main">
            Sayfa Bulunamadı
        </h2>

        <p class="text-muted fs-6 mb-10 mx-auto" style="max-width: 380px; line-height: 1.6;">
            Aradığınız sayfa kaldırılmış, adresi değiştirilmiş veya geçici olarak kullanım dışı bırakılmış olabilir.
        </p>

        <div class="d-grid mb-4">
            <a href="{{ auth()->check() ? route('admin.dashboard') : url('/') }}" class="btn btn-auth-primary btn-lg text-decoration-none">
                Ana Sayfaya Dön
            </a>
        </div>

        <div class="d-grid">
            <a href="javascript:history.back()" class="btn btn-auth-outline btn-lg text-decoration-none">
                Geri Dön
            </a>
        </div>

    </div>
@endsection
