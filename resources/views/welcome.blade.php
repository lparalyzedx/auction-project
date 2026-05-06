@extends('layouts.app')

@section('title','Ana Sayfa')

@section('content')

<div class="container py-4">

    {{-- HERO --}}
    <div class="hero mb-4">

        <div class="live mb-3">
            <i></i>
            LIVE AUCTION
        </div>

        <h1 class="mb-3">
            Gerçek Zamanlı Açık Artırmalar
        </h1>

        <p class="mb-4">
            Anlık teklif ver, en iyi fiyatı yakala. Tüm açık artırmalar canlı olarak güncellenir.
        </p>

        <div class="d-flex gap-2 flex-wrap">
            <a href="#" class="btn btn-primary px-4">
                Açık Artırmaları Gör
            </a>

            @guest
            <a href="{{ route('login') }}" class="btn btn-outline-light px-4">
                Giriş Yap
            </a>
            @else
            <a href="#" class="btn btn-outline-light px-4">
                Panel
            </a>
            @endguest
        </div>

    </div>

    {{-- TITLE --}}
    <h5 class="section-title">Aktif Açık Artırmalar</h5>

    {{-- GRID --}}
    <div class="row g-3">

        @for($i=1;$i<=6;$i++)
        <div class="col-md-4 col-sm-6">

            <div class="auction-card">

                <img src="https://picsum.photos/500/300?random={{$i}}" class="auction-img">

                <div class="p-3 text-white">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="fw-semibold">Ürün {{$i}}</div>
                        <div class="meta">LIVE</div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="meta">Güncel teklif</div>
                            <div class="price">₺ {{ rand(1000,9000) }}</div>
                        </div>

                        <div class="text-end">
                            <div class="meta">Süre</div>
                            <div class="text-white">02:{{ rand(10,59) }}:{{ rand(10,59) }}</div>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 mt-3">
                        Teklif Ver
                    </button>

                </div>

            </div>

        </div>
        @endfor

    </div>

</div>

@endsection