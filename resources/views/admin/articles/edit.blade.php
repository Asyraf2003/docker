<x-page.admin>
  <div class="page-heading">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h3 class="mb-1">Edit Artikel</h3>
        <p class="text-muted mb-0">Ubah artikel multi-bahasa, gambar hero, & sections</p>
      </div>
      <a href="{{ route('admin.articles.index') }}" class="btn btn-light">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>
    </div>

    <div class="card">
      <div class="card-body">
        @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
          <div class="alert alert-danger">
            <div class="fw-semibold mb-2">Gagal menyimpan artikel:</div>
            <ul class="mb-0">
              @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data" id="articleForm">
          @csrf
          @method('PUT')

          {{-- ====== JUDUL & SLUG ====== --}}
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Judul (ID) <span class="text-danger">*</span></label>
              <input name="title_id" class="form-control @error('title_id') is-invalid @enderror"
                     value="{{ old('title_id', $article->title_id) }}" required>
              @error('title_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
              <label class="form-label">Title (EN) <span class="text-danger">*</span></label>
              <input name="title_en" class="form-control @error('title_en') is-invalid @enderror"
                     value="{{ old('title_en', $article->title_en) }}" required>
              @error('title_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
              <label class="form-label">العنوان (AR) <span class="text-danger">*</span></label>
              <input name="title_ar" class="form-control @error('title_ar') is-invalid @enderror" dir="rtl"
                     value="{{ old('title_ar', $article->title_ar) }}" required>
              @error('title_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">Slug</label>
              <div class="input-group">
                <input name="slug" id="slugInput" class="form-control @error('slug') is-invalid @enderror"
                       value="{{ old('slug', $article->slug) }}" placeholder="biarkan untuk tetap pakai slug lama">
                <button class="btn btn-outline-secondary" type="button" id="btnGenSlug">Generate</button>
              </div>
              @error('slug')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
              <div class="form-text">Jika diubah, server akan memastikan slug unik.</div>
            </div>

            <div class="col-md-6">
              <label class="form-label">Hero Image (kosongkan jika tidak diganti)</label>
              <input type="file" name="hero_image" accept="image/*" class="form-control @error('hero_image') is-invalid @enderror" id="heroInput">
              @error('hero_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
              <div class="mt-2">
                @php
                  $heroUrl = $article->hero_image
                    ? (\Illuminate\Support\Str::startsWith($article->hero_image, ['http://','https://'])
                        ? $article->hero_image
                        : \Illuminate\Support\Facades\Storage::url($article->hero_image))
                    : null;
                @endphp
                <img id="heroPreview" class="img-fluid rounded border {{ $heroUrl ? '' : 'd-none' }}" alt="Preview hero"
                     src="{{ $heroUrl ?? '' }}">
              </div>
            </div>
          </div>

          {{-- ====== EXCERPT ====== --}}
          <div class="row g-3 mt-2">
            <div class="col-md-4">
              <label class="form-label">Excerpt (ID)</label>
              <input name="excerpt_id" class="form-control" maxlength="300"
                     value="{{ old('excerpt_id', $article->excerpt_id) }}">
            </div>
            <div class="col-md-4">
              <label class="form-label">Excerpt (EN)</label>
              <input name="excerpt_en" class="form-control" maxlength="300"
                     value="{{ old('excerpt_en', $article->excerpt_en) }}">
            </div>
            <div class="col-md-4">
              <label class="form-label">الملخص (AR)</label>
              <input name="excerpt_ar" class="form-control" dir="rtl" maxlength="300"
                     value="{{ old('excerpt_ar', $article->excerpt_ar) }}">
            </div>
          </div>

          {{-- ====== META ====== --}}
          <div class="row g-3 mt-2">
            <div class="col-md-4">
              <label class="form-label">Meta Title (ID)</label>
              <input name="meta_title_id" class="form-control" maxlength="120"
                     value="{{ old('meta_title_id', $article->meta_title_id) }}">
              <label class="form-label mt-2">Meta Desc (ID)</label>
              <input name="meta_desc_id" class="form-control" maxlength="250"
                     value="{{ old('meta_desc_id', $article->meta_desc_id) }}">
            </div>
            <div class="col-md-4">
              <label class="form-label">Meta Title (EN)</label>
              <input name="meta_title_en" class="form-control" maxlength="120"
                     value="{{ old('meta_title_en', $article->meta_title_en) }}">
              <label class="form-label mt-2">Meta Desc (EN)</label>
              <input name="meta_desc_en" class="form-control" maxlength="250"
                     value="{{ old('meta_desc_en', $article->meta_desc_en) }}">
            </div>
            <div class="col-md-4">
              <label class="form-label">عنوان الميتا (AR)</label>
              <input name="meta_title_ar" class="form-control" dir="rtl" maxlength="120"
                     value="{{ old('meta_title_ar', $article->meta_title_ar) }}">
              <label class="form-label mt-2">وصف الميتا (AR)</label>
              <input name="meta_desc_ar" class="form-control" dir="rtl" maxlength="250"
                     value="{{ old('meta_desc_ar', $article->meta_desc_ar) }}">
            </div>
          </div>

          {{-- ====== STATUS & PENJADWALAN ====== --}}
          <div class="row g-3 mt-3">
            <div class="col-md-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-select">
                @foreach(['draft'=>'Draft','scheduled'=>'Scheduled','published'=>'Published','archived'=>'Archived'] as $val=>$lbl)
                  <option value="{{ $val }}" @selected(old('status', $article->status)===$val)>{{ $lbl }}</option>
                @endforeach
              </select>
              <div class="form-text">Gunakan <b>Scheduled</b> untuk terbit otomatis pada jadwal.</div>
            </div>
            <div class="col-md-3">
              <label class="form-label">Published At</label>
              <input type="datetime-local" name="published_at" class="form-control"
                     value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}">
            </div>
            <div class="col-md-3">
              <label class="form-label">Scheduled For</label>
              <input type="datetime-local" name="scheduled_for" class="form-control"
                     value="{{ old('scheduled_for', optional($article->scheduled_for)->format('Y-m-d\TH:i')) }}">
            </div>
            <div class="col-md-3">
              <label class="form-label">Published? (legacy)</label>
              <select name="is_published" class="form-select">
                <option value="0" @selected(old('is_published', (int)$article->is_published)==0)>Tidak</option>
                <option value="1" @selected(old('is_published', (int)$article->is_published)==1)>Ya</option>
              </select>
            </div>
          </div>

          {{-- ====== FEATURED / HOT / PINNED ====== --}}
          <div class="row g-3 mt-2">
            <div class="col-md-3">
              <label class="form-label">Featured</label>
              <select name="is_featured" class="form-select">
                <option value="0" @selected(old('is_featured', (int)$article->is_featured)==0)>Tidak</option>
                <option value="1" @selected(old('is_featured', (int)$article->is_featured)==1)>Ya</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Hot</label>
              <select name="is_hot" class="form-select" id="isHotSelect">
                <option value="0" @selected(old('is_hot', (int)$article->is_hot)==0)>Tidak</option>
                <option value="1" @selected(old('is_hot', (int)$article->is_hot)==1)>Ya</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Hot Until</label>
              <input type="datetime-local" name="hot_until" class="form-control" id="hotUntilInput"
                     value="{{ old('hot_until', optional($article->hot_until)->format('Y-m-d\TH:i')) }}">
              <div class="form-text">Kosongkan untuk tanpa batas.</div>
            </div>
            <div class="col-md-3">
              <label class="form-label">Pinned Until</label>
              <input type="datetime-local" name="pinned_until" class="form-control"
                     value="{{ old('pinned_until', optional($article->pinned_until)->format('Y-m-d\TH:i')) }}">
            </div>
          </div>

          {{-- ====== KATEGORI & TAG ====== --}}
          <div class="row g-3 mt-3">
            <div class="col-md-6">
              <label class="form-label">Kategori</label>
              <select class="form-select" name="category_ids[]" multiple>
                @php $selectedCats = collect(old('category_ids', $article->categories->pluck('id')->all())); @endphp
                @foreach(\App\Models\Category::orderBy('name_id')->get() as $cat)
                  <option value="{{ $cat->id }}" @selected($selectedCats->contains($cat->id))>
                    {{ $cat->name_id }}
                  </option>
                @endforeach
              </select>
              <div class="form-text">Tahan Ctrl / Cmd untuk pilih banyak.</div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tag</label>
              <input class="form-control" name="tag_slugs[]" placeholder="Tulis slug tag lalu Enter"
                     data-role="tag-input" data-prefill='@json(old("tag_slugs", $article->tags->pluck("slug")->all()))'>
              <div class="form-text">Atau sertakan `tag_ids[]` bila memilih dari daftar.</div>
            </div>
          </div>

          {{-- ====== SECTIONS ====== --}}
          <div class="card border-0 shadow-sm mt-4">
            <div class="card-header d-flex justify-content-between align-items-center bg-body-tertiary">
              <h5 class="card-title mb-0">Sections</h5>
              <button type="button" class="btn btn-primary" id="btnAddSection">
                <i class="bi bi-plus-lg me-1"></i> Tambah Section
              </button>
            </div>
            <div class="card-body" id="sectionsContainer">
              @php $sorted = $article->sections->sortBy('sort_order')->values(); @endphp
              @forelse ($sorted as $i => $sec)
                @php
                  $imgUrl = $sec->image_path ? \Illuminate\Support\Facades\Storage::url($sec->image_path) : '';
                @endphp
                <div class="border rounded-3 p-3 mb-3 section-item" data-index="{{ $i }}">
                  <input type="hidden" name="sections[{{ $i }}][id]" value="{{ $sec->id }}">
                  <input type="hidden" name="sections[{{ $i }}][delete]" value="0" class="field-delete">

                  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                      <span class="badge bg-primary-subtle text-body">#<span class="sec-number">{{ $i+1 }}</span></span>
                      <select class="form-select form-select-sm w-auto" name="sections[{{ $i }}][type]">
                        <option value="paragraph" @selected($sec->type==='paragraph')>Paragraph</option>
                        <option value="quote" @selected($sec->type==='quote')>Quote</option>
                        <option value="image_only" @selected($sec->type==='image_only')>Image Only</option>
                      </select>
                      <div class="input-group input-group-sm" style="width:160px;">
                        <span class="input-group-text">Urutan</span>
                        <input type="number" class="form-control sort-order" min="0"
                               name="sections[{{ $i }}][sort_order]" value="{{ $sec->sort_order ?? $i }}" required>
                      </div>
                    </div>
                    <div class="d-flex gap-1">
                      <button type="button" class="btn btn-outline-secondary btn-sm btnUp"><i class="bi bi-arrow-up"></i></button>
                      <button type="button" class="btn btn-outline-secondary btn-sm btnDown"><i class="bi bi-arrow-down"></i></button>
                      <button type="button" class="btn btn-danger btn-sm btnRemove"><i class="bi bi-trash me-1"></i> Hapus</button>
                    </div>
                  </div>

                  <div class="row g-2 body-fields" @if($sec->type==='image_only') style="display:none" @endif>
                    <div class="col-12 col-md-4">
                      <label class="form-label small">Isi (ID)</label>
                      <textarea rows="3" class="form-control" name="sections[{{ $i }}][body_id]">{{ $sec->body_id }}</textarea>
                    </div>
                    <div class="col-12 col-md-4">
                      <label class="form-label small">Content (EN)</label>
                      <textarea rows="3" class="form-control" name="sections[{{ $i }}][body_en]">{{ $sec->body_en }}</textarea>
                    </div>
                    <div class="col-12 col-md-4">
                      <label class="form-label small">المحتوى (AR)</label>
                      <textarea rows="3" class="form-control" dir="rtl" name="sections[{{ $i }}][body_ar]">{{ $sec->body_ar }}</textarea>
                    </div>
                  </div>

                  <div class="row g-2 mt-1">
                    <div class="col-12 col-md-6">
                      <label class="form-label small">Gambar (opsional)</label>
                      <input type="file" class="form-control" name="sections[{{ $i }}][image]">
                      <input type="hidden" name="sections[{{ $i }}][existing_image]" value="{{ $sec->image_path }}">
                      <div class="mt-2 small text-muted">
                        @if($imgUrl)
                          <span>Gambar saat ini:</span>
                          <a href="{{ $imgUrl }}" target="_blank" class="ms-1">lihat</a>
                          <span class="ms-2">•</span>
                          <label class="ms-2">
                            <input type="checkbox" class="form-check-input me-1" name="sections[{{ $i }}][remove_image]" value="1"> hapus gambar
                          </label>
                        @else
                          <em>Belum ada gambar</em>
                        @endif
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="row g-2">
                        <div class="col">
                          <label class="form-label small">Alt (ID)</label>
                          <input class="form-control" name="sections[{{ $i }}][image_alt_id]" value="{{ $sec->image_alt_id }}">
                        </div>
                        <div class="col">
                          <label class="form-label small">Alt (EN)</label>
                          <input class="form-control" name="sections[{{ $i }}][image_alt_en]" value="{{ $sec->image_alt_en }}">
                        </div>
                        <div class="col">
                          <label class="form-label small">Alt (AR)</label>
                          <input class="form-control" dir="rtl" name="sections[{{ $i }}][image_alt_ar]" value="{{ $sec->image_alt_ar }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @empty
                <div class="text-muted small" id="emptyHint">Belum ada section. Klik <b>Tambah Section</b> untuk menambah.</div>
              @endforelse
            </div>
          </div>

          {{-- ====== AKSI ====== --}}
          <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('admin.articles.index') }}" class="btn btn-light">Batal</a>
            <button class="btn btn-primary">
              <i class="bi bi-save me-1"></i> Simpan Perubahan
            </button>
          </div>
        </form>

        {{-- ====== TEMPLATE SECTION BARU ====== --}}
        <template id="sectionTemplate">
          <div class="border rounded-3 p-3 mb-3 section-item" data-index="__IDX__">
            <input type="hidden" name="sections[__IDX__][id]" value="">
            <input type="hidden" name="sections[__IDX__][delete]" value="0" class="field-delete">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
              <div class="d-flex align-items-center flex-wrap gap-2">
                <span class="badge bg-primary-subtle text-body">#<span class="sec-number">__NUM__</span></span>
                <select class="form-select form-select-sm w-auto" name="sections[__IDX__][type]">
                  <option value="paragraph">Paragraph</option>
                  <option value="quote">Quote</option>
                  <option value="image_only">Image Only</option>
                </select>
                <div class="input-group input-group-sm" style="width:160px;">
                  <span class="input-group-text">Urutan</span>
                  <input type="number" class="form-control sort-order" min="0" name="sections[__IDX__][sort_order]" value="__IDX__" required>
                </div>
              </div>
              <div class="d-flex gap-1">
                <button type="button" class="btn btn-outline-secondary btn-sm btnUp"><i class="bi bi-arrow-up"></i></button>
                <button type="button" class="btn btn-outline-secondary btn-sm btnDown"><i class="bi bi-arrow-down"></i></button>
                <button type="button" class="btn btn-danger btn-sm btnRemove"><i class="bi bi-trash me-1"></i> Hapus</button>
              </div>
            </div>
            <div class="row g-2 body-fields">
              <div class="col-12 col-md-4">
                <label class="form-label small">Isi (ID)</label>
                <textarea rows="3" class="form-control" name="sections[__IDX__][body_id]"></textarea>
              </div>
              <div class="col-12 col-md-4">
                <label class="form-label small">Content (EN)</label>
                <textarea rows="3" class="form-control" name="sections[__IDX__][body_en]"></textarea>
              </div>
              <div class="col-12 col-md-4">
                <label class="form-label small">المحتوى (AR)</label>
                <textarea rows="3" class="form-control" dir="rtl" name="sections[__IDX__][body_ar]"></textarea>
              </div>
            </div>
            <div class="row g-2 mt-1">
              <div class="col-12 col-md-6">
                <label class="form-label small">Gambar (opsional)</label>
                <input type="file" class="form-control" name="sections[__IDX__][image]">
              </div>
              <div class="col-12 col-md-6">
                <div class="row g-2">
                  <div class="col">
                    <label class="form-label small">Alt (ID)</label>
                    <input class="form-control" name="sections[__IDX__][image_alt_id]">
                  </div>
                  <div class="col">
                    <label class="form-label small">Alt (EN)</label>
                    <input class="form-control" name="sections[__IDX__][image_alt_en]">
                  </div>
                  <div class="col">
                    <label class="form-label small">Alt (AR)</label>
                    <input class="form-control" dir="rtl" name="sections[__IDX__][image_alt_ar]">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>

  {{-- ====== JS ENHANCEMENTS ====== --}}
  <script>
    // Preview hero
    document.addEventListener('DOMContentLoaded', function () {
      const input = document.getElementById('heroInput');
      const preview = document.getElementById('heroPreview');
      if (input && preview) {
        input.addEventListener('change', function (e) {
          const file = e.target.files && e.target.files[0];
          if (!file) { preview.classList.add('d-none'); preview.removeAttribute('src'); return; }
          const url = URL.createObjectURL(file);
          preview.src = url;
          preview.onload = () => URL.revokeObjectURL(url);
          preview.classList.remove('d-none');
        });
      }
    });

    // Slug generator
    (function() {
      const btn = document.getElementById('btnGenSlug');
      const slugInput = document.getElementById('slugInput');
      const titleId = document.querySelector('input[name="title_id"]');
      function slugit(str){
        return (str||'').toString().toLowerCase()
          .normalize('NFKD').replace(/[\u0300-\u036f]/g,'')
          .replace(/[^a-z0-9\s-]/g,'').trim().replace(/\s+/g,'-')
          .replace(/-+/g,'-').substring(0,120);
      }
      btn?.addEventListener('click', function(){
        const src = slugInput.value.trim() || (titleId ? titleId.value : '');
        slugInput.value = slugit(src) || '';
      });
    })();

    // Sections sort/up/down/remove + toggle body for image_only
    (function(){
      const container  = document.getElementById('sectionsContainer');
      const btnAdd     = document.getElementById('btnAddSection');
      const tpl        = document.getElementById('sectionTemplate').innerHTML;
      const emptyHint  = document.getElementById('emptyHint');
      let idx = container.querySelectorAll('.section-item').length || 0;

      function renderNumbers() {
        const items = container.querySelectorAll('.section-item');
        items.forEach((el, i) => {
          el.dataset.index = i;
          el.querySelector('.sec-number').textContent = i + 1;
          const order = el.querySelector('.sort-order');
          if (order) order.value = i;
          el.querySelectorAll('[name]').forEach(input => {
            input.name = input.name.replace(/sections\[\d+\]/g, `sections[${i}]`);
          });
        });
        if (emptyHint) emptyHint.classList.toggle('d-none', items.length > 0);
      }

      function addSection() {
        const html = tpl.replaceAll('__IDX__', idx).replaceAll('__NUM__', (idx + 1));
        const node = document.createElement('div');
        node.innerHTML = html;
        container.appendChild(node.firstElementChild);
        idx++; renderNumbers();
      }

      container.addEventListener('click', function(e){
        const btn = e.target.closest('button');
        if (!btn) return;
        const item = e.target.closest('.section-item');
        if (!item) return;

        if (btn.classList.contains('btnRemove')) {
          item.remove(); renderNumbers();
        }
        if (btn.classList.contains('btnUp')) {
          const prev = item.previousElementSibling;
          if (prev) { container.insertBefore(item, prev); renderNumbers(); }
        }
        if (btn.classList.contains('btnDown')) {
          const next = item.nextElementSibling;
          if (next) { container.insertBefore(next, item); renderNumbers(); }
        }
      });

      container.addEventListener('change', function(e){
        const sel = e.target;
        if (sel.tagName === 'SELECT' && sel.name.includes('[type]')) {
          const item = sel.closest('.section-item');
          const bodyFields = item.querySelector('.body-fields');
          if (bodyFields) bodyFields.style.display = (sel.value === 'image_only') ? 'none' : '';
        }
      });

      btnAdd?.addEventListener('click', addSection);
      renderNumbers();
    })();

    // Hot until disabled/enabled by is_hot
    (function(){
      const selHot = document.getElementById('isHotSelect');
      const hotUntil = document.getElementById('hotUntilInput');
      function toggleHotUntil(){
        const active = selHot && selHot.value === '1';
        if (hotUntil) {
          hotUntil.disabled = !active;
          hotUntil.closest('.col-md-3').style.opacity = active ? 1 : .6;
        }
      }
      selHot?.addEventListener('change', toggleHotUntil);
      toggleHotUntil();
    })();

    // Tag input (chip sederhana) + prefill dari data-prefill
    (function(){
      const src = document.querySelector('[data-role="tag-input"]');
      if (!src) return;
      const prefill = JSON.parse(src.getAttribute('data-prefill') || '[]');

      const wrap = document.createElement('div');
      wrap.className = 'form-control d-flex flex-wrap gap-2';
      wrap.style.minHeight = '38px';
      src.parentNode.insertBefore(wrap, src);
      src.classList.add('border-0','flex-grow-1');
      src.placeholder = src.placeholder || 'ketik slug lalu Enter';
      wrap.appendChild(src);

      function addChip(slug){
        slug = (slug||'').trim().toLowerCase().replace(/[^a-z0-9-]/g,'');
        if (!slug) return;
        const chip = document.createElement('span');
        chip.className = 'badge rounded-pill bg-light border text-body d-inline-flex align-items-center';
        chip.textContent = slug + ' ';
        const x = document.createElement('button');
        x.type = 'button'; x.className = 'btn btn-sm btn-link py-0 px-1'; x.innerHTML = '&times;';
        x.addEventListener('click', ()=> chip.remove());
        chip.appendChild(x);
        const h = document.createElement('input');
        h.type = 'hidden'; h.name = 'tag_slugs[]'; h.value = slug;
        chip.appendChild(h);
        wrap.insertBefore(chip, src);
      }

      src.addEventListener('keydown', function(e){
        if (e.key === 'Enter') { e.preventDefault(); addChip(src.value); src.value=''; }
      });

      // prefill existing
      (prefill || []).forEach(addChip);
    })();
  </script>
</x-page.admin>
