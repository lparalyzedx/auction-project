<!DOCTYPE html>
<html lang="tr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>artirdim.com - Yakında Canlıdayız</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        [data-bs-theme="dark"] {
            --bg-color: #0b0e14;
            --card-bg: #11151d;
            --text-main: #ffffff;
            --text-muted: #788294;
            --grad-start: #6366f1;
            --grad-end: #a855f7;
            --neon-glow: rgba(168, 85, 247, 0.35);
            --border-color: rgba(255, 255, 255, 0.06);
            --badge-bg: rgba(168, 85, 247, 0.12);
            --badge-color: #c084fc;
            --badge-border: rgba(168, 85, 247, 0.25);
            --icon-color: #94a3b8;
        }
        [data-bs-theme="light"] {
            --bg-color: #f1f5f9;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --grad-start: #4f46e5;
            --grad-end: #7c3aed;
            --neon-glow: rgba(124, 58, 237, 0.2);
            --border-color: rgba(0, 0, 0, 0.07);
            --badge-bg: rgba(124, 58, 237, 0.08);
            --badge-color: #6d28d9;
            --badge-border: rgba(124, 58, 237, 0.18);
            --icon-color: #64748b;
        }

        *, *::before, *::after {
            margin: 0; padding: 0; box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100dvh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s, color 0.3s;
            padding: env(safe-area-inset-top, 16px) 16px env(safe-area-inset-bottom, 16px);
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: radial-gradient(ellipse 60% 50% at 50% 40%, var(--neon-glow) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 480px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: clamp(28px, 6vw, 48px) clamp(20px, 5vw, 40px);
            text-align: center;
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 32px;
        }

        .logo-bars {
            display: flex;
            align-items: flex-end;
            gap: 3px;
            height: 22px;
        }

        .bar {
            width: 4px;
            background: linear-gradient(180deg, var(--grad-start), var(--grad-end));
            border-radius: 10px;
            animation: wave 1.6s ease-in-out infinite;
        }
        .bar:nth-child(1) { height: 11px; animation-delay: 0s; }
        .bar:nth-child(2) { height: 22px; animation-delay: 0.2s; }
        .bar:nth-child(3) { height: 16px; animation-delay: 0.4s; }

        @keyframes wave {
            0%, 100% { transform: scaleY(1); }
            50% { transform: scaleY(0.55); }
        }

        .logo-name {
            font-size: clamp(20px, 5vw, 26px);
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-main);
        }
        .logo-name span { color: var(--grad-start); font-weight: 400; }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 5px 14px;
            background: var(--badge-bg);
            color: var(--badge-color);
            border: 1px solid var(--badge-border);
            border-radius: 100px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: clamp(18px, 4.5vw, 26px);
            font-weight: 700;
            line-height: 1.35;
            margin-bottom: 14px;
            letter-spacing: -0.3px;
        }

        .desc {
            color: var(--text-muted);
            font-size: clamp(13px, 3.5vw, 15px);
            line-height: 1.65;
            margin-bottom: 32px;
        }

        /* Progress */
        .progress-wrap {
            width: 100%;
            height: 5px;
            background: var(--border-color);
            border-radius: 100px;
            overflow: hidden;
            margin-bottom: 8px;
        }
        .progress-bar {
            width: 75%;
            height: 100%;
            background: linear-gradient(90deg, var(--grad-start), var(--grad-end));
            border-radius: 100px;
        }
        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: var(--text-muted);
            margin-bottom: 28px;
        }

        /* Status grid */
        .status-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 28px;
        }

        .status-item {
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 14px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .status-title {
            font-size: 11px;
            color: var(--text-muted);
            letter-spacing: 0.3px;
        }

        .status-value {
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .dot {
            width: 7px; height: 7px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 6px #10b981;
            animation: blink 1.6s infinite;
            flex-shrink: 0;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.35; }
        }

        /* Footer */
        .footer {
            font-size: 11px;
            color: var(--text-muted);
        }

        /* Theme toggle */
        .theme-btn {
            position: fixed;
            top: max(16px, env(safe-area-inset-top));
            right: 16px;
            width: 40px; height: 40px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 100;
            transition: transform 0.2s;
            color: var(--icon-color);
            font-size: 15px;
        }
        .theme-btn:active { transform: scale(0.92); }
    </style>
</head>
<body>

    <button class="theme-btn" onclick="toggleTheme()" aria-label="Tema değiştir">
        <i class="fa-solid fa-moon" id="theme-icon"></i>
    </button>

    <div class="card">
        <div class="logo">
            <div class="logo-bars">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <h1 class="logo-name">artirdim<span>.com</span></h1>
        </div>

        <div class="badge">CANLI MÜZAYEDE SİSTEMİ</div>
        <h2>Çekici Deneyimler İçin Alanı Güncelliyoruz</h2>
        <p class="desc">Daha hızlı, güvenli ve kusursuz bir canlı açık artırma deneyimi için sistemimizi bakıma aldık. Kısa süre sonra çekiç yeniden vurulacak!</p>

        <div class="progress-wrap">
            <div class="progress-bar"></div>
        </div>
        <div class="progress-label">
            <span>İlerleme</span>
            <span>%75</span>
        </div>

        <div class="status-grid">
            <div class="status-item">
                <span class="status-title">Durum</span>
                <span class="status-value"><span class="dot"></span>Optimizasyon</span>
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
        document.addEventListener("DOMContentLoaded", () => {
            applyTheme(localStorage.getItem('theme') || 'dark');
        });
        function applyTheme(theme) {
            document.documentElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);
            document.getElementById('theme-icon').className = theme === 'light' ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
        }
        function toggleTheme() {
            applyTheme(document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark');
        }
    </script>
</body>
</html>
