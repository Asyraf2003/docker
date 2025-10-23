<x-page.admin :title="'Artikel'">
  {{-- PAGE HEADER --}}
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <div>
      <h3 class="mb-0">Artikel</h3>
      <div class="text-muted small">Kelola konten artikel multi-bahasa</div>
    </div>

    <div class="d-flex align-items-center justify-content-between mb-3 w-100 w-md-auto">
      <div class="d-flex flex-wrap gap-2">
        {{-- Search (desktop) --}}
        <form method="GET" action="{{ route('admin.articles.index') }}" class="d-none d-md-flex">
          <div class="input-group">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari judul / slug…">
            <button class="btn btn-primary"><i class="bi bi-search"></i></button>
            @if(request('q') || request('status') || request('featured') || request('hot') || request('category') || request('tag') || request('sort'))
              <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
          </div>
        </form>

        {{-- Search (mobile) --}}
        <form method="GET" action="{{ route('admin.articles.index') }}" class="d-flex d-md-none w-100">
          <div class="input-group">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari judul / slug…">
            <button class="btn btn-primary"><i class="bi bi-search"></i></button>
            @if(request('q') || request('status') || request('featured') || request('hot') || request('category') || request('tag') || request('sort'))
              <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
          </div>
        </form>

        {{-- Toggle layout (list / grid) --}}
        @php $viewMode = request('view','list'); @endphp
        <div class="btn-group" role="group" aria-label="Tampilan">
          <a href="{{ request()->fullUrlWithQuery(['view'=>'list']) }}" class="btn btn-primary {{ $viewMode==='list'?'active':'' }}">
            <i class="bi bi-list-ul"></i>
          </a>
          <a href="{{ request()->fullUrlWithQuery(['view'=>'grid']) }}" class="btn btn-primary {{ $viewMode==='grid'?'active':'' }}">
            <i class="bi bi-grid-3x3-gap"></i>
          </a>
        </div>

        {{-- Filter --}}
        <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
          <i class="bi bi-sliders"></i> Filter
        </button>

        {{-- Create --}}
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
          <i class="bi bi-plus-lg me-1"></i> Tambah Artikel
        </a>
      </div>
    </div>
  </div>

  {{-- FLASH --}}
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

  {{-- LIST / GRID --}}
  @if($articles->count())
    @if($viewMode==='grid')
      {{-- GRID MODE --}}
      <div class="row gy-3 gy-lg-4">
        @foreach($articles as $a)
          @php
            // Gambar: robust resolver
            $path  = $a->hero_image;
            $imgUrl = null;
            if ($path) {
              if (\Illuminate\Support\Str::startsWith($path, ['http://','https://'])) {
                $imgUrl = $path;
              } elseif (\Illuminate\Support\Str::startsWith($path, ['storage/','articles/','article/','gallery/','images/'])) {
                $imgUrl = \Illuminate\Support\Facades\Storage::url($path);
              } else {
                $imgUrl = asset($path);
              }
            }

            // Excerpt sesuai locale aktif
            $locale = app()->getLocale();
            $excerpt = match ($locale) {
              'en' => $a->excerpt_en,
              'ar' => $a->excerpt_ar,
              default => $a->excerpt_id,
            } ?? ($a->excerpt_id ?? $a->excerpt_en ?? $a->excerpt_ar);

            // Status badge style
            $statusMap = [
              'draft'     => ['label'=>'Draft','class'=>'bg-secondary'],
              'scheduled' => ['label'=>'Scheduled','class'=>'bg-info text-dark'],
              'published' => ['label'=>'Published','class'=>'bg-success'],
              'archived'  => ['label'=>'Archived','class'=>'bg-dark'],
            ];
            $sb = $statusMap[$a->status] ?? $statusMap['draft'];

            $now = now();
            $isHotActive = $a->is_hot && (!$a->hot_until || $a->hot_until >= $now);
            $isPinnedActive = $a->pinned_until && $a->pinned_until >= $now;
          @endphp

          <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card h-100">
              @if($imgUrl)
                <img src="{{ $imgUrl }}" class="card-img-top" alt="{{ $a->title_id ?? $a->title_en ?? $a->title_ar }}">
              @endif

              <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h6 class="card-title mb-0" style="max-width:80%">
                    {{ \Illuminate\Support\Str::limit($a->title_id ?? $a->title_en ?? $a->title_ar, 48) }}
                  </h6>
                  <span class="badge {{ $sb['class'] }}">{{ $sb['label'] }}</span>
                </div>

                {{-- Chips fitur --}}
                <div class="mb-2 d-flex flex-wrap gap-1">
                  @if($a->is_featured)
                    <span class="badge rounded-pill text-bg-warning"><i class="bi bi-star-fill me-1"></i>Featured</span>
                  @endif
                  @if($isHotActive)
                    <span class="badge rounded-pill text-bg-danger"><i class="bi bi-fire me-1"></i>Hot</span>
                  @endif
                  @if($isPinnedActive)
                    <span class="badge rounded-pill text-bg-primary"><i class="bi bi-pin-angle-fill me-1"></i>Pinned</span>
                  @endif>
                </div>

                {{-- Excerpt --}}
                @if($excerpt)
                  <p class="text-muted mb-2">{{ \Illuminate\Support\Str::limit($excerpt, 90) }}</p>
                @endif

                {{-- Meta kecil --}}
                <div class="small text-body-secondary mb-2">
                  <div class="mb-1">
                    <code class="text-body">{{ $a->slug }}</code>
                  </div>
                  <div class="d-flex flex-wrap gap-3">
                    <span title="Views"><i class="bi bi-eye me-1"></i>{{ number_format($a->view_count) }}</span>
                    <span title="Comments"><i class="bi bi-chat-dots me-1"></i>{{ number_format($a->comment_count) }}</span>
                    <span title="Shares"><i class="bi bi-share me-1"></i>{{ number_format($a->share_count) }}</span>
                    <span title="Reading time"><i class="bi bi-clock me-1"></i>{{ $a->reading_time }}m</span>
                  </div>
                  <div class="mt-1">
                    @if($a->author)
                      <span><i class="bi bi-person-circle me-1"></i>{{ $a->author->name }}</span>
                    @endif
                  </div>
                </div>

                {{-- Kategori / Tag (ringkas) --}}
                <div class="small text-body-secondary mb-3">
                  @if($a->relationLoaded('categories') && $a->categories->count())
                    <i class="bi bi-folder2 me-1"></i>
                    {{ $a->categories->pluck('name')->take(2)->join(', ') }}@if($a->categories->count()>2), …@endif
                  @endif
                  @if($a->relationLoaded('tags') && $a->tags->count())
                    <span class="ms-2"><i class="bi bi-hash me-1"></i>{{ $a->tags->pluck('name')->take(2)->join(', ') }}@if($a->tags->count()>2), …@endif</span>
                  @endif
                </div>

                {{-- Waktu (published/scheduled) --}}
                <div class="small text-body-secondary mb-3">
                  @if($a->status === 'scheduled' && $a->scheduled_for)
                    <i class="bi bi-calendar-event me-1"></i> Terjadwal: {{ optional($a->scheduled_for)->format('d M Y H:i') }}
                  @elseif($a->published_at)
                    <i class="bi bi-calendar2-week me-1"></i> Terbit: {{ optional($a->published_at)->format('d M Y') }}
                  @else
                    <i class="bi bi-pencil me-1"></i> Draft
                  @endif
                </div>

                <div class="mt-auto d-flex gap-2 flex-wrap">
                  @if($a->status === 'published')
                    <a href="{{ route('article.show', $a->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-box-arrow-up-right me-1"></i> Kunjungi
                    </a>
                  @endif
                  <a href="{{ route('admin.articles.edit', $a->id) }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                  </a>
                  <form action="{{ route('admin.articles.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">
                      <i class="bi bi-trash me-1"></i> Hapus
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      {{-- LIST/TABLE MODE --}}
      <div class="card border-0 shadow-sm">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="bg-body-tertiary">
              <tr>
                <th style="width:44%" class="text-body-secondary text-uppercase small">Judul</th>
                <th class="text-body-secondary text-uppercase small">Status</th>
                <th class="text-body-secondary text-uppercase small">Terbit/Jadwal</th>
                <th class="text-body-secondary text-uppercase small">Metrik</th>
                <th class="text-end text-body-secondary text-uppercase small">Aksi</th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
            @foreach($articles as $a)
              @php
                // thumbnail kecil konsisten
                $path = $a->hero_image;
                $thumbUrl = null;
                if ($path) {
                  if (\Illuminate\Support\Str::startsWith($path, ['http://','https://'])) {
                    $thumbUrl = $path;
                  } elseif (\Illuminate\Support\Str::startsWith($path, ['storage/','articles/','article/','gallery/','images/'])) {
                    $thumbUrl = \Illuminate\Support\Facades\Storage::url($path);
                  } else {
                    $thumbUrl = asset($path);
                  }
                }

                $statusMap = [
                  'draft'     => ['label'=>'Draft','class'=>'bg-secondary'],
                  'scheduled' => ['label'=>'Scheduled','class'=>'bg-info text-dark'],
                  'published' => ['label'=>'Published','class'=>'bg-success'],
                  'archived'  => ['label'=>'Archived','class'=>'bg-dark'],
                ];
                $sb = $statusMap[$a->status] ?? $statusMap['draft'];

                $now = now();
                $isHotActive = $a->is_hot && (!$a->hot_until || $a->hot_until >= $now);
                $isPinnedActive = $a->pinned_until && $a->pinned_until >= $now;
              @endphp

              <tr>
                <td>
                  <div class="d-flex align-items-start gap-3">
                    <div class="ratio ratio-16x9 rounded overflow-hidden bg-body-tertiary" style="width:120px">
                      @if($thumbUrl)
                        <img src="{{ $thumbUrl }}" class="object-fit-cover" alt="{{ $a->title_id ?? $a->title_en ?? $a->title_ar }}">
                      @else
                        <div class="d-flex align-items-center justify-content-center h-100">
                          <i class="bi bi-image text-body-secondary"></i>
                        </div>
                      @endif
                    </div>

                    <div class="min-w-0">
                      <div class="fw-semibold text-truncate" title="{{ $a->title_id ?? $a->title_en ?? $a->title_ar }}">
                        {{ $a->title_id ?? $a->title_en ?? $a->title_ar }}
                      </div>

                      <div class="small text-body-secondary">
                        <code class="text-body">{{ $a->slug }}</code>
                        @if($a->author)
                          <span class="ms-2"><i class="bi bi-person-circle me-1"></i>{{ $a->author->name }}</span>
                        @endif
                      </div>

                      {{-- badges kecil: bahasa, kategori, tag, feature/hot/pinned --}}
                      <div class="mt-1 d-flex flex-wrap gap-1">
                        @if($a->title_id) <span class="badge rounded-pill bg-secondary-subtle text-body">ID</span>@endif
                        @if($a->title_en) <span class="badge rounded-pill bg-secondary-subtle text-body">EN</span>@endif
                        @if($a->title_ar) <span class="badge rounded-pill bg-secondary-subtle text-body">AR</span>@endif

                        @if($a->relationLoaded('categories') && $a->categories->count())
                          <span class="badge rounded-pill bg-light border">
                            <i class="bi bi-folder2 me-1"></i>{{ $a->categories->pluck('name')->take(1)->join(', ') }}
                            @if($a->categories->count()>1) , … @endif
                          </span>
                        @endif

                        @if($a->relationLoaded('tags') && $a->tags->count())
                          <span class="badge rounded-pill bg-light border">
                            <i class="bi bi-hash me-1"></i>{{ $a->tags->pluck('name')->take(1)->join(', ') }}
                            @if($a->tags->count()>1) , … @endif
                          </span>
                        @endif

                        @if($a->is_featured)
                          <span class="badge rounded-pill text-bg-warning"><i class="bi bi-star-fill me-1"></i>Featured</span>
                        @endif
                        @if($isHotActive)
                          <span class="badge rounded-pill text-bg-danger"><i class="bi bi-fire me-1"></i>Hot</span>
                        @endif
                        @if($isPinnedActive)
                          <span class="badge rounded-pill text-bg-primary"><i class="bi bi-pin-angle-fill me-1"></i>Pinned</span>
                        @endif
                      </div>
                    </div>
                  </div>
                </td>

                <td>
                  <span class="badge {{ $sb['class'] }}">{{ $sb['label'] }}</span>
                </td>

                <td class="text-nowrap">
                  @if($a->status === 'scheduled' && $a->scheduled_for)
                    <i class="bi bi-calendar-event me-1"></i>{{ optional($a->scheduled_for)->format('d M Y H:i') }}
                  @elseif($a->published_at)
                    <i class="bi bi-calendar2-week me-1"></i>{{ optional($a->published_at)->format('d M Y') }}
                  @else
                    —
                  @endif
                </td>

                <td class="text-nowrap">
                  <div class="d-flex flex-column small">
                    <span title="Views"><i class="bi bi-eye me-1"></i>{{ number_format($a->view_count) }}</span>
                    <span title="Comments"><i class="bi bi-chat-dots me-1"></i>{{ number_format($a->comment_count) }}</span>
                    <span title="Shares"><i class="bi bi-share me-1"></i>{{ number_format($a->share_count) }}</span>
                    <span title="Reading time"><i class="bi bi-clock me-1"></i>{{ $a->reading_time }}m</span>
                  </div>
                </td>

                <td class="text-end">
                  <div class="d-inline-flex gap-1">
                    @if($a->status === 'published')
                      <a href="{{ route('admin.articles.show', $a->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Kunjungi
                      </a>
                    @endif
                    <a href="{{ route('admin.articles.edit', $a->id) }}" class="btn btn-warning btn-sm">
                      <i class="bi bi-pencil-square me-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.articles.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                      @csrf @method('DELETE')
                      <button class="btn btn-danger btn-sm">
                        <i class="bi bi-trash me-1"></i> Hapus
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

        <div class="card-footer d-flex flex-wrap gap-2 justify-content-between align-items-center">
          <div class="text-body-secondary small">
            Menampilkan {{ $articles->firstItem() }}–{{ $articles->lastItem() }} dari {{ $articles->total() }} data
          </div>
          <div>{{ $articles->withQueryString()->links() }}</div>
        </div>
      </div>
    @endif
  @else
    {{-- EMPTY STATE --}}
    <div class="card border-0 shadow-sm">
      <div class="card-body text-center py-5">
        <i class="bi bi-file-earmark-text display-6 text-muted d-block mb-2"></i>
        <p class="text-muted mb-3">Belum ada artikel.</p>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
          <i class="bi bi-plus-lg me-1"></i> Buat yang pertama
        </a>
      </div>
    </div>
  @endif

  {{-- OFFCANVAS FILTER --}}
  <div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Filter Artikel</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <form method="GET" action="{{ route('admin.articles.index') }}" class="vstack gap-3">
        <input type="hidden" name="q" value="{{ request('q') }}">

        <div>
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="">Semua</option>
            @foreach(['draft','scheduled','published','archived'] as $st)
              <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
            @endforeach
          </select>
        </div>

        <div class="row g-3">
          <div class="col-6">
            <label class="form-label">Featured</label>
            <select name="featured" class="form-select">
              <option value="">Semua</option>
              <option value="yes" @selected(request('featured')==='yes')>Ya saja</option>
            </select>
          </div>
          <div class="col-6">
            <label class="form-label">Hot</label>
            <select name="hot" class="form-select">
              <option value="">Semua</option>
              <option value="yes" @selected(request('hot')==='yes')>Ya saja</option>
            </select>
          </div>
        </div>

        <div>
          <label class="form-label">Kategori (slug)</label>
          <input type="text" name="category" value="{{ request('category') }}" class="form-control" placeholder="mis. berita-sekolah">
        </div>

        <div>
          <label class="form-label">Tag (slug)</label>
          <input type="text" name="tag" value="{{ request('tag') }}" class="form-control" placeholder="mis. pengumuman">
        </div>

        <div>
          <label class="form-label">Urutkan</label>
          <select name="sort" class="form-select">
            <option value="published_at_desc" @selected(request('sort','published_at_desc')==='published_at_desc')>Terbaru terbit</option>
            <option value="published_at_asc"  @selected(request('sort')==='published_at_asc')>Terlama terbit</option>
            <option value="title_asc"         @selected(request('sort')==='title_asc')>Judul A-Z</option>
            <option value="title_desc"        @selected(request('sort')==='title_desc')>Judul Z-A</option>
            <option value="views_desc"        @selected(request('sort')==='views_desc')>Views terbanyak</option>
          </select>
        </div>

        <div class="d-grid">
          <button class="btn btn-primary"><i class="bi bi-funnel me-1"></i> Terapkan</button>
        </div>
      </form>
    </div>
  </div>
</x-page.admin>
