@extends('auth.layouts.master')
@section('title', 'Kaydol')

@section('content')
    <form class="form w-100" id="kt_sign_up_form" method="post" action="{{ route('register') }}">
        @csrf

        <div class="text-center mb-10">
            <h1 class="text-muted fw-bold mb-2">Kayıt Ol</h1>
            <div class="text-muted fs-6">
                Müzayedeye katılmak için hesabını oluştur
            </div>
        </div>

        <div class="mb-6">
            <label class="form-label text-muted fs-7 fw-semibold mb-3">Hesap Türü</label>
            <div class="row g-3">

                <div class="col-6">
                    <label class="d-block cursor-pointer">
                        <input type="radio" name="role" value="buyer" class="d-none role-radio"
                            {{ old('role', 'buyer') === 'buyer' ? 'checked' : '' }}>
                        <div
                            class="role-card p-4 rounded-2 text-center border border-dashed
                                {{ old('role', 'buyer') === 'buyer' ? 'border-primary bg-light-primary' : 'border-secondary bg-transparent' }}">
                            <div class="symbol symbol-40px mx-auto mb-3">
                                <div
                                    class="symbol-label {{ old('role', 'buyer') === 'buyer' ? 'bg-primary' : 'bg-secondary' }} rounded-circle role-icon-wrap">
                                    <i
                                        class="ki-duotone ki-profile-user fs-2 {{ old('role', 'buyer') === 'buyer' ? 'text-white' : 'text-muted' }}">
                                        <span class="path1"></span><span class="path2"></span>
                                        <span class="path3"></span><span class="path4"></span>
                                    </i>
                                </div>
                            </div>
                            <div
                                class="fw-bold {{ old('role', 'buyer') === 'buyer' ? 'text-primary' : 'text-muted' }} role-label">
                                Alıcı</div>
                            <div class="text-muted fs-8 mt-1">Teklif ver, satın al</div>
                        </div>
                    </label>
                </div>

                <div class="col-6">
                    <label class="d-block cursor-pointer">
                        <input type="radio" name="role" value="seller" class="d-none role-radio"
                            {{ old('role') === 'seller' ? 'checked' : '' }}>
                        <div
                            class="role-card p-4 rounded-2 text-center border border-dashed
                                {{ old('role') === 'seller' ? 'border-primary bg-light-primary' : 'border-secondary bg-transparent' }}">
                            <div class="symbol symbol-40px mx-auto mb-3">
                                <div
                                    class="symbol-label {{ old('role') === 'seller' ? 'bg-primary' : 'bg-secondary' }} rounded-circle role-icon-wrap">
                                    <i
                                        class="ki-duotone ki-shop fs-2 {{ old('role') === 'seller' ? 'text-white' : 'text-muted' }}">
                                        <span class="path1"></span><span class="path2"></span>
                                        <span class="path3"></span><span class="path4"></span>
                                    </i>
                                </div>
                            </div>
                            <div class="fw-bold {{ old('role') === 'seller' ? 'text-primary' : 'text-muted' }} role-label">
                                Satıcı</div>
                            <div class="text-muted fs-8 mt-1">İlan ver, sat</div>
                        </div>
                    </label>
                </div>

            </div>
            @error('role')
                <div class="text-danger fs-8 mt-2">{{ $message }}</div>
            @enderror
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

        <div class="form-floating mb-4 position-relative" data-kt-password-meter="true">
            <input type="password" name="password" class="form-control pe-10 @error('password') is-invalid @enderror"
                placeholder="Şifre" value="{{old('password')}}" required>

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
               value="{{old('password_confirmation')}}" required>

            <label>Şifre Tekrar</label>
            <span
                class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 {{ $errors->has('password_confirmation') ? 'pb-5' : '' }}"
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
@push('scripts')
    <script>
        document.querySelectorAll('.role-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.role-card').forEach(card => {
                    card.classList.remove('border-primary', 'bg-light-primary');
                    card.classList.add('border-secondary', 'bg-transparent');
                });
                document.querySelectorAll('.role-icon-wrap').forEach(icon => {
                    icon.classList.remove('bg-primary');
                    icon.classList.add('bg-secondary');
                });
                document.querySelectorAll('.role-icon-wrap i').forEach(i => {
                    i.classList.remove('text-white');
                    i.classList.add('text-muted');
                });
                document.querySelectorAll('.role-label').forEach(label => {
                    label.classList.remove('text-primary');
                    label.classList.add('text-muted');
                });

                const card = this.nextElementSibling;
                card.classList.add('border-primary', 'bg-light-primary');
                card.classList.remove('border-secondary', 'bg-transparent');

                const iconWrap = card.querySelector('.role-icon-wrap');
                iconWrap.classList.add('bg-primary');
                iconWrap.classList.remove('bg-secondary');

                const icon = iconWrap.querySelector('i');
                icon.classList.add('text-white');
                icon.classList.remove('text-muted');

                const label = card.querySelector('.role-label');
                label.classList.add('text-primary');
                label.classList.remove('text-muted');
            });
        });

        document.getElementById('kt_sign_up_form').addEventListener('submit', function() {
            const btn = document.getElementById('kt_sign_up_submit');
            btn.setAttribute('data-kt-indicator', 'on');
            btn.disabled = true;
        });
    </script>
@endpush
