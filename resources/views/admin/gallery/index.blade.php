<x-page.admin>
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <div>
      <h3 class="mb-0">Galeri</h3>
      <div class="text-muted small">Kelola koleksi gambar dan deskripsi multi-bahasa</div>
    </div>

    <div class="d-flex align-items-center justify-content-between mb-3">
      <div class="d-flex gap-2">
        {{-- Search --}}
        <form method="GET" action="{{ route('admin.gallery.index') }}" class="d-none d-md-flex">
          <div class="input-group">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                  placeholder="Cari judul / deskripsi…">
            <button class="btn btn-primary"><i class="bi bi-search"></i></button>
            @if(request('q'))
              <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
          </div>
        </form>

        {{-- Toggle layout (list / grid) --}}
        @php $viewMode = request('view','list'); @endphp
        <div class="btn-group" role="group" aria-label="Tampilan">
          <a href="{{ request()->fullUrlWithQuery(['view'=>'list']) }}"
            class="btn btn-primary {{ $viewMode==='list'?'active':'' }}">
            <i class="bi bi-list-ul"></i>
          </a>
          <a href="{{ request()->fullUrlWithQuery(['view'=>'grid']) }}"
            class="btn btn-primary {{ $viewMode==='grid'?'active':'' }}">
            <i class="bi bi-grid-3x3-gap"></i>
          </a>
        </div>

        {{-- Filter --}}
        <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#filterGalleryOffcanvas">
          <i class="bi bi-sliders"></i> Filter
        </button>

        {{-- Create --}}
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
          <i class="bi bi-plus-lg me-1"></i> Tambah Gambar
        </a>
      </div>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle me-1"></i>{{ $errors->first() }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  
  @if($images->count())
    @if($viewMode === 'grid')
      <div class="row gy-3 gy-lg-4">
        @forelse($images as $img)
          <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card h-100">
              @php
                $path = $img->image_path;
                if (Str::startsWith($path, ['http://','https://'])) {
                    $imgUrl = $path;
                } elseif (Str::startsWith($path, ['storage/', 'gallery/'])) {
                    // File di disk 'public' (storage/app/public)
                    $imgUrl = Storage::url($path);
                } else {
                    // File di public/ (mis. public/img/gambar1.jpg)
                    $imgUrl = asset($path);
                }
              @endphp
              <img src="{{ $imgUrl }}" class="card-img-top" alt="{{ $img->title_id }}">
              <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h6 class="card-title mb-0" style="max-width:80%">{{ Str::limit($img->title_id, 40) }}</h6>
                  @if($img->is_published)
                    <span class="badge bg-success">Published</span>
                  @else
                    <span class="badge bg-secondary">Draft</span>
                  @endif
                </div>

                @if($img->description_id)
                  <p class="text-muted mb-2">{{ Str::limit($img->description_id, 90) }}</p>
                @endif

                <div class="mt-auto d-flex gap-2 flex-wrap">
                  @if($img->link_url)
                    <a href="{{ $img->link_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-box-arrow-up-right me-1"></i> Kunjungi
                    </a>
                  @endif

                  <a href="{{ route('admin.gallery.edit', $img->id) }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                  </a>

                  <form action="{{ route('admin.gallery.destroy', $img->id) }}" method="POST" onsubmit="return confirm('Hapus item ini?')" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">
                      <i class="bi bi-trash me-1"></i> Hapus
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <div class="alert alert-info">Belum ada data galeri.</div>
          </div>
        @endforelse
      </div>
    @else
      <div class="card border-0 shadow-sm">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="bg-body-tertiary">
              <tr>
                <th style="width:42%" class="text-body-secondary text-uppercase small">Judul</th>
                <th class="text-body-secondary text-uppercase small">Deskripsi</th>
                <th class="text-body-secondary text-uppercase small">Status</th>
                <th class="text-body-secondary text-uppercase small">Terbit</th>
                <th class="text-end text-body-secondary text-uppercase small">Aksi</th>
              </tr>
            </thead>

            <tbody class="table-group-divider">
              @forelse($images as $img)
                <tr>
                  <td>
                    <div class="d-flex align-items-start gap-3">
                      @php
                        $path = $img->image_path;
                        if (Str::startsWith($path, ['http://','https://'])) {
                          $imgUrl = $path;
                        } elseif (Str::startsWith($path, ['storage/', 'gallery/'])) {
                          $imgUrl = Storage::url($path);
                        } else {
                          $imgUrl = asset($path);
                        }
                      @endphp

                      @if($img->image_path)
                        <div class="ratio ratio-16x9 rounded overflow-hidden" style="width:120px">
                          <img src="{{ $imgUrl }}" class="object-fit-cover" alt="{{ $img->title_id }}">
                        </div>
                      @else
                        <div class="rounded d-flex align-items-center justify-content-center border border-dashed"
                            style="width:120px;height:68px">
                          <i class="bi bi-image text-body-secondary"></i>
                        </div>
                      @endif

                      <div class="min-w-0">
                        <div class="fw-semibold text-truncate" title="{{ $img->title_id }}">
                          {{ $img->title_id }}
                        </div>
                        <div class="small text-body-secondary">
                          ID: {{ Str::limit($img->title_id, 25) }}
                          @if($img->title_en)
                            <span class="badge rounded-pill bg-secondary-subtle text-body ms-1">EN</span>
                          @endif
                          @if($img->title_ar)
                            <span class="badge rounded-pill bg-secondary-subtle text-body ms-1">AR</span>
                          @endif
                        </div>
                      </div>
                    </div>
                  </td>

                  <td class="text-muted small">
                    {{ Str::limit($img->description_id, 40) ?: '—' }}
                  </td>

                  <td>
                    <span class="badge {{ $img->is_published ? 'bg-success' : 'bg-warning text-dark' }}">
                      {{ $img->is_published ? 'Published' : 'Draft' }}
                    </span>
                  </td>

                  <td class="text-nowrap">
                    <i class="bi bi-calendar2-week me-1"></i>
                    {{ $img->published_at?->format('d M Y H:i') ?? '—' }}
                  </td>

                  <td class="text-end">
                    <div class="d-inline-flex gap-1">
                      @if($img->is_published && $img->link_url)
                        <a href="{{ $img->link_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                          <i class="bi bi-box-arrow-up-right me-1"></i> Kunjungi
                        </a>
                      @endif
                      <a href="{{ route('admin.gallery.edit', $img->id) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square me-1"></i> Edit
                      </a>
                      <form action="{{ route('admin.gallery.destroy', $img->id) }}" method="POST"
                            onsubmit="return confirm('Hapus item ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                          <i class="bi bi-trash me-1"></i> Hapus
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5">
                    <div class="alert alert-info mb-0">Belum ada data galeri.</div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="card-footer d-flex flex-wrap gap-2 justify-content-between align-items-center">
          <div class="text-body-secondary small">
            Menampilkan {{ $images->firstItem() }}–{{ $images->lastItem() }} dari {{ $images->total() }} data
          </div>
          <div>{{ $images->withQueryString()->links() }}</div>
        </div>
      </div>
    @endif
  @else
    <div class="card border-0 shadow-sm">
      <div class="card-body text-center py-5">
        <i class="bi bi-file-earmark-text display-6 text-muted d-block mb-2"></i>
        <p class="text-muted mb-3">Belum ada galeri.</p>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
          <i class="bi bi-plus-lg me-1"></i> Buat yang pertama
        </a>
      </div>
    </div>
  @endif

  {{-- Filter Offcanvas --}}
  <div class="offcanvas offcanvas-end" tabindex="-1" id="filterGalleryOffcanvas">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Filter Galeri</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
      <form method="GET" action="{{ route('admin.gallery.index') }}" class="vstack gap-3">
        {{-- Persist query & view --}}
        <input type="hidden" name="q" value="{{ request('q') }}">
        <input type="hidden" name="view" value="{{ request('view') }}">

        <div>
          <label class="form-label">Status</label>
          <select name="published" class="form-select">
            <option value="" @selected(request('published', '')==='')>Semua</option>
            <option value="1" @selected(request('published')==='1')>Published</option>
            <option value="0" @selected(request('published')==='0')>Draft</option>
          </select>
        </div>

        <div>
          <label class="form-label">Urutkan</label>
          <select name="sort" class="form-select">
            <option value="latest"     @selected(request('sort','latest')==='latest')>Terbaru terbit</option>
            <option value="oldest"     @selected(request('sort')==='oldest')>Terlama terbit</option>
            <option value="title_asc"  @selected(request('sort')==='title_asc')>Judul A–Z</option>
            <option value="title_desc" @selected(request('sort')==='title_desc')>Judul Z–A</option>
          </select>
        </div>

        <div class="d-grid gap-2">
          <button class="btn btn-primary">
            <i class="bi bi-funnel me-1"></i> Terapkan
          </button>

          @if(request()->hasAny(['published','sort']) && (request('published')!==null || request('sort')!==null))
            <a href="{{ route('admin.gallery.index', array_filter(['q'=>request('q'),'view'=>request('view')])) }}"
              class="btn btn-outline-secondary">
              Reset
            </a>
          @endif
        </div>
      </form>
    </div>
  </div>
</x-page.admin>
