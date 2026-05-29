<!DOCTYPE html>
<html lang="tr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>404 - Sayfa Bulunamadı | artirdim.com</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        [data-bs-theme="dark"] {
            --bg-color: #0b0e14;
            --card-bg: #11151d;
            --text-main: #ffffff;
            --text-muted: #788294;
            --grad-start: #6366f1;
            --grad-end: #a855f7;
            --neon-glow: rgba(168, 85, 247, 0.3);
            --border-color: rgba(255, 255, 255, 0.06);
            --btn-ghost-hover: rgba(255, 255, 255, 0.04);
            --icon-color: #94a3b8;
        }
        [data-bs-theme="light"] {
            --bg-color: #f1f5f9;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --grad-start: #4f46e5;
            --grad-end: #7c3aed;
            --neon-glow: rgba(124, 58, 237, 0.18);
            --border-color: rgba(0, 0, 0, 0.07);
            --btn-ghost-hover: rgba(0, 0, 0, 0.03);
            --icon-color: #64748b;
        }

        *, *::before, *::after {
            margin: 0; padding: 0; box-sizing: border-box;
        }

        html, body { height: 100%; }

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
            max-width: 460px;
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
            margin-bottom: 28px;
        }
        .logo-bars {
            display: flex;
            align-items: flex-end;
            gap: 3px;
            height: 20px;
        }
        .bar {
            width: 3.5px;
            background: linear-gradient(180deg, var(--grad-start), var(--grad-end));
            border-radius: 10px;
        }
        .bar:nth-child(1) { height: 10px; }
        .bar:nth-child(2) { height: 20px; }
        .bar:nth-child(3) { height: 14px; }

        .logo-name {
            font-size: clamp(18px, 4.5vw, 22px);
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-main);
        }
        .logo-name span { color: var(--grad-start); font-weight: 400; }

        /* 404 */
        .error-code {
            font-size: clamp(72px, 22vw, 110px);
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, var(--grad-start), var(--grad-end));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -2px;
            margin-bottom: 12px;
        }

        h2 {
            font-size: clamp(17px, 4.5vw, 22px);
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: 12px;
        }

        .desc {
            color: var(--text-muted);
            font-size: clamp(13px, 3.5vw, 15px);
            line-height: 1.65;
            margin-bottom: 32px;
        }

        /* Buttons */
        .actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 13px 16px;
            font-size: clamp(13px, 3.5vw, 14px);
            font-weight: 600;
            border-radius: 12px;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
            -webkit-tap-highlight-color: transparent;
            min-height: 48px;
        }
        .btn:active { transform: scale(0.96); }

        .btn-primary {
            background: linear-gradient(135deg, var(--grad-start), var(--grad-end));
            color: #fff;
            border: none;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.28);
        }

        .btn-secondary {
            background: transparent;
            color: var(--text-main);
            border: 1px solid var(--border-color);
        }
        .btn-secondary:hover { background: var(--btn-ghost-hover); }

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
            color: var(--icon-color);
            font-size: 15px;
            transition: transform 0.2s;
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

        <div class="error-code">404</div>
        <h2>Aradığınız Sayfa Bulunamadı!</h2>
        <p class="desc">Görünüşe göre bu sayfa yayından kalkmış, adresi değişmiş ya da çekiç yanlış yere vurulmuş.</p>

        <div class="actions">
            <a href="/" class="btn btn-primary">
                <i class="fa-solid fa-gavel"></i> Ana Sayfa
            </a>
            <button onclick="window.history.back()" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Geri Dön
            </button>
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
