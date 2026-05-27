@extends('layouts.app')
@section('title', 'Düzenle — ' . $category->name)
@section('content')

<div class="pf-root">

    <div class="pf-top">
        <div class="pf-cover"></div>

        <div class="pf-identity">
            <div class="pf-avatar-wrap">
                <div class="pf-avatar-outer" style="border-radius:18px;">
                    <img src="{{ $category->image_url }}"
                         alt="{{ $category->name }}"
                         class="pf-avatar-img"
                         id="heroImg"
                         style="border-radius:16px;">
                </div>
            </div>
            <div class="pf-identity-right">
                <div>
                    <div class="pf-uname-row">
                        <span class="pf-uname" id="heroName">{{ $category->name }}</span>
                        @if($category->is_active)
                            <span class="pf-role-badge" style="background:rgba(16,185,129,.15);border-color:rgba(16,185,129,.25);color:#10b981;">✓ Aktif</span>
                        @else
                            <span class="pf-role-badge" style="background:rgba(251,191,36,.15);border-color:rgba(251,191,36,.25);color:#fbbf24;">⏸ Pasif</span>
                        @endif
                    </div>
                    <div class="pf-handle" id="heroSlug">/{{ $category->slug }}</div>
                    <div class="pf-bio">
                        {{ $category->auctions_count }} ilan · {{ $category->children_count }} alt kategori
                    </div>
                </div>
            </div>
        </div>

        <div class="pf-action-row" style="justify-content:space-between;flex-wrap:wrap;gap:10px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size:12px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color:var(--primary)">Admin</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}" style="color:var(--primary)">Kategoriler</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.show', $category) }}" style="color:var(--primary)">{{ $category->name }}</a></li>
                    <li class="breadcrumb-item active" style="color:var(--muted)">Düzenle</li>
                </ol>
            </nav>
            <a href="{{ route('admin.categories.show', $category) }}" class="pf-btn-reset" style="height:36px;padding:0 14px;display:flex;align-items:center;gap:6px;text-decoration:none;">
                <i class="bi bi-arrow-left"></i> Geri
            </a>
        </div>
    </div>

    <div class="pf-edit-drawer open">

        <div class="pf-edit-tabs">
            <button class="pf-etab active" onclick="switchETab('genel',this)">
                <i class="bi bi-grid me-1"></i> Genel
            </button>
            <button class="pf-etab" onclick="switchETab('gorsel',this)">
                <i class="bi bi-image me-1"></i> Görsel & Açıklama
            </button>
            <button class="pf-etab" onclick="switchETab('ayarlar',this)">
                <i class="bi bi-sliders me-1"></i> Ayarlar
            </button>
        </div>

        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data" id="categoryForm">
            @csrf @method('PUT')

            @if($errors->any())
            <div class="pf-alert-success" style="background:rgba(248,113,113,.1);border-color:rgba(248,113,113,.3);margin:16px 24px 0;">
                <i class="bi bi-exclamation-circle-fill" style="color:#f87171;"></i>
                <span style="color:#f87171;">
                    @foreach($errors->all() as $err){{ $err }}@if(!$loop->last) · @endif @endforeach
                </span>
            </div>
            @endif

            <div id="ep-genel" class="pf-epanel active">

                <div class="pf-field">
                    <label class="pf-label">Kategori Adı <span class="pf-req">*</span></label>
                    <input class="pf-input" type="text" name="name" id="catName"
                           value="{{ old('name', $category->name) }}"
                           placeholder="Kategori adı"
                           oninput="livePreviewName(this.value)">
                    @error('name') <div class="pf-error">{{ $message }}</div> @enderror
                </div>

                <div class="pf-field">
                    <label class="pf-label">Slug</label>
                    <div class="pf-input-pre">
                        <span class="pf-pre-label">/</span>
                        <input type="text" name="slug" id="catSlug"
                               value="{{ old('slug', $category->slug) }}"
                               maxlength="191"
                               oninput="livePreviewSlug(this.value)">
                    </div>
                    <div class="pf-hint">Değiştirmezsen ad güncellendiğinde otomatik üretilir.</div>
                    @error('slug') <div class="pf-error">{{ $message }}</div> @enderror
                </div>

                <div class="pf-field">
                    <label class="pf-label">Üst Kategori</label>
                    <select name="parent_id" class="pf-input">
                        <option value="">— Ana Kategori (yok) —</option>
                        @foreach($parents as $parent)
                            @php
                                $indent = $parent->parent_id ? '&nbsp;&nbsp;&nbsp;📂 ' : '📁 ';
                            @endphp
                            <option value="{{ $parent->id }}"
                                {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                {!! $indent !!}{{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id') <div class="pf-error">{{ $message }}</div> @enderror
                </div>

            </div>

            <div id="ep-gorsel" class="pf-epanel">

                <div class="pf-avatar-upload-row">
                    <label for="image" class="pf-upload-avatar" style="cursor:pointer;border-radius:12px;" title="Görsel değiştir">
                        <img src="{{ $category->image_url }}"
                             alt="{{ $category->name }}" id="imgPreview"
                             style="width:100%;height:100%;object-fit:cover;border-radius:12px;">
                        <input type="file" id="image" name="image" accept=".png,.jpg,.jpeg,.webp" class="d-none">
                    </label>
                    <div>
                        <div class="pf-upload-title">Kategori görseli</div>
                        <div class="pf-upload-desc">PNG, JPG, WEBP · Maks. 2MB</div>
                        <label for="image" class="pf-btn-photo mt-2 d-inline-flex align-items-center gap-1" style="cursor:pointer;">
                            <i class="bi bi-upload"></i> Görsel değiştir
                        </label>
                        @if($category->image)
                        <div class="pf-hint mt-1">Mevcut görsel korunur, yeni yüklersen değişir.</div>
                        @endif
                    </div>
                </div>
                @error('image') <div class="pf-error mt-1">{{ $message }}</div> @enderror

                <div class="pf-field mt-3">
                    <label class="pf-label">Açıklama</label>
                    <div style="position:relative;">
                        <textarea class="pf-input" name="description" rows="4"
                                  maxlength="1000"
                                  oninput="descCount(this)"
                                  placeholder="Kategori hakkında kısa açıklama...">{{ old('description', $category->description) }}</textarea>
                        <span id="desc_counter" class="pf-char-cnt">{{ strlen(old('description', $category->description ?? '')) }}/1000</span>
                    </div>
                    @error('description') <div class="pf-error">{{ $message }}</div> @enderror
                </div>

            </div>

            <div id="ep-ayarlar" class="pf-epanel">

                <div class="pf-field">
                    <label class="pf-label">Sıralama</label>
                    <input class="pf-input" type="number" name="sort_order"
                           value="{{ old('sort_order', $category->sort_order) }}"
                           min="0" max="9999" placeholder="0">
                    <div class="pf-hint">Küçük değer öne gelir.</div>
                    @error('sort_order') <div class="pf-error">{{ $message }}</div> @enderror
                </div>

                <div class="pf-toggle-list">
                    <label class="pf-trow" style="border-bottom:none;">
                        <div class="pf-trow-info">
                            <div class="pf-trow-title">Kategori Aktif</div>
                            <div class="pf-trow-desc">Pasif kategoriler sitede görünmez</div>
                        </div>
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="pf-tog-input"
                               {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                    </label>
                </div>

            </div>

            <div class="pf-footer">
                <span class="pf-save-info">
                    <i class="bi bi-clock"></i> Son güncelleme: {{ $category->updated_at->diffForHumans() }}
                </span>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.categories.show', $category) }}" class="pf-btn-reset">İptal</a>
                    <button type="submit" class="pf-btn-save" id="saveBtn">
                        <i class="bi bi-floppy me-1"></i> Kaydet
                    </button>
                </div>
            </div>

        </form>
    </div>

</div>

@endsection

@push('scripts')
<script>
function switchETab(key, btn) {
    document.querySelectorAll('.pf-etab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.pf-epanel').forEach(p => p.classList.remove('active'));
    document.getElementById('ep-' + key).classList.add('active');
}

function livePreviewName(val) {
    const el = document.getElementById('heroName');
    if (el) el.textContent = val || '{{ addslashes($category->name) }}';
}

function livePreviewSlug(val) {
    const el = document.getElementById('heroSlug');
    if (el) el.textContent = '/' + (val || '{{ addslashes($category->slug) }}');
}

function descCount(el) {
    const c = document.getElementById('desc_counter');
    if (c) c.textContent = el.value.length + '/1000';
}

document.getElementById('image')?.addEventListener('change', function () {
    if (!this.files?.[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        ['heroImg', 'imgPreview'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.src = e.target.result;
        });
    };
    reader.readAsDataURL(this.files[0]);
});

document.getElementById('categoryForm')?.addEventListener('submit', function () {
    const btn = document.getElementById('saveBtn');
    if (btn) { btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Kaydediliyor...'; }
});
</script>
@endpush
