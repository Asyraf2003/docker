<x-page.admin :title="__('Detail PPDB')">
  {{-- Breadcrumb --}}
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.ppdb.index') }}">PPDB</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $ppdb->nama_lengkap }}</li>
    </ol>
  </nav>

  {{-- Header + Edit Status (satu-satunya yang bisa diubah) --}}
  <div class="card mb-3">
    <div class="card-body d-flex flex-wrap gap-3 justify-content-between align-items-center">
      <div>
        <h5 class="mb-1">{{ $ppdb->nama_lengkap }}</h5>
        <div class="small text-muted">NIK: {{ $ppdb->nik }} • NISN: {{ $ppdb->nisn ?: '—' }}</div>
        <div class="small text-muted">Email: {{ $ppdb->email ?: '—' }} • HP: {{ $ppdb->no_hp ?: '—' }}</div>
      </div>

      <div class="d-flex align-items-center gap-2">
        <span class="me-2">Status:</span>
        <form action="{{ route('admin.ppdb.updateStatus', $ppdb->id) }}" method="POST" class="d-flex gap-2">
          @csrf
          @method('PATCH')
          <select name="status" class="form-select form-select-sm" style="min-width: 150px;">
            @foreach (['baru','diterima','ditolak'] as $st)
              <option value="{{ $st }}" @selected($ppdb->status===$st)>{{ ucfirst($st) }}</option>
            @endforeach
          </select>
          <button class="btn btn-sm btn-primary">
            <i class="bi bi-check2-circle"></i> Simpan
          </button>
        </form>
      </div>
    </div>
  </div>

  <div class="row g-3">
    {{-- Data Lengkap --}}
    <div class="col-lg-7">
      <div class="card h-100">
        <div class="card-header"><h6 class="mb-0">Data Lengkap</h6></div>
        <div class="card-body">
          @php
            $sections = [
              'Identitas' => [
                'Nama Lengkap' => $ppdb->nama_lengkap,
                'Jenis Kelamin' => $ppdb->jenis_kelamin,
                'Agama' => $ppdb->agama ?: '—',
                'Tempat, Tanggal Lahir' => trim(($ppdb->tempat_lahir ?: '—').' / '.($ppdb->tanggal_lahir? $ppdb->tanggal_lahir->translatedFormat('d M Y') : '—')),
              ],
              'Pendidikan' => [
                'Asal Sekolah' => $ppdb->asal_sekolah ?: '—',
                'Tahun Lulus' => $ppdb->tahun_lulus ?: '—',
                'Program Pendidikan' => $ppdb->program_pendidikan,
              ],
              'Kontak & Alamat' => [
                'Email' => $ppdb->email ?: '—',
                'No HP' => $ppdb->no_hp ?: '—',
                'Alamat' => $ppdb->alamat ?: '—',
                'Kecamatan / Kabupaten / Provinsi' => trim(($ppdb->kecamatan ?: '—').', '.($ppdb->kabupaten ?: '—').', '.($ppdb->provinsi ?: '—')),
              ],
              'Orang Tua/Wali' => [
                'Nama Ayah' => $ppdb->nama_ayah ?: '—',
                'Pekerjaan Ayah' => $ppdb->pekerjaan_ayah ?: '—',
                'Nama Ibu' => $ppdb->nama_ibu ?: '—',
                'Pekerjaan Ibu' => $ppdb->pekerjaan_ibu ?: '—',
                'Penghasilan Wali' => is_null($ppdb->penghasilan_wali) ? '—' : 'Rp'.number_format($ppdb->penghasilan_wali,0,',','.'),
              ],
            ];
          @endphp

          @foreach ($sections as $title => $pairs)
            <h6 class="text-uppercase text-muted mt-2 mb-2 small">{{ $title }}</h6>
            <div class="row g-2">
              @foreach ($pairs as $label => $value)
                <div class="col-md-6">
                  <div class="border rounded p-2 h-100">
                    <div class="small text-muted">{{ $label }}</div>
                    <div>{{ $value }}</div>
                  </div>
                </div>
              @endforeach
            </div>
          @endforeach
        </div>
      </div>
    </div>

    {{-- Berkas + Preview --}}
    <div class="col-lg-5">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Berkas</h6>
          <span class="small text-muted">Klik untuk pratinjau</span>
        </div>
        <div class="card-body">
          <div class="list-group">
            @foreach ($files as $label => $url)
                @if($url)
                <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                    href="javascript:void(0)"
                    data-bs-toggle="modal" data-bs-target="#modalPreview"
                    data-filelabel="{{ $label }}" data-fileurl="{{ $url }}">
                    <span><i class="bi bi-file-earmark-text me-2"></i>{{ $label }}</span>
                    <span class="badge bg-primary">Lihat</span>
                </a>
                @else
                <div class="list-group-item d-flex justify-content-between align-items-center disabled">
                    <span><i class="bi bi-file-earmark-text me-2"></i>{{ $label }}</span>
                    <span class="badge bg-secondary">Kosong</span>
                </div>
                @endif
            @endforeach
          </div>
          <div class="small text-muted mt-2">Gambar dipratinjau langsung; PDF via viewer.</div>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal Preview Berkas --}}
  <div class="modal fade" id="modalPreview" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPreviewTitle">Preview Berkas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div id="filePreviewContainer" class="text-center">
            <div class="text-muted">Memuat berkas…</div>
          </div>
        </div>
        <div class="modal-footer">
          <a id="modalOpenNewTab" href="#" target="_blank" rel="noopener" class="btn btn-outline-secondary">
            <i class="bi bi-box-arrow-up-right"></i> Buka di Tab Baru
          </a>
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    document.getElementById('modalPreview')?.addEventListener('show.bs.modal', function (ev) {
      const trigger = ev.relatedTarget;
      const url   = trigger?.getAttribute('data-fileurl');
      const label = trigger?.getAttribute('data-filelabel');

      const titleEl = document.getElementById('modalPreviewTitle');
      const cont    = document.getElementById('filePreviewContainer');
      const openBtn = document.getElementById('modalOpenNewTab');

      titleEl.textContent = 'Preview: ' + (label || 'Berkas');
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
</x-page.admin>
