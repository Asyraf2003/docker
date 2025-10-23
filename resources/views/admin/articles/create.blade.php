<x-page.admin>
  <div class="page-heading">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h3 class="mb-1">Tambah Artikel</h3>
        <p class="text-muted mb-0">Buat artikel multi-bahasa dengan gambar hero & sections</p>
      </div>
      <a href="{{ route('admin.articles.index') }}" class="btn btn-light">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>
    </div>

    <div class="card">
      <div class="card-body">
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

        <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" id="articleForm">
          @csrf

          {{-- ====== JUDUL & SLUG ====== --}}
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Judul (ID) <span class="text-danger">*</span></label>
              <input name="title_id" class="form-control @error('title_id') is-invalid @enderror" required value="{{ old('title_id') }}">
              @error('title_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
              <label class="form-label">Title (EN) <span class="text-danger">*</span></label>
              <input name="title_en" class="form-control @error('title_en') is-invalid @enderror" required value="{{ old('title_en') }}">
              @error('title_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
              <label class="form-label">العنوان (AR) <span class="text-danger">*</span></label>
              <input name="title_ar" class="form-control @error('title_ar') is-invalid @enderror" dir="rtl" required value="{{ old('title_ar') }}">
              @error('title_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
              <label class="form-label">Slug (opsional)</label>
              <div class="input-group">
                <input name="slug" id="slugInput" class="form-control @error('slug') is-invalid @enderror" placeholder="otomatis dari judul jika kosong" value="{{ old('slug') }}">
                <button class="btn btn-outline-secondary" type="button" id="btnGenSlug">Generate</button>
                @error('slug') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>
              <div class="form-text">Jika dikosongkan, slug akan diambil dari Judul (ID) dan dijamin unik oleh server.</div>
            </div>

            <div class="col-md-6">
              <label class="form-label">Hero Image <span class="text-danger">*</span></label>
              <input type="file" name="hero_image" accept="image/*" class="form-control @error('hero_image') is-invalid @enderror" id="heroInput" required>
              @error('hero_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
              <div class="mt-2">
                <img id="heroPreview" class="img-fluid rounded border d-none" alt="Preview hero">
              </div>
            </div>
          </div>

          {{-- ====== EXCERPT ====== --}}
          <div class="row g-3 mt-2">
            <div class="col-md-4">
              <label class="form-label">Excerpt (ID)</label>
              <input name="excerpt_id" class="form-control" maxlength="300" value="{{ old('excerpt_id') }}">
            </div>
            <div class="col-md-4">
              <label class="form-label">Excerpt (EN)</label>
              <input name="excerpt_en" class="form-control" maxlength="300" value="{{ old('excerpt_en') }}">
            </div>
            <div class="col-md-4">
              <label class="form-label">الملخص (AR)</label>
              <input name="excerpt_ar" class="form-control" dir="rtl" maxlength="300" value="{{ old('excerpt_ar') }}">
            </div>
          </div>

          {{-- ====== META ====== --}}
          <div class="row g-3 mt-2">
            <div class="col-md-4">
              <label class="form-label">Meta Title (ID)</label>
              <input name="meta_title_id" class="form-control" maxlength="120" value="{{ old('meta_title_id') }}">
              <label class="form-label mt-2">Meta Desc (ID)</label>
              <input name="meta_desc_id" class="form-control" maxlength="250" value="{{ old('meta_desc_id') }}">
            </div>
            <div class="col-md-4">
              <label class="form-label">Meta Title (EN)</label>
              <input name="meta_title_en" class="form-control" maxlength="120" value="{{ old('meta_title_en') }}">
              <label class="form-label mt-2">Meta Desc (EN)</label>
              <input name="meta_desc_en" class="form-control" maxlength="250" value="{{ old('meta_desc_en') }}">
            </div>
            <div class="col-md-4">
              <label class="form-label">عنوان الميتا (AR)</label>
              <input name="meta_title_ar" class="form-control" dir="rtl" maxlength="120" value="{{ old('meta_title_ar') }}">
              <label class="form-label mt-2">وصف الميتا (AR)</label>
              <input name="meta_desc_ar" class="form-control" dir="rtl" maxlength="250" value="{{ old('meta_desc_ar') }}">
            </div>
          </div>

          {{-- ====== STATUS & PENJADWALAN ====== --}}
          <div class="row g-3 mt-3">
            <div class="col-md-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-select">
                @foreach(['draft'=>'Draft','scheduled'=>'Scheduled','published'=>'Published','archived'=>'Archived'] as $val=>$lbl)
                  <option value="{{ $val }}" @selected(old('status','draft')===$val)>{{ $lbl }}</option>
                @endforeach
              </select>
              <div class="form-text">Gunakan <b>Scheduled</b> bila ingin terbit otomatis pada waktu tertentu.</div>
            </div>
            <div class="col-md-3">
              <label class="form-label">Published At</label>
              <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at') }}">
            </div>
            <div class="col-md-3">
              <label class="form-label">Scheduled For</label>
              <input type="datetime-local" name="scheduled_for" class="form-control" value="{{ old('scheduled_for') }}">
            </div>
            <div class="col-md-3">
              <label class="form-label">Published? (legacy)</label>
              <label class="form-label">Published? (legacy)</label>
              <input type="hidden" name="is_published" value="0">
              <input type="text" class="form-control" value="Tidak" disabled>
              <div class="form-text">Nilai ini selalu diset ke "Tidak".</div>
              <div class="form-text">Opsional; utamanya gunakan <b>Status</b>.</div>
            </div>
          </div>
          {{-- ====== FEATURED / HOT / PINNED ====== --}}
          <div class="row g-3 mt-2">
            <div class="col-md-3">
              <label class="form-label">Featured</label>
              <select name="is_featured" class="form-select">
                <option value="0" @selected(old('is_featured',0)==0)>Tidak</option>
                <option value="1" @selected(old('is_featured',0)==1)>Ya</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Hot</label>
              <select name="is_hot" class="form-select" id="isHotSelect">
                <option value="0" @selected(old('is_hot',0)==0)>Tidak</option>
                <option value="1" @selected(old('is_hot',0)==1)>Ya</option>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label">Hot Until</label>
              <input type="datetime-local" name="hot_until" class="form-control" id="hotUntilInput" value="{{ old('hot_until') }}">
              <div class="form-text">Kosongkan untuk tanpa batas.</div>
            </div>
            <div class="col-md-3">
              <label class="form-label">Pinned Until</label>
              <input type="datetime-local" name="pinned_until" class="form-control" value="{{ old('pinned_until') }}">
            </div>
          </div>

          {{-- ====== KATEGORI & TAG ====== --}}
          <div class="row g-3 mt-3">
            <div class="col-md-6">
              <label class="form-label">Kategori</label>
              <select class="form-select" name="category_ids[]" multiple>
                @foreach(\App\Models\Category::orderBy('name_id')->get() as $cat)
                  <option value="{{ $cat->id }}" @selected(collect(old('category_ids',[]))->contains($cat->id))>
                    {{ $cat->name_id }}
                  </option>
                @endforeach
              </select>
              <div class="form-text">Tahan Ctrl / Cmd untuk pilih banyak.</div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tag</label>
              <input class="form-control" name="tag_slugs[]" placeholder="Tulis slug tag lalu Enter, bisa banyak"
                     data-role="tag-input">
              <div class="form-text">Atau kirimkan `tag_ids[]` jika memilih dari daftar yang ada.</div>
              @foreach(\App\Models\Tag::orderBy('name')->get() as $tag)
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" id="tag{{ $tag->id }}">
                  <label class="form-check-label" for="tag{{ $tag->id }}">#{{ $tag->name }}</label>
                </div>
              @endforeach
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
              <div class="text-muted small" id="emptyHint">Belum ada section. Klik <b>Tambah Section</b> untuk menambah.</div>
            </div>
          </div>

          {{-- ====== AKSI ====== --}}
          <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('admin.articles.index') }}" class="btn btn-light">Batal</a>
            <button class="btn btn-primary">
              <i class="bi bi-save me-1"></i> Simpan
            </button>
          </div>
        </form>

        {{-- ====== TEMPLATE SECTION ====== --}}
        <template id="sectionTemplate">
          <div class="border rounded-3 p-3 mb-3 section-item" data-index="__IDX__">
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
    // Hero preview
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

    // Slug generator (sederhana)
    (function() {
      const btn = document.getElementById('btnGenSlug');
      const slugInput = document.getElementById('slugInput');
      const titleId = document.querySelector('input[name="title_id"]');
      function slugit(str){
        return (str||'').toString().toLowerCase()
          .normalize('NFKD').replace(/[\u0300-\u036f]/g,'')   // remove diacritics
          .replace(/[^a-z0-9\s-]/g,'')                        // keep alnum & space & hyphen
          .trim().replace(/\s+/g,'-')                         // spaces -> hyphen
          .replace(/-+/g,'-').substring(0,120);
      }
      if (btn && slugInput) {
        btn.addEventListener('click', function(){
          const src = slugInput.value.trim() || (titleId ? titleId.value : '');
          slugInput.value = slugit(src) || '';
        });
      }
    })();

    // Sections builder
    (function(){
      const container  = document.getElementById('sectionsContainer');
      const btnAdd     = document.getElementById('btnAddSection');
      const tpl        = document.getElementById('sectionTemplate').innerHTML;
      const emptyHint  = document.getElementById('emptyHint');
      let idx = 0;

      function renderNumbers() {
        const items = container.querySelectorAll('.section-item');
        items.forEach((el, i) => {
          el.dataset.index = i;
          el.querySelector('.sec-number').textContent = i + 1;
          el.querySelector('.sort-order').value = i;
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
        idx++;
        renderNumbers();
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
          bodyFields.style.display = (sel.value === 'image_only') ? 'none' : '';
        }
      });

      // default: 1 section
      btnAdd?.addEventListener('click', addSection);
      addSection();
    })();

    // Hot until enable/disable berdasar is_hot
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

    // (Opsional) Tag input sederhana: support enter -> bikin multiple value
    (function(){
      const input = document.querySelector('[data-role="tag-input"]');
      if (!input) return;
      const wrap = document.createElement('div');
      wrap.className = 'form-control d-flex flex-wrap gap-2';
      wrap.style.minHeight = '38px';
      const store = document.createElement('input');
      store.type = 'hidden'; store.name = 'tag_slugs[]'; // akan di-clone per chip
      input.parentNode.insertBefore(wrap, input);
      input.classList.add('border-0','flex-grow-1'); input.placeholder = input.placeholder || 'ketik slug lalu Enter';
      wrap.appendChild(input);

      function addChip(slug){
        slug = (slug||'').trim().toLowerCase().replace(/[^a-z0-9-]/g,'');
        if (!slug) return;
        // buat chip
        const chip = document.createElement('span');
        chip.className = 'badge rounded-pill bg-light border text-body d-inline-flex align-items-center';
        chip.textContent = slug + ' ';
        const x = document.createElement('button');
        x.type = 'button';
        x.className = 'btn btn-sm btn-link py-0 px-1';
        x.innerHTML = '&times;';
        x.addEventListener('click', ()=> chip.remove());
        chip.appendChild(x);
        // hidden input untuk slug ini
        const h = document.createElement('input');
        h.type = 'hidden'; h.name = 'tag_slugs[]'; h.value = slug;
        chip.appendChild(h);
        wrap.insertBefore(chip, input);
      }

      input.addEventListener('keydown', function(e){
        if (e.key === 'Enter') {
          e.preventDefault();
          addChip(input.value); input.value = '';
        }
      });
    })();
  </script>
</x-page.admin>
