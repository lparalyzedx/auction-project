@extends('layouts.app')
@section('title', '404 - Sayfa Bulunamadı')

@section('content')

<div class="error-wrap">

    <div class="error-card">

        <div class="error-code">404</div>

        <h1 class="error-title">Sayfa bulunamadı</h1>

        <p class="error-desc">
            Aradığın sayfa kaldırılmış, taşınmış ya da hiç var olmamış olabilir.
        </p>

        <div class="error-path">
            <span>Path:</span> {{ request()->path() }}
        </div>

        <div class="error-actions">
            <a href="{{ route('index') }}" class="btn-primary">
                🏠 Ana sayfa
            </a>

            <button onclick="history.back()" class="btn-secondary">
                ← Geri dön
            </button>
        </div>

    </div>

</div>

@endsection


@push('styles')
<style>
:root {
    --bg: #0f1115;
    --card: #151821;
    --text: #e5e7eb;
    --muted: #9ca3af;
    --border: rgba(255,255,255,0.08);
    --primary: #6366f1;
}

/* LIGHT MODE OVERRIDE (eğer body.light class varsa) */
body.light {
    --bg: #f5f6fa;
    --card: #ffffff;
    --text: #111827;
    --muted: #6b7280;
    --border: rgba(0,0,0,0.08);
}

.error-wrap {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    background: var(--bg);
}

.error-card {
    width: 100%;
    max-width: 460px;
    text-align: center;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 2.5rem 2rem;
    box-shadow: 0 20px 60px rgba(0,0,0,0.25);
    animation: fadeUp .25s ease;
}

.error-code {
    font-size: 92px;
    font-weight: 900;
    letter-spacing: -3px;
    line-height: 1;
    background: linear-gradient(135deg, var(--primary), #a78bfa);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.error-title {
    margin-top: 10px;
    font-size: 22px;
    font-weight: 700;
    color: var(--text);
}

.error-desc {
    margin-top: 10px;
    font-size: 14px;
    color: var(--muted);
    line-height: 1.6;
}

.error-path {
    margin-top: 16px;
    font-size: 12px;
    color: var(--muted);
    padding: 10px 12px;
    border: 1px dashed var(--border);
    border-radius: 10px;
    display: inline-block;
}

.error-path span {
    color: var(--primary);
    font-weight: 600;
}

.error-actions {
    margin-top: 22px;
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-primary {
    background: var(--primary);
    color: #fff;
    padding: 10px 16px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: 0.2s;
}

.btn-primary:hover {
    opacity: 0.85;
    transform: translateY(-1px);
}

.btn-secondary {
    background: transparent;
    color: var(--text);
    border: 1px solid var(--border);
    padding: 10px 16px;
    border-radius: 10px;
    font-size: 14px;
    cursor: pointer;
    transition: 0.2s;
}

.btn-secondary:hover {
    border-color: var(--primary);
    color: var(--primary);
}

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush
