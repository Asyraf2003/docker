<x-page.admin>
  <div class="page-heading">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h3 class="mb-1">Edit Galeri</h3>
        <p class="text-muted mb-0">Perbarui data gambar galeri sekolah</p>
      </div>
      <a href="{{ route('admin.gallery.index') }}" class="btn btn-light">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>
    </div>

    <div class="card">
      <div class="card-body">
        <form action="{{ route('admin.gallery.update', $image->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">
          @csrf
          @method('PUT')

          {{-- Judul --}}
          <div class="col-md-4">
            <label class="form-label">Judul (ID) <span class="text-danger">*</span></label>
            <input type="text" name="title_id"
                   class="form-control @error('title_id') is-invalid @enderror"
                   value="{{ old('title_id', $image->title_id) }}" required>
            @error('title_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4">
            <label class="form-label">Judul (EN)</label>
            <input type="text" name="title_en"
                   class="form-control @error('title_en') is-invalid @enderror"
                   value="{{ old('title_en', $image->title_en) }}">
            @error('title_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-4">
            <label class="form-label">Judul (AR)</label>
            <input type="text" name="title_ar"
                   class="form-control @error('title_ar') is-invalid @enderror"
                   value="{{ old('title_ar', $image->title_ar) }}">
            @error('title_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Deskripsi --}}
          <div class="col-12">
            <label class="form-label">Deskripsi (ID)</label>
            <textarea name="description_id" rows="2"
                      class="form-control @error('description_id') is-invalid @enderror">{{ old('description_id', $image->description_id) }}</textarea>
            @error('description_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-12">
            <label class="form-label">Deskripsi (EN)</label>
            <textarea name="description_en" rows="2"
                      class="form-control @error('description_en') is-invalid @enderror">{{ old('description_en', $image->description_en) }}</textarea>
            @error('description_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-12">
            <label class="form-label">Deskripsi (AR)</label>
            <textarea name="description_ar" rows="2"
                      class="form-control @error('description_ar') is-invalid @enderror">{{ old('description_ar', $image->description_ar) }}</textarea>
            @error('description_ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Media & tautan --}}
          <div class="col-md-6">
            <label class="form-label">Gambar saat ini</label>
            <div class="border rounded p-2 mb-2">
            <img src="{{ Storage::url($image->image_path) }}"
                alt="{{ $image->title_id }}"
                class="img-fluid rounded">
            </div>

            <label class="form-label">Ganti Gambar (opsional)</label>
            <input type="file" name="image_file" accept="image/*"
                   class="form-control @error('image_file') is-invalid @enderror">
            @error('image_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <div class="form-text">Kosongkan jika tidak ingin mengganti.</div>

            <div class="mt-2">
              <img id="previewImage" src="#" alt="" class="img-fluid rounded border d-none">
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label">Link (opsional)</label>
            <input type="url" name="link_url"
                  class="form-control @error('link_url') is-invalid @enderror"
                  placeholder="https://..." value="{{ old('link_url', $image->link_url) }}">
            @error('link_url')<div class="invalid-feedback">{{ $message }}</div>@enderror

            <div class="form-text mt-2">Atau path manual (opsional): <code>img/gambar1.jpg</code></div>
            <input type="text" name="image_path" class="form-control mt-1"
                  placeholder="img/gambar1.jpg" value="{{ old('image_path', $image->image_path) }}">

            {{-- ===== Status Publikasi ===== --}}
            <div class="mt-3">
              <label class="form-label d-block">Status Publikasi</label>

              <div class="btn-group" role="group" aria-label="Status publish">
                <input type="radio" class="btn-check" name="is_published" id="status_draft" value="0" autocomplete="off"
                      {{ old('is_published', (int)$image->is_published) === 0 ? 'checked' : '' }}>
                <label class="btn btn-outline-secondary" for="status_draft">
                  <i class="bi bi-file-earmark-text me-1"></i> Draft
                </label>

                <input type="radio" class="btn-check" name="is_published" id="status_publish" value="1" autocomplete="off"
                      {{ old('is_published', (int)$image->is_published) === 1 ? 'checked' : '' }}>
                <label class="btn btn-outline-success" for="status_publish">
                  <i class="bi bi-upload me-1"></i> Publish
                </label>
              </div>
              @error('is_published')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
          </div>

          {{-- Meta --}}
          <div class="col-md-3">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order"
                   class="form-control @error('sort_order') is-invalid @enderror"
                   value="{{ old('sort_order', $image->sort_order) }}" min="0">
            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <div class="form-text">Semakin kecil → semakin atas.</div>
          </div>

          {{-- Aksi --}}
          <div class="col-12 d-flex justify-content-end gap-2 pt-2">
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save me-1"></i> Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Preview gambar baru --}}
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const input = document.querySelector('input[name="image_file"]');
      const image = document.getElementById('previewImage');
      if (input && image) {
        input.addEventListener('change', (e) => {
          const file = e.target.files?.[0];
          if (!file) { image.classList.add('d-none'); return; }
          image.src = URL.createObjectURL(file);
          image.onload = () => URL.revokeObjectURL(image.src);
          image.classList.remove('d-none');
        });
      }
    });
  </script>
</x-page.admin>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const radioDraft = document.getElementById('status_draft');
    const radioPublish = document.getElementById('status_publish');
    const publishAtGroup = document.getElementById('publishAtGroup');
    function sync() {
      if (!publishAtGroup) return;
      publishAtGroup.style.display = radioPublish && radioPublish.checked ? '' : 'none';
    }
    [radioDraft, radioPublish].forEach(el => el && el.addEventListener('change', sync));
    sync();
  });
</script>
