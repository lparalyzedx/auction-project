<!DOCTYPE html>
<html lang="tr" data-bs-theme="dark"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Sayfa Bulunamadı | artirdim.com</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- TEMA DEĞİŞKENLERİ --- */
        /* Bootstrap data-bs-theme mantığına göre CSS seçicileri güncellendi */

        /* Dark Mode (Varsayılan) */
        [data-bs-theme="dark"] {
            --bg-color: #0b0e14;
            --card-bg: #11151d;
            --text-main: #ffffff;
            --text-muted: #788294;
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --border-color: rgba(255, 255, 255, 0.05);
            --btn-secondary-hover: rgba(255, 255, 255, 0.03);
        }

        /* Light Mode */
        [data-bs-theme="light"] {
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --border-color: rgba(0, 0, 0, 0.06);
            --btn-secondary-hover: rgba(0, 0, 0, 0.02);
        }

        /* --- GENEL AYARLAR --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
            padding: 20px;
        }

        body::before {
            content: '';
            position: absolute;
            width: 450px;
            height: 450px;
            background: var(--primary-gradient);
            filter: blur(160px);
            opacity: 0.12;
            z-index: 0;
            top: 25%;
            left: 25%;
        }

        .container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 540px;
            text-align: center;
            background: var(--card-bg);
            padding: 50px 40px;
            border-radius: 24px;
            border: 1px solid var(--border-color);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            transition: background 0.3s ease, border 0.3s ease;
        }

        /* --- LOGO ALANI --- */
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .logo-icon {
            display: flex;
            align-items: flex-end;
            gap: 3px;
            height: 20px;
        }

        .logo-icon .wave {
            width: 3.5px;
            background: var(--primary-gradient);
            border-radius: 10px;
            display: inline-block;
        }
        .logo-icon .wave:nth-child(1) { height: 10px; }
        .logo-icon .wave:nth-child(2) { height: 20px; }
        .logo-icon .wave:nth-child(3) { height: 14px; }

        .logo-text {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .logo-text span {
            color: #6366f1;
            font-weight: 400;
        }

        /* --- 404 NUMARA --- */
        .error-code {
            font-size: 110px;
            font-weight: 900;
            line-height: 1;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -2px;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 24px;
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: 14px;
        }

        p {
            color: var(--text-muted);
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 35px;
        }

        /* --- BUTONLAR --- */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: center;
            justify-content: center;
        }

        @media (min-width: 480px) {
            .action-buttons { flex-direction: row; }
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 28px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.2s ease;
            width: 100%;
            max-width: 200px;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: #ffffff;
            border: none;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.35);
        }

        .btn-secondary {
            background: transparent;
            color: var(--text-main);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--btn-secondary-hover);
            border-color: var(--text-muted);
        }

        /* --- TEMA GEÇİŞ BUTONU --- */
        .theme-toggle {
            position: absolute;
            top: 30px;
            right: 30px;
            width: 44px;
            height: 44px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: all 0.2s;
            z-index: 10;
        }
        .theme-toggle:hover { transform: scale(1.05); }
    </style>
</head>
<body>

    <div class="theme-toggle" onclick="toggleTheme()">
        <i class="fa-solid fa-moon" id="theme-icon"></i>
    </div>

    <div class="container">
        <div class="logo-container">
            <div class="logo-icon">
                <span class="wave"></span>
                <span class="wave"></span>
                <span class="wave"></span>
            </div>
            <h1 class="logo-text">artirdim<span>.com</span></h1>
        </div>

        <div class="error-code">404</div>
        <h2>Aradığınız Sayfa Bulunamadı!</h2>
        <p>Görünüşe göre bu sayfa yayından kalkmış, adresi değişmiş ya da çekiç yanlış yere vurulmuş.</p>

        <div class="action-buttons">
            <a href="/" class="btn btn-primary">
                <i class="fa-solid fa-gavel"></i> Ana Sayfa
            </a>
            <button onclick="window.history.back()" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Geri Dön
            </button>
        </div>
    </div>

    <script>
        // Sayfa yüklenir yüklenmez (DOM hazır olduğunda) temayı kontrol et ve uygula
        document.addEventListener("DOMContentLoaded", () => {
            // LocalStorage'den 'theme' değerini çek, yoksa varsayılan olarak 'dark' ata
            const savedTheme = localStorage.getItem('theme') || 'dark';

            // Temayı sisteme uygula
            applyTheme(savedTheme);
        });

        // Temayı HTML attribute'una basan ve ikonu güncelleyen fonksiyon
        function applyTheme(theme) {
            const htmlElement = document.documentElement; // <html> etiketini seçer
            const icon = document.getElementById('theme-icon');

            // Bootstrap uyumlu data-bs-theme değerini set et
            htmlElement.setAttribute('data-bs-theme', theme);

            // Seçimi LocalStorage'e kaydet/güncelle
            localStorage.setItem('theme', theme);

            // Sağ üstteki ikonu temaya göre güncelle
            if (theme === 'light') {
                icon.className = 'fa-solid fa-sun';
            } else {
                icon.className = 'fa-solid fa-moon';
            }
        }

        // Butona tıklandığında temayı tersine çeviren fonksiyon
        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            // Eğer şu an dark ise light yap, light ise dark yap
            const newTheme = (currentTheme === 'dark') ? 'light' : 'dark';

            applyTheme(newTheme);
        }
    </script>
</body>
</html>
