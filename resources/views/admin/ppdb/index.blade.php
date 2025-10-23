<x-page.admin :title="__('Data PPDB')">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">PPDB</li>
    </ol>
  </nav>

  {{-- Filter --}}
  <div class="card mb-3">
    <div class="card-body">
      <form method="GET" action="{{ route('admin.ppdb.index') }}" class="row g-2 align-items-end">
        <div class="col-md-4">
          <label class="form-label mb-1">Cari (Nama/NIK/NISN/Email)</label>
          <input name="q" value="{{ request('q') }}" class="form-control" placeholder="cth: Siti / 3204... / 0068... / email@...">
        </div>
        <div class="col-md-3">
          <label class="form-label mb-1">Program</label>
          <input name="program" value="{{ request('program') }}" class="form-control" placeholder="cth: IPA / TKJ / Diniyah">
        </div>
        <div class="col-md-3">
          <label class="form-label mb-1">Status</label>
          <select name="status" class="form-select">
            <option value="">Semua</option>
            @foreach (['baru','diterima','ditolak'] as $st)
              <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
          <button class="btn btn-primary flex-fill"><i class="bi bi-search"></i> <span class="ms-1">Filter</span></button>
          <a href="{{ route('admin.ppdb.index') }}" class="btn btn-light flex-fill">
            <i class="bi bi-x-circle"></i> Reset
          </a>
        </div>
      </form>
      <div class="small text-muted mt-2">Mode baca saja di index. Perubahan status ada di halaman detail.</div>
    </div>
  </div>

  {{-- Tabel ringkas --}}
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title mb-0">Ringkasan Pendaftar</h5>
      <span class="badge bg-secondary">Read-only</span>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width:56px">#</th>
              <th>Nama</th>
              <th>NIK / NISN</th>
              <th>Email / HP</th>
              <th>Program</th>
              <th>Status</th>
              <th style="width:110px" class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($ppdbs as $i => $p)
              @php
                $badge = ['baru'=>'bg-warning text-dark','diterima'=>'bg-success','ditolak'=>'bg-danger'][$p->status] ?? 'bg-secondary';
              @endphp
              <tr>
                <td>{{ $ppdbs->firstItem() + $i }}</td>
                <td class="fw-semibold">{{ $p->nama_lengkap }}</td>
                <td>
                  <div class="small">NIK: {{ $p->nik }}</div>
                  <div class="small text-muted">NISN: {{ $p->nisn ?: '—' }}</div>
                </td>
                <td>
                  <div class="small">{{ $p->email ?: '—' }}</div>
                  <div class="small text-muted">{{ $p->no_hp ?: '—' }}</div>
                </td>
                <td><span class="badge bg-info">{{ $p->program_pendidikan }}</span></td>
                <td><span class="badge {{ $badge }}">{{ ucfirst($p->status) }}</span></td>
                <td class="text-end">
                  <a href="{{ route('admin.ppdb.show', $p->id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-eye"></i> Lihat
                  </a>
                </td>
              </tr>
            @empty
              <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pendaftar.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center">
      <small class="text-muted">Total: {{ $ppdbs->total() }} data</small>
      @if ($ppdbs->lastPage() > 1)
      <nav aria-label="Page navigation" class="ms-auto">
          <ul class="pagination pagination-sm mb-0">
              
              {{-- Tombol Sebelumnya --}}
              <li class="page-item @if(!$ppdbs->previousPageUrl()) disabled @endif">
                  <a class="page-link" href="{{ $ppdbs->previousPageUrl() }}" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                  </a>
              </li>

              {{-- Nomor Halaman --}}
              @php
                  // Tampilkan hanya 5 halaman di sekitar halaman saat ini untuk tampilan ringkas
                  $start = max(1, $ppdbs->currentPage() - 2);
                  $end = min($ppdbs->lastPage(), $ppdbs->currentPage() + 2);
              @endphp
              
              @for ($page = $start; $page <= $end; $page++)
                  <li class="page-item @if($page == $ppdbs->currentPage()) active @endif">
                      <a class="page-link" href="{{ $ppdbs->url($page) }}">{{ $page }}</a>
                  </li>
              @endfor

              {{-- Tombol Selanjutnya --}}
              <li class="page-item @if(!$ppdbs->nextPageUrl()) disabled @endif">
                  <a class="page-link" href="{{ $ppdbs->nextPageUrl() }}" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                  </a>
              </li>
          </ul>
      </nav>
      @endif
    </div>
  </div>
</x-page.admin>
