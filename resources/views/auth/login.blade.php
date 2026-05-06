@extends('auth.layouts.master')

@section('content')
    <form class="form w-100 auth-form" method="post" action="{{ route('login') }}">
        @csrf

        <div class="text-center mb-10">

            <div class="badge bg-primary px-4 py-2 mb-4">
                LIVE AUCTION
            </div>

            <h1 class="fw-bold fs-2 mb-2">
                Tekrar Hoşgeldin
            </h1>

            <p class="text-muted fs-6">
                Hesabına giriş yap ve canlı müzayedelere katıl
            </p>

        </div>

        <div class="form-floating mb-5">
            <input type="email" name="email"
                id="email"
                class="form-control auth-input @error('email') is-invalid @enderror"
                placeholder="E-posta"
                value="{{ old('email') }}"
                autocomplete="off"
                required>
            <label for="email">E-posta adresi</label>

            @error('email')
                <div class="invalid-feedback d-block text-danger small">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-floating mb-5 position-relative" data-kt-password-meter="true">
            <input type="password" name="password"
                id="password"
                class="form-control auth-input pe-5 @error('password') is-invalid @enderror"
                placeholder="Şifre"
                autocomplete="off"
                required>
            <label for="password">Şifre</label>

            <span
                class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 {{ $errors->has('password') ? 'pb-5' : '' }}"
                data-kt-password-meter-control="visibility">
                <i class="bi bi-eye-slash fs-2"></i>
                <i class="bi bi-eye fs-2 d-none"></i>
            </span>

            @error('password')
                <div class="invalid-feedback d-block text-danger small">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-8">

            <label class="form-check text-muted">
                <input class="form-check-input" type="checkbox" name="remember" value="1">
                <span class="ms-2">Beni Hatırla</span>
            </label>

            <a href="{{ route('password.request') }}" class="text-primary text-decoration-none">
                Şifremi unuttum?
            </a>

        </div>

        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-auth-primary btn-lg fw-bold">
                Giriş Yap
            </button>
        </div>

        <div class="d-grid">
            <a href="{{ route('register') }}" class="btn btn-auth-outline btn-lg">
                Hesabın yok mu? Kayıt ol
            </a>
        </div>

    </form>
@endsection