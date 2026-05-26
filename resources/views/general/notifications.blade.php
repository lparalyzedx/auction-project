@extends('layouts.app')

@section('title','Bildirimler')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Bildirimler
            </h3>

            <div class="text-muted fs-7">
                Son aktivitelerin
            </div>
        </div>

        <button class="btn btn-light btn-sm">
            Tümünü okundu yap
        </button>

    </div>

    <div class="mb-5">

        <div class="text-muted fw-semibold fs-7 mb-3 px-1">
            Bugün
        </div>

        <div class="d-flex flex-column gap-2">

            <a href="#" class="card border-0 shadow-sm text-decoration-none notification-item">
                <div class="card-body d-flex align-items-center gap-3 py-3">

                    <div class="symbol symbol-45px">
                        <img src="https://picsum.photos/100?1" class="rounded-3 object-fit-cover">
                    </div>

                    <div class="flex-grow-1">

                        <div class="text-gray-800 fs-7">
                            <span class="fw-bold">iPhone 15 Pro</span>
                            müzayedesinde teklifin geçildi.
                        </div>

                        <div class="text-muted fs-8 mt-1">
                            2 dk önce
                        </div>

                    </div>

                    <span class="badge badge-circle badge-primary w-10px h-10px"></span>

                </div>
            </a>

            <a href="#" class="card border-0 shadow-sm text-decoration-none notification-item">
                <div class="card-body d-flex align-items-center gap-3 py-3">

                    <div class="symbol symbol-45px">
                        <img src="https://picsum.photos/100?2" class="rounded-3 object-fit-cover">
                    </div>

                    <div class="flex-grow-1">

                        <div class="text-gray-800 fs-7">
                            <span class="fw-bold">Rolex Submariner</span>
                            açık artırmasını kazandın 🎉
                        </div>

                        <div class="text-muted fs-8 mt-1">
                            25 dk önce
                        </div>

                    </div>

                </div>
            </a>

        </div>

    </div>

    <div>

        <div class="text-muted fw-semibold fs-7 mb-3 px-1">
            Dün
        </div>

        <div class="d-flex flex-column gap-2">

            <a href="#" class="card border-0 shadow-sm text-decoration-none notification-item">
                <div class="card-body d-flex align-items-center gap-3 py-3">

                    <div class="symbol symbol-45px">
                        <img src="https://picsum.photos/100?3" class="rounded-3 object-fit-cover">
                    </div>

                    <div class="flex-grow-1">

                        <div class="text-gray-800 fs-7">
                            <span class="fw-bold">BMW M4 Competition</span>
                            müzayedesi başladı.
                        </div>

                        <div class="text-muted fs-8 mt-1">
                            Dün 21:14
                        </div>

                    </div>

                </div>
            </a>

            <a href="#" class="card border-0 shadow-sm text-decoration-none notification-item">
                <div class="card-body d-flex align-items-center gap-3 py-3">

                    <div class="symbol symbol-45px">
                        <img src="https://picsum.photos/100?4" class="rounded-3 object-fit-cover">
                    </div>

                    <div class="flex-grow-1">

                        <div class="text-gray-800 fs-7">
                            Satıcı hesabın onaylandı ✅
                        </div>

                        <div class="text-muted fs-8 mt-1">
                            Dün 16:40
                        </div>

                    </div>

                </div>
            </a>

        </div>

    </div>

</div>

@endsection
