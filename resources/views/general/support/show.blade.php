@extends('layouts.app')
@section('title', 'Talep #' . $ticket->id)

@section('content')
<div class="container py-4 pf-narrow-lg">

    <div class="admin-toolbar mb-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <div class="toolbar-title">{{ Str::limit($ticket->subject, 60) }}</div>
                <nav><ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}" class="pf-breadcrumb-link">Ana Sayfa</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('support.index') }}" class="pf-breadcrumb-link">Destek</a></li>
                    <li class="breadcrumb-item active">#{{ $ticket->id }}</li>
                </ol></nav>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="a-badge {{ $ticket->priorityBadge() }}">{{ $ticket->priorityLabel() }}</span>
                <span class="a-badge {{ $ticket->statusBadge() }}">{{ $ticket->statusLabel() }}</span>
            </div>
        </div>
    </div>

    <div class="admin-card mb-3">
        <div class="admin-card-head">
            <div class="admin-card-title"><i class="bi bi-chat-dots"></i> Konuşma</div>
            <span class="a-badge info" id="msg-count">{{ $ticket->messages->count() }} mesaj</span>
        </div>
        <div class="p-4" id="msg-list">
            @foreach($ticket->messages as $msg)
            <div class="msg-bubble {{ $msg->is_admin ? 'admin' : '' }}">
                <img class="msg-avatar"
                     src="{{ asset('storage/'.$msg->user->avatar)}}"
                     alt="{{ $msg->user->name }}">
                <div class="msg-body">
                    <div class="msg-text">{{ $msg->body }}</div>
                    <div class="msg-meta">
                        {{ $msg->is_admin ? 'Destek Ekibi' : $msg->user->name }}
                        · {{ $msg->created_at->format('d.m.Y H:i') }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @if($ticket->isOpen())
    <div class="admin-card mb-3">
        <div class="admin-card-head">
            <div class="admin-card-title"><i class="bi bi-reply"></i> Yanıtla</div>
        </div>
        <div class="p-4">
            <form id="reply-form">
                @csrf
                <textarea name="body" id="reply-body"
                          class="pf-input mb-3"
                          rows="5"
                          placeholder="Yanıtınızı yazın..."
                          maxlength="3000"></textarea>
                <div class="pf-error mb-2 d-none" id="reply-error"></div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2" id="reply-btn">
                        <i class="bi bi-send"></i> Gönder
                    </button>
                    <form action="{{ route('support.close', $ticket) }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary d-flex align-items-center gap-2"
                                onclick="return confirm('Talebi kapatmak istediğinize emin misiniz?')">
                            <i class="bi bi-x-circle"></i> Talebi Kapat
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
    @else
    <div class="alert-au danger d-flex align-items-center gap-2 mb-3">
        <i class="bi bi-lock"></i>
        Bu talep kapatılmış. Yeni sorun için
        <a href="{{ route('support.create') }}" class="fw-bold">yeni talep açın</a>.
    </div>
    @endif

    <div class="admin-card">
        <div class="admin-card-head">
            <div class="admin-card-title"><i class="bi bi-book"></i> Yardım Makaleleri</div>
        </div>
        <div class="p-3">
            @foreach([
                ['Talebime ne zaman yanıt gelecek?', 'Yüksek öncelikli talepler 2-4 saat içinde, diğerleri 1 iş günü içinde yanıtlanır. Yanıt geldiğinde e-posta ile bilgilendirilirsiniz.'],
                ['Yanıtımı göremiyorum, ne yapmalıyım?', 'Sayfayı yenileyin. Sorun devam ederse spam/junk klasörünüzü kontrol edin. Hesap e-postanızın doğru olduğundan emin olun.'],
                ['Talebimi yanlış kategoriye mi açtım?', 'Yanlış kategori yanıt süresini yavaşlatabilir. Talebi kapatıp doğru kategori ile yeni bir talep açmanızı öneririz.'],
                ['Ödeme sorunum için ne yapmalıyım?', '"Ödeme / Fatura" kategorisinde yüksek öncelikli bir talep oluşturun. Fatura veya işlem numaranızı açıklamaya eklemeniz süreci hızlandırır.'],
            ] as [$soru, $cevap])
            <div class="support-faq-item">
                <button class="support-faq-btn" type="button" data-faq>
                    <span>{{ $soru }}</span>
                    <i class="bi bi-chevron-down support-faq-icon"></i>
                </button>
                <div class="support-faq-body">
                    <p class="pf-hint mb-0">{{ $cevap }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
$(function () {
    const replyUrl = '{{ route('support.reply', $ticket) }}';
    let msgCount = {{ $ticket->messages->count() }};

    function buildBubble(body, name, time, isAdmin, avatar) {
        const bg     = isAdmin ? '9146ff' : '10b981';
        const side   = isAdmin ? 'admin' : '';
        const sender = isAdmin ? 'Destek Ekibi' : $('<div>').text(name).html();
        const imgSrc = avatar
            ? avatar
            : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(name) + '&size=34&background=' + bg + '&color=fff';

        return `
        <div class="msg-bubble ${side}">
            <img class="msg-avatar" src="${imgSrc}" alt="${$('<div>').text(name).html()}">
            <div class="msg-body">
                <div class="msg-text">${$('<div>').text(body).html()}</div>
                <div class="msg-meta">${sender} · ${time}</div>
            </div>
        </div>`;
    }

    $('#reply-form').on('submit', function (e) {
        e.preventDefault();

        const body = $('#reply-body').val().trim();
        if (!body) return;

        $('#reply-error').addClass('d-none').text('');
        $('#reply-btn').prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Gönderiliyor...');

        $.ajax({
            url: replyUrl,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                body: body,
            },
            success: function (res) {
                $('#reply-body').val('');
                $('#msg-list').append(buildBubble(
                    res.message.body,
                    res.message.user,
                    res.message.time,
                    res.message.is_admin,
                    res.message.avatar
                ));
                msgCount++;
                $('#msg-count').text(msgCount + ' mesaj');
                const list = $('#msg-list');
                list.scrollTop(list.prop('scrollHeight'));
            },
            error: function (xhr) {
                const err = xhr.responseJSON?.errors?.body?.[0] ?? 'Bir hata oluştu, tekrar deneyin.';
                $('#reply-error').removeClass('d-none').text(err);
            },
            complete: function () {
                $('#reply-btn').prop('disabled', false).html('<i class="bi bi-send"></i> Gönder');
            }
        });
    });

    document.querySelectorAll('[data-faq]').forEach(btn => {
        btn.addEventListener('click', () => {
            const item = btn.closest('.support-faq-item');
            const isOpen = item.classList.contains('open');
            document.querySelectorAll('.support-faq-item.open').forEach(el => el.classList.remove('open'));
            if (!isOpen) item.classList.add('open');
        });
    });
});
</script>
@endpush
