</div>

</div>
</div>

<div id="authBg" class="d-flex flex-lg-row-fluid w-lg-50 position-relative order-1 order-lg-2"
    style="background: url('https://images.unsplash.com/photo-1601597111158-2fceff292cdc?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;">

    <div class="position-absolute top-0 start-0 w-100 h-100"
        style="background: linear-gradient(135deg, rgba(0,0,0,0.85), rgba(13,110,253,0.6));">
    </div>

    <div
        class="d-flex flex-column justify-content-center align-items-center w-100 text-center position-relative z-index-2 p-10">

        <div class="mb-8">
            <h1 class="text-white fw-bold display-6">
                {{ env('APP_NAME') }}
            </h1>
            <div class="text-primary fw-semibold auth-brand">LIVE AUCTION SYSTEM</div>
        </div>

        <p class="text-white opacity-75 fs-6 mw-450px">
            Gerçek zamanlı müzayedelere katıl, anlık teklif ver ve en iyi fiyatı yakala.
            Güvenli ve hızlı açık artırma deneyimi.
        </p>

        <div class="d-flex gap-4 mt-10 flex-wrap justify-content-center">

            <div class="bg-white bg-opacity-10 backdrop-blur px-6 py-4 rounded-4 text-center shadow">
                <div class="fs-2hx fw-bold text-white">LIVE</div>
                <div class="text-white opacity-75 fs-7">Aktif Açık Artırma</div>
            </div>

            <div class="bg-white bg-opacity-10 backdrop-blur px-6 py-4 rounded-4 text-center shadow">
                <div class="fs-2hx fw-bold text-primary">24/7</div>
                <div class="text-white opacity-75 fs-7">Kesintisiz Sistem</div>
            </div>

            <div class="bg-white bg-opacity-10 backdrop-blur px-6 py-4 rounded-4 text-center shadow">
                <div class="fs-2hx fw-bold text-success">+1K</div>
                <div class="text-white opacity-75 fs-7">Aktif Kullanıcı</div>
            </div>

        </div>

        <div class="mt-10">
            <span class="badge bg-primary px-4 py-3 fs-7 rounded-pill">
                🔥 En hızlı teklif sistemi
            </span>
        </div>

    </div>
</div>

</div>
</div>

<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script>
const images = [
    "https://picsum.photos/500/300?random=2",
    "https://picsum.photos/500/300?random=3",
    "https://picsum.photos/500/300?random=4",
    "https://picsum.photos/500/300?random=5"
];

let index = 0;
const el = document.getElementById("authBg");

setInterval(() => {
    index = (index + 1) % images.length;

    el.style.backgroundImage = `url('${images[index]}')`;
    el.style.backgroundSize = "cover";
    el.style.backgroundPosition = "center";
}, 10000);
</script>
@stack('scripts')

</body>

</html>
