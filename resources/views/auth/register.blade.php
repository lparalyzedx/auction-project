@extends('auth.layouts.master')
@section('title', 'Kaydol')

@section('content')
    <form class="form w-100" id="kt_sign_up_form" method="post" action="{{ route('register') }}">
        @csrf

        <div class="text-center mb-10">
            <h1 class="fw-bold text-white mb-2">Kayıt Ol</h1>
            <div class="text-muted fs-6">
                Müzayedeye katılmak için hesabını oluştur
            </div>
        </div>

        <div class="form-floating mb-4">
            <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror"
                placeholder="Firma Ünvanı" value="{{ old('company_name') }}" required>
            <label>Firma Ünvanı</label>
        </div>

        <div class="form-floating mb-4">
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                placeholder="Ad Soyad" value="{{ old('name') }}" required>
            <label>Ad Soyad</label>
        </div>

        <div class="form-floating mb-4">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="E-posta" value="{{ old('email') }}" required>
            <label>E-posta</label>
        </div>

        <div class="form-floating mb-4">
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                placeholder="Telefon" value="{{ old('phone') }}" required>
            <label>GSM Numarası</label>
        </div>

        <div class="form-floating mb-3 position-relative" data-kt-password-meter="true">
            <input type="password" name="password" class="form-control pe-10 @error('password') is-invalid @enderror"
                placeholder="Şifre" required>

            <label>Şifre</label>

            <span
                class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 {{ $errors->has('password') ? 'pb-5' : '' }}"
                data-kt-password-meter-control="visibility">
                <i class="bi bi-eye-slash fs-2"></i>
                <i class="bi bi-eye fs-2 d-none"></i>
            </span>
        </div>

        <div class="form-floating mb-4 position-relative" data-kt-password-meter="true">
            <input type="password" name="password_confirmation" class="form-control pe-10" placeholder="Şifre tekrar"
                required>

            <label>Şifre Tekrar</label>
            <span
                class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 {{ $errors->has('password') ? 'pb-5' : '' }}"
                data-kt-password-meter-control="visibility">
                <i class="bi bi-eye-slash fs-2"></i>
                <i class="bi bi-eye fs-2 d-none"></i>
            </span>
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="toc" required>
            <label class="form-check-label text-muted small">
                Kullanıcı sözleşmesini kabul ediyorum
            </label>
        </div>

        <button class="btn btn-auth-primary btn-lg w-100 py-3 fw-semibold">
            Kayıt Ol
        </button>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="btn btn-auth-outline btn-lg w-100">
                Zaten hesabın var mı? Giriş yap
            </a>
        </div>
    </form>



@endsection
