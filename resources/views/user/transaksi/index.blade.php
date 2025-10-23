<x-page.user :title="__('Transaksi Saya')">
  {{-- Breadcrumb --}}
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
    </ol>
  </nav>

  {{-- Flash message --}}
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- Filter sederhana --}}
  <div class="card mb-3">
    <div class="card-body">
      <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
          <label class="form-label mb-1">Status</label>
          <select name="status" class="form-select">
            <option value="">Semua</option>
            @foreach (['pending','verified','rejected'] as $st)
              <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
          <button class="btn btn-primary flex-fill"><i class="bi bi-filter"></i> Terapkan</button>
          <a href="{{ route('user.transaksi.index') }}" class="btn btn-light flex-fill">
            <i class="bi bi-x-circle"></i> Reset
          </a>
        </div>
      </form>
    </div>
  </div>

  {{-- Tabel transaksi user (read-only) --}}
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title mb-0">Riwayat Transaksi</h5>
      <span class="badge bg-secondary">Read-only</span>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width:56px">#</th>
              <th>Tanggal</th>
              <th>Nominal</th>
              <th>Metode / Tujuan</th>
              <th>Bukti</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($payments as $i => $p)
              @php
                $badge = [
                  'pending'  => 'bg-warning text-dark',
                  'verified' => 'bg-success',
                  'rejected' => 'bg-danger'
                ][$p->status] ?? 'bg-secondary';
              @endphp
              <tr>
                <td>{{ $payments->firstItem() + $i }}</td>
                <td class="small">{{ $p->paid_at?->format('d/m/Y H:i') ?? $p->created_at->format('d/m/Y H:i') }}</td>
                <td>Rp {{ number_format($p->amount,0,',','.') }}</td>
                <td>
                  <div class="small">{{ $p->metode ?: '—' }}</div>
                  <div class="small text-muted">{{ $p->tujuan ?: '—' }}</div>
                </td>
                <td>
                  @if($p->bukti_url)
                    <button class="btn btn-sm btn-outline-primary"
                            data-bs-toggle="modal" data-bs-target="#modalBuktiUser"
                            data-filelabel="Bukti #{{ $p->id }}" data-fileurl="{{ $p->bukti_url }}">
                      <i class="bi bi-eye"></i> Lihat
                    </button>
                  @else
                    <span class="text-muted small">Tidak ada</span>
                  @endif
                </td>
                <td><span class="badge {{ $badge }}">{{ ucfirst($p->status) }}</span></td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center text-muted py-4">Belum ada transaksi.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center">
      <small class="text-muted">Total: {{ $payments->total() }} transaksi</small>
      {{ $payments->withQueryString()->links() }}
    </div>
  </div>

  {{-- Modal Preview Bukti (User) --}}
  <div class="modal fade" id="modalBuktiUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalBuktiUserTitle">Preview Bukti</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div id="buktiUserPreview" class="text-center">
            <div class="text-muted">Memuat berkas…</div>
          </div>
        </div>
        <div class="modal-footer">
          <a id="buktiUserOpenNewTab" href="#" target="_blank" rel="noopener" class="btn btn-outline-secondary">
            <i class="bi bi-box-arrow-up-right"></i> Buka di Tab Baru
          </a>
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    document.getElementById('modalBuktiUser')?.addEventListener('show.bs.modal', function (ev) {
      const trigger = ev.relatedTarget;
      const url   = trigger?.getAttribute('data-fileurl');
      const label = trigger?.getAttribute('data-filelabel');

      const titleEl = document.getElementById('modalBuktiUserTitle');
      const cont    = document.getElementById('buktiUserPreview');
      const openBtn = document.getElementById('buktiUserOpenNewTab');

      titleEl.textContent = label || 'Preview Bukti';
      openBtn.href = url || '#';

      if (!url) { cont.innerHTML = '<div class="text-muted">Berkas tidak tersedia.</div>'; return; }

      const isImage = /\.(png|jpe?g|gif|webp|bmp)$/i.test(url);
      const isPDF   = /\.pdf(\?.*)?$/i.test(url);

      if (isImage) {
        cont.innerHTML = `<img src="${url}" alt="${label}" class="img-fluid rounded">`;
      } else if (isPDF) {
        cont.innerHTML = `<iframe src="${url}" style="width:100%;height:75vh;border:0;" title="PDF Preview"></iframe>`;
      } else {
        cont.innerHTML = `
          <div class="alert alert-info mb-0">
            Format tidak dikenali untuk preview. Gunakan tombol "Buka di Tab Baru".
          </div>`;
      }
    });
  </script>
  @endpush
</x-page.user>
