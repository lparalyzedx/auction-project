@extends('layouts.app')
@section('title', 'Talep #' . $ticket->id)

@section('content')
<div class="container-fluid py-3 pf-narrow-xl">

    <div class="admin-toolbar mb-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <div class="toolbar-title">Talep #{{ $ticket->id }} — {{ Str::limit($ticket->subject, 50) }}</div>
                <nav><ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.support.index') }}" class="pf-breadcrumb-link">Destek</a></li>
                    <li class="breadcrumb-item active">#{{ $ticket->id }}</li>
                </ol></nav>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="a-badge {{ $ticket->priorityBadge() }}">{{ $ticket->priorityLabel() }}</span>
                <span class="a-badge {{ $ticket->statusBadge() }}">{{ $ticket->statusLabel() }}</span>
                <form action="{{ route('admin.support.status', $ticket) }}" method="POST" class="m-0">
                    @csrf @method('PATCH')
                    <select name="status" class="admin-filter-select" onchange="this.form.submit()">
                        <option value="open"        {{ $ticket->status=='open'        ?'selected':'' }}>Açık</option>
                        <option value="in_progress" {{ $ticket->status=='in_progress' ?'selected':'' }}>İşlemde</option>
                        <option value="closed"      {{ $ticket->status=='closed'      ?'selected':'' }}>Kapalı</option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert-au success mb-3">{{ session('success') }}</div>
    @endif

    <div class="row g-3">

        <div class="col-lg-8">
            <div class="admin-card mb-3">
                <div class="admin-card-head">
                    <div class="admin-card-title"><i class="bi bi-chat-dots"></i> Konuşma</div>
                    <span class="a-badge info" id="msg-count">{{ $ticket->messages->count() }} mesaj</span>
                </div>
                <div class="p-4" id="msg-list">
                    @foreach($ticket->messages as $msg)
                    <div class="msg-bubble {{ $msg->is_admin ? 'admin' : '' }}">
                        <img class="msg-avatar"
                             src="{{ asset('storage/'.$msg->user->avatar) }}"
                             alt="{{ $msg->user->name }}">
                        <div class="msg-body">
                            <div class="msg-text">{{ $msg->body }}</div>
                            <div class="msg-meta">
                                {{ $msg->is_admin ? '🛡 Destek Ekibi ('.$msg->user->name.')' : $msg->user->name }}
                                · {{ $msg->created_at->format('d.m.Y H:i') }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            @if(!$ticket->isClosed())
            <div class="admin-card">
                <div class="admin-card-head">
                    <div class="admin-card-title"><i class="bi bi-reply"></i> Yanıtla</div>
                </div>
                <div class="p-4">
                    <form id="reply-form">
                        @csrf
                        <textarea name="body" id="reply-body"
                                  class="pf-input mb-3"
                                  rows="6"
                                  placeholder="Kullanıcıya yanıtınızı yazın..."
                                  maxlength="3000"></textarea>
                        <div class="pf-error mb-2 d-none" id="reply-error"></div>
                        <button type="submit" class="btn-admin-pri" id="reply-btn">
                            <i class="bi bi-send"></i> Yanıt Gönder
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="admin-card mb-3">
                <div class="admin-card-head">
                    <div class="admin-card-title"><i class="bi bi-person"></i> Kullanıcı</div>
                </div>
                <div class="p-1">
                    <div class="admin-info-row px-3">
                        <div class="admin-info-icon"><i class="bi bi-person"></i></div>
                        <div>
                            <div class="admin-info-lbl">Ad Soyad</div>
                            <div class="admin-info-val">{{ $ticket->user->name }}</div>
                        </div>
                    </div>
                    <div class="admin-info-row px-3">
                        <div class="admin-info-icon"><i class="bi bi-envelope"></i></div>
                        <div>
                            <div class="admin-info-lbl">E-posta</div>
                            <div class="admin-info-val">{{ $ticket->user->email }}</div>
                        </div>
                    </div>
                    <div class="admin-info-row px-3">
                        <div class="admin-info-icon"><i class="bi bi-calendar3"></i></div>
                        <div>
                            <div class="admin-info-lbl">Üyelik</div>
                            <div class="admin-info-val">{{ $ticket->user->created_at->format('d.m.Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-head">
                    <div class="admin-card-title"><i class="bi bi-info-circle"></i> Talep Detayı</div>
                </div>
                <div class="p-1">
                    <div class="admin-info-row px-3">
                        <div class="admin-info-icon"><i class="bi bi-hash"></i></div>
                        <div>
                            <div class="admin-info-lbl">Talep No</div>
                            <div class="admin-info-val">#{{ $ticket->id }}</div>
                        </div>
                    </div>
                    <div class="admin-info-row px-3">
                        <div class="admin-info-icon"><i class="bi bi-tag"></i></div>
                        <div>
                            <div class="admin-info-lbl">Kategori</div>
                            <div class="admin-info-val">{{ ucfirst($ticket->category) }}</div>
                        </div>
                    </div>
                    <div class="admin-info-row px-3">
                        <div class="admin-info-icon"><i class="bi bi-flag"></i></div>
                        <div>
                            <div class="admin-info-lbl">Öncelik</div>
                            <div class="admin-info-val">
                                <span class="a-badge {{ $ticket->priorityBadge() }}">{{ $ticket->priorityLabel() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="admin-info-row px-3">
                        <div class="admin-info-icon"><i class="bi bi-calendar-plus"></i></div>
                        <div>
                            <div class="admin-info-lbl">Açıldı</div>
                            <div class="admin-info-val">{{ $ticket->created_at->format('d.m.Y H:i') }}</div>
                        </div>
                    </div>
                    <div class="admin-info-row px-3">
                        <div class="admin-info-icon"><i class="bi bi-clock-history"></i></div>
                        <div>
                            <div class="admin-info-lbl">Son Güncelleme</div>
                            <div class="admin-info-val">{{ $ticket->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
$(function () {
    const replyUrl = '{{ route('admin.support.reply', $ticket) }}';
    let msgCount = {{ $ticket->messages->count() }};

    function buildBubble(body, name, time, avatar) {
        const imgSrc = avatar
            ? avatar
            : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(name) + '&size=34&background=9146ff&color=fff';

        return `
        <div class="msg-bubble admin">
            <img class="msg-avatar" src="${imgSrc}" alt="${$('<div>').text(name).html()}">
            <div class="msg-body">
                <div class="msg-text">${$('<div>').text(body).html()}</div>
                <div class="msg-meta">🛡 Destek Ekibi (${$('<div>').text(name).html()}) · ${time}</div>
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
                $('#reply-btn').prop('disabled', false).html('<i class="bi bi-send"></i> Yanıt Gönder');
            }
        });
    });
});
</script>
@endpush
