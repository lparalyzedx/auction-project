<!DOCTYPE html>
<html lang="tr" data-bs-theme="dark"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>artirdim.com - Yakında Canlıdayız</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- TEMA DEĞİŞKENLERİ (Bootstrap data-bs-theme Uyumu) --- */

        /* Dark Mode */
        [data-bs-theme="dark"] {
            --bg-color: #0b0e14;
            --card-bg: #11151d;
            --text-main: #ffffff;
            --text-muted: #788294;
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --neon-glow: rgba(168, 85, 247, 0.4);
            --border-color: rgba(255, 255, 255, 0.05);
            --badge-bg: rgba(168, 85, 247, 0.1);
            --badge-color: #a855f7;
            --badge-border: rgba(168, 85, 247, 0.2);
        }

        /* Light Mode */
        [data-bs-theme="light"] {
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --neon-glow: rgba(124, 58, 237, 0.2);
            --border-color: rgba(0, 0, 0, 0.06);
            --badge-bg: rgba(124, 58, 237, 0.08);
            --badge-color: #7c3aed;
            --badge-border: rgba(124, 58, 237, 0.15);
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
            width: 400px;
            height: 400px;
            background: var(--primary-gradient);
            filter: blur(150px);
            opacity: 0.15;
            z-index: 0;
            top: 20%;
            left: 30%;
        }

        .container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 580px;
            text-align: center;
            background: var(--card-bg);
            padding: 50px 40px;
            border-radius: 24px;
            border: 1px solid var(--border-color);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: background 0.3s ease, border 0.3s ease;
        }

        /* --- LOGO TASARIMI --- */
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 40px;
        }

        .logo-icon {
            display: flex;
            align-items: flex-end;
            gap: 3px;
            height: 24px;
        }

        .logo-icon .wave {
            width: 4px;
            background: var(--primary-gradient);
            border-radius: 10px;
            display: inline-block;
            animation: pulse 1.5s infinite ease-in-out;
        }
        .logo-icon .wave:nth-child(1) { height: 12px; animation-delay: 0.1s; }
        .logo-icon .wave:nth-child(2) { height: 24px; animation-delay: 0.3s; }
        .logo-icon .wave:nth-child(3) { height: 18px; animation-delay: 0.5s; }

        .logo-text {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .logo-text span {
            color: #6366f1;
            font-weight: 400;
        }

        /* --- İÇERİK ALANI --- */
        .badge {
            display: inline-block;
            padding: 6px 16px;
            background: var(--badge-bg);
            color: var(--badge-color);
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 24px;
            border: 1px solid var(--badge-border);
            transition: all 0.3s ease;
        }

        h2 {
            font-size: 28px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        p {
            color: var(--text-muted);
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        /* --- PROGRESS BAR (YÜKLENİYOR BARI) --- */
        .progress-container {
            width: 100%;
            height: 6px;
            background: var(--border-color);
            border-radius: 100px;
            overflow: hidden;
            margin-bottom: 35px;
        }

        .progress-bar {
            width: 75%; /* İlerleme yüzdesi */
            height: 100%;
            background: var(--primary-gradient);
            border-radius: 100px;
            box-shadow: 0 0 12px var(--neon-glow);
            position: relative;
        }

        /* --- DURUM PANELİ --- */
        .status-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .status-item {
            background: rgba(255, 255, 255, 0.01);
            border: 1px solid var(--border-color);
            padding: 14px;
            border-radius: 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .status-title {
            font-size: 12px;
            color: var(--text-muted);
        }

        .status-value {
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .status-value.working .dot {
            width: 8px;
            height: 8px;
            background-color: #10b981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 8px #10b981;
            animation: blink 1.5s infinite;
        }

        /* --- FOOTER & TEMA GEÇİŞ BUTONU --- */
        .footer p {
            font-size: 12px;
            margin-bottom: 0;
            color: var(--text-muted);
        }

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
        .theme-toggle:hover {
            transform: scale(1.05);
        }

        /* --- ANİMASYONLAR --- */
        @keyframes pulse {
            0%, 100% { transform: scaleY(1); }
            50% { transform: scaleY(0.6); }
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
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

        <div class="content">
            <div class="badge">CANLI MÜZAYEDE SİSTEMİ</div>
            <h2>Çekici Deneyimler İçin Alanı Güncelliyoruz</h2>
            <p>Sizlere daha hızlı, güvenli ve kusursuz bir canlı açık artırma deneyimi sunabilmek için sistemimizi bakıma aldık. Kısa süre sonra çekiç yeniden vurulacak!</p>
        </div>

        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>

        <div class="status-grid">
            <div class="status-item">
                <span class="status-title">Durum</span>
                <span class="status-value working"><span class="dot"></span> Optimizasyon</span>
            </div>
            <div class="status-item">
                <span class="status-title">Hedef</span>
                <span class="status-value">%98 Hazır</span>
            </div>
        </div>

        <div class="footer">
            <p>&copy; 2026 artirdim.com. Tüm hakları saklıdır.</p>
        </div>
    </div>

    <script>
        // Sayfa DOM ağacı yüklendiğinde hafızadaki temayı oku ve uygula
        document.addEventListener("DOMContentLoaded", () => {
            // LocalStorage'den 'theme' oku, kayıt yoksa 'dark' mod kabul et
            const savedTheme = localStorage.getItem('theme') || 'dark';
            applyTheme(savedTheme);
        });

        // Temayı elemente basan ve veritabanına/hafızaya kaydeden fonksiyon
        function applyTheme(theme) {
            const htmlElement = document.documentElement; // <html> etiketini yakalar
            const icon = document.getElementById('theme-icon');

            // Bootstrap 5+ uyumlu tema özniteliğini atıyoruz
            htmlElement.setAttribute('data-bs-theme', theme);

            // Seçimi tarayıcı hafızasına yazıyoruz
            localStorage.setItem('theme', theme);

            // Sağ üst köşedeki ikonu senkronize ediyoruz
            if (theme === 'light') {
                icon.className = 'fa-solid fa-sun';
            } else {
                icon.className = 'fa-solid fa-moon';
            }
        }

        // Kullanıcı butona tıkladığında temalar arası geçişi sağlayan tetikleyici
        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            const newTheme = (currentTheme === 'dark') ? 'light' : 'dark';

            applyTheme(newTheme);
        }
    </script>
</body>
</html>
