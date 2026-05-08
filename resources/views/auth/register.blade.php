@extends('auth.layouts.master')
@section('title', 'Kaydol')

@section('content')
<form class="form w-100" id="kt_sign_up_form" method="post"
    action="{{ route('register') }}" enctype="multipart/form-data">
    @csrf
    <div id="step_1">
        <div class="text-center mb-10">
            <h1 class="text-dark fw-bold mb-2">Kayıt Ol</h1>
            <div class="text-muted fs-6">Müzayedeye katılmak için hesabını oluştur</div>
        </div>

        <div class="mb-6">
            <label class="form-label text-muted fs-7 fw-semibold mb-3">Hesap Türü</label>
            <div class="row g-3">
                <div class="col-6">
                    <label class="d-block cursor-pointer">
                        <input type="radio" name="role" value="buyer" class="d-none role-radio"
                            {{ old('role', 'buyer') === 'buyer' ? 'checked' : '' }}>
                        <div class="role-card p-4 rounded-2 text-center border border-dashed
                            {{ old('role', 'buyer') === 'buyer' ? 'border-primary bg-light-primary' : 'border-secondary bg-transparent' }}">
                            <div class="symbol symbol-40px mx-auto mb-3">
                                <div class="symbol-label rounded-circle role-icon-wrap
                                    {{ old('role', 'buyer') === 'buyer' ? 'bg-primary' : 'bg-secondary' }}">
                                    <i class="ki-duotone ki-profile-user fs-2
                                        {{ old('role', 'buyer') === 'buyer' ? 'text-white' : 'text-muted' }}">
                                        <span class="path1"></span><span class="path2"></span>
                                        <span class="path3"></span><span class="path4"></span>
                                    </i>
                                </div>
                            </div>
                            <div class="fw-bold role-label {{ old('role', 'buyer') === 'buyer' ? 'text-primary' : 'text-muted' }}">Alıcı</div>
                            <div class="text-muted fs-8 mt-1">Teklif ver, satın al</div>
                        </div>
                    </label>
                </div>
                <div class="col-6">
                    <label class="d-block cursor-pointer">
                        <input type="radio" name="role" value="seller" class="d-none role-radio"
                            {{ old('role') === 'seller' ? 'checked' : '' }}>
                        <div class="role-card p-4 rounded-2 text-center border border-dashed
                            {{ old('role') === 'seller' ? 'border-primary bg-light-primary' : 'border-secondary bg-transparent' }}">
                            <div class="symbol symbol-40px mx-auto mb-3">
                                <div class="symbol-label rounded-circle role-icon-wrap
                                    {{ old('role') === 'seller' ? 'bg-primary' : 'bg-secondary' }}">
                                    <i class="ki-duotone ki-shop fs-2
                                        {{ old('role') === 'seller' ? 'text-white' : 'text-muted' }}">
                                        <span class="path1"></span><span class="path2"></span>
                                        <span class="path3"></span><span class="path4"></span>
                                    </i>
                                </div>
                            </div>
                            <div class="fw-bold role-label {{ old('role') === 'seller' ? 'text-primary' : 'text-muted' }}">Satıcı</div>
                            <div class="text-muted fs-8 mt-1">İlan ver, sat</div>
                        </div>
                    </label>
                </div>
            </div>
            @error('role')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="fv-row mb-4">
            <div class="form-floating">
                <input type="text" name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Ad Soyad" value="{{ old('name') }}">
                <label>Ad Soyad</label>
            </div>
            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="fv-row mb-4">
            <div class="form-floating">
                <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="E-posta" value="{{ old('email') }}">
                <label>E-posta</label>
            </div>
            @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="fv-row mb-6">
            <div class="form-floating">
                <input type="text" name="phone"
                    class="form-control @error('phone') is-invalid @enderror"
                    placeholder="Telefon" value="{{ old('phone') }}">
                <label>GSM Numarası</label>
            </div>
            @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <button type="button" id="btn_next_1"
            class="btn btn-auth-primary btn-lg w-100">
            Devam et
            <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="15px" fill="#e3e3e3"><path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/></svg>
        </button>
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="btn btn-auth-outline btn-lg w-100">
                Zaten hesabın var mı? Giriş yap
            </a>
        </div>
    </div>

    <div id="step_2" style="display:none">

        @if($errors->hasAny(['tax_number','iban','company_name','id_document']))
            <div class="alert alert-danger mb-6">
                <ul class="mb-0">
                    @foreach(['tax_number','iban','company_name','id_document'] as $field)
                        @error($field) <li>{{ $message }}</li> @enderror
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="text-center mb-8">
            <div class="mb-4">
                <span class="badge badge-light-primary fs-7 px-4 py-2">
                    <i class="ki-duotone ki-shop fs-6 me-1"><span class="path1"></span><span class="path2"></span></i>
                    Satıcı Bilgileri
                </span>
            </div>
            <h1 class="text-dark fw-bold mb-2">İşletme Bilgileri</h1>
            <div class="text-muted fs-6">Bilgileriniz admin onayına gönderilecek</div>
        </div>

        <div class="d-flex justify-content-between mb-1">
            <span class="text-muted fs-8">Adım 2 / 3</span>
            <span class="text-primary fs-8 fw-semibold">Satıcı Doğrulama</span>
        </div>
        <div class="progress h-6px mb-8">
            <div class="progress-bar bg-primary" style="width:66%"></div>
        </div>

        <div class="fv-row mb-4">
            <div class="form-floating">
                <input type="text" name="company_name"
                    class="form-control @error('company_name') is-invalid @enderror"
                    placeholder="Şirket Adı" value="{{ old('company_name') }}">
                <label>Şirket Adı <span class="text-muted fs-8">(opsiyonel)</span></label>
            </div>
            @error('company_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="fv-row mb-4">
            <div class="form-floating">
                <input type="text" name="tax_number"
                    class="form-control @error('tax_number') is-invalid @enderror"
                    placeholder="Vergi Numarası" value="{{ old('tax_number') }}">
                <label>Vergi Numarası</label>
            </div>
            @error('tax_number') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="fv-row mb-4">
            <div class="form-floating">
                <input type="text" name="iban"
                    class="form-control @error('iban') is-invalid @enderror"
                    placeholder="IBAN" value="{{ old('iban') }}" maxlength="34"
                    style="text-transform:uppercase;letter-spacing:1px">
                <label>IBAN</label>
            </div>
            @error('iban') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="fv-row mb-6">
            <label class="form-label text-muted fs-7 fw-semibold mb-2">
                Kimlik Belgesi
                <span class="text-muted fs-8">(JPG, PNG veya PDF — maks. 5MB)</span>
            </label>
            <input type="file" name="id_document"
                class="form-control @error('id_document') is-invalid @enderror"
                accept=".jpg,.jpeg,.png,.pdf">
            @error('id_document') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex gap-3">
            <button type="button" id="btn_back_2" class="btn btn-auth-outline btn-lg py-3 fw-semibold" style="width:30%">
                Geri
            </button>
            <button type="button" id="btn_next_2" class="btn btn-auth-primary btn-lg py-3 fw-semibold flex-grow-1">
                Devam et 
<svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="15px" fill="#e3e3e3"><path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z"/></svg>
            </button>
        </div>
    </div>

    <div id="step_3" style="display:none">

        @if($errors->hasAny(['password']))
            <div class="alert alert-danger mb-6">
                <ul class="mb-0">
                    @error('password') <li>{{ $message }}</li> @enderror
                </ul>
            </div>
        @endif

        <div class="text-center mb-8">
            <div class="mb-4">
                <span class="badge badge-light-success fs-7 px-4 py-2">
                    <i class="ki-duotone ki-shield-tick fs-6 me-1"><span class="path1"></span><span class="path2"></span></i>
                    Son Adım
                </span>
            </div>
            <h1 class="text-dark fw-bold mb-2">Şifre Oluştur</h1>
            <div class="text-muted fs-6">Hesabını güvende tut</div>
        </div>

        <div class="d-flex justify-content-between mb-1">
            <span class="text-muted fs-8" id="step_label">Adım 2 / 2</span>
            <span class="text-success fs-8 fw-semibold">Şifre</span>
        </div>
        <div class="progress h-6px mb-8">
            <div class="progress-bar bg-success" style="width:100%"></div>
        </div>

        <div class="fv-row mb-4">
            <div class="form-floating position-relative" data-kt-password-meter="true">
                <input type="password" name="password" id="password"
                    class="form-control auth-input pe-5 @error('password') is-invalid @enderror"
                    placeholder="Şifre" autocomplete="off">
                <label for="password">Şifre</label>
                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0"
                    data-kt-password-meter-control="visibility">
                    <i class="bi bi-eye-slash fs-2"></i>
                    <i class="bi bi-eye fs-2 d-none"></i>
                </span>
            </div>
        </div>

        <div class="fv-row mb-6">
            <div class="form-floating position-relative" data-kt-password-meter="true">
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-control auth-input pe-5"
                    placeholder="Şifre Tekrar" autocomplete="off">
                <label for="password_confirmation">Şifre Tekrar</label>
                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0"
                    data-kt-password-meter-control="visibility">
                    <i class="bi bi-eye-slash fs-2"></i>
                    <i class="bi bi-eye fs-2 d-none"></i>
                </span>
            </div>
            <div id="password_mismatch_error" class="text-danger small mt-1" style="display:none">
                Şifreler eşleşmiyor.
            </div>
        </div>

        <div class="mb-8">
            <label class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" name="terms" id="terms_check">
                <span class="form-check-label text-muted fs-7">
                    <a href="#" class="text-primary">Kullanım koşullarını</a> okudum ve kabul ediyorum
                </span>
            </label>
            <div id="terms_error" class="text-danger small mt-1" style="display:none">
                Kullanım koşullarını kabul etmelisiniz.
            </div>
        </div>

        <div class="d-flex gap-3">
            <button type="button" id="btn_back_3" class="btn btn-auth-outline btn-lg py-3 fw-semibold" style="width:30%">
                Geri
            </button>
            <button type="submit" id="kt_sign_up_submit"
                class="btn btn-auth-primary btn-lg py-3 fw-semibold flex-grow-1">
                <span class="indicator-label">Kayıt Ol</span>
                <span class="indicator-progress">
                    Lütfen bekleyin...
                    <span class="spinner-border spinner-border-sm ms-2 align-middle"></span>
                </span>
            </button>
        </div>
    </div>

</form>
@endsection

@push('scripts')
<script src="{{asset('assets/js/custom/authentication/sign-up/general.js')}}"></script>
<script>
    @if($errors->any())
        @if($errors->hasAny(['tax_number','iban','company_name','id_document']))
            showStep(2);
        @elseif($errors->hasAny(['password']))
            @if(old('role') === 'seller')
                document.getElementById('step_label').textContent = 'Adım 3 / 3';
            @else
                document.getElementById('step_label').textContent = 'Adım 2 / 2';
            @endif
            showStep(3);
        @else
            showStep(1);
        @endif
    @endif
</script>
@endpush