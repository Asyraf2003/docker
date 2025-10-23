<x-page.admin>
  <x-slot name="header">
    <header class="mb-3 d-flex align-items-center justify-content-between">
      <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
      </a>
      <div class="d-none d-xl-flex align-items-center gap-2">
        <span class="badge bg-primary-subtle text-primary">TA 2025/2026</span>
        <span class="badge bg-info-subtle text-info">Dashboard Super Admin</span>
      </div>
    </header>
  </x-slot>

  <div class="page-heading">
    <h1 class="font-semibold text-xxl text-gray-800 leading-tight">
      Super Admin Dashboard
    </h1>
    <p class="text-muted mt-1">Ringkasan operasional, akademik, finansial, & kesehatan sistem</p>
  </div>

  <div class="page-content">
    <section class="row">

      {{-- ========= LEFT: MAIN CONTENT ========= --}}
      <div class="col-12 col-xxl-9">

        {{-- TOP KPIs --}}
        <div class="row g-3">
          <div class="col-6 col-lg-3 col-md-6">
            <div class="card h-100">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                    <div class="stats-icon purple mb-2"><i class="bi bi-people-fill"></i></div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">Total Siswa</h6>
                    <h6 class="font-extrabold mb-0">1.236</h6>
                    <div class="small text-success">+3.1% bln ini</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-6 col-lg-3 col-md-6">
            <div class="card h-100">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                    <div class="stats-icon blue mb-2"><i class="bi bi-person-badge-fill"></i></div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">Guru & Staff</h6>
                    <h6 class="font-extrabold mb-0">87</h6>
                    <div class="small text-muted">Aktif: 82 • Cuti: 5</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-6 col-lg-3 col-md-6">
            <div class="card h-100">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                    <div class="stats-icon green mb-2"><i class="bi bi-grid-fill"></i></div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">Rombel/Kelas</h6>
                    <h6 class="font-extrabold mb-0">36</h6>
                    <div class="small text-muted">Rasio siswa/kelas: 34.3</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-6 col-lg-3 col-md-6">
            <div class="card h-100">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                    <div class="stats-icon red mb-2"><i class="bi bi-journal-text"></i></div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">PPDB (Minggu Ini)</h6>
                    <h6 class="font-extrabold mb-0">58</h6>
                    <div class="small text-success">+12 dibanding minggu lalu</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- PPDB TREND + FINANCE SUMMARY --}}
        <div class="row g-3 mt-1">
          <div class="col-12 col-xl-8">
            <div class="card h-100">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-graph-up-arrow me-2"></i>Tren Pendaftaran PPDB</h4>
                <div class="btn-group btn-group-sm">
                  <a href="#" class="btn btn-outline-secondary active">8 minggu</a>
                  <a href="#" class="btn btn-outline-secondary">Semester</a>
                  <a href="#" class="btn btn-outline-secondary">TA</a>
                </div>
              </div>
              <div class="card-body">
                <div id="chart-ppdb-trend" class="w-100" style="height: 280px;"></div>
                <div class="row text-center mt-3">
                  <div class="col-4">
                    <div class="small text-muted">Baru</div>
                    <div class="fw-semibold">120</div>
                  </div>
                  <div class="col-4">
                    <div class="small text-muted">Diterima</div>
                    <div class="fw-semibold">86</div>
                  </div>
                  <div class="col-4">
                    <div class="small text-muted">Ditolak</div>
                    <div class="fw-semibold">14</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Finance Summary (SPP, Donasi, Operasional) --}}
          <div class="col-12 col-xl-4">
            <div class="card h-100">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-cash-coin me-2"></i>Ringkasan Keuangan</h4>
                <a href="#" class="btn btn-sm btn-outline-primary">Detail</a>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between small">
                  <span>SPP Terkumpul</span><span class="fw-semibold">Rp 142.500.000</span>
                </div>
                <div class="progress mb-3" style="height:6px;"><div class="progress-bar bg-success" style="width:72%"></div></div>

                <div class="d-flex justify-content-between small">
                  <span>Donasi / BOS</span><span class="fw-semibold">Rp 38.200.000</span>
                </div>
                <div class="progress mb-3" style="height:6px;"><div class="progress-bar bg-info" style="width:56%"></div></div>

                <div class="d-flex justify-content-between small">
                  <span>Pengeluaran Operasional</span><span class="fw-semibold">Rp 98.450.000</span>
                </div>
                <div class="progress mb-3" style="height:6px;"><div class="progress-bar bg-danger" style="width:40%"></div></div>

                <div class="alert alert-light border small mb-0">
                  <div><i class="bi bi-exclamation-circle me-1"></i> 12 siswa menunggak &gt; 2 bulan</div>
                  <a href="#" class="text-decoration-none">Lihat daftar penunggak</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- SYSTEM HEALTH + STORAGE + MODULES STATUS --}}
        <div class="row g-3 mt-1">
          <div class="col-12 col-xl-4">
            <div class="card h-100">
              <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-activity me-2"></i>Kesehatan Sistem</h4>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between small mb-2"><span>API Response Time</span><span>132 ms</span></div>
                <div class="progress mb-3" style="height:6px;"><div class="progress-bar" style="width:78%"></div></div>

                <div class="d-flex justify-content-between small mb-2"><span>CPU Server</span><span>43%</span></div>
                <div class="progress mb-3" style="height:6px;"><div class="progress-bar bg-warning" style="width:43%"></div></div>

                <div class="d-flex justify-content-between small mb-2"><span>RAM Terpakai</span><span>6.1 / 16 GB</span></div>
                <div class="progress mb-3" style="height:6px;"><div class="progress-bar bg-info" style="width:38%"></div></div>

                <div class="d-flex justify-content-between small mb-2"><span>Error Rate (24h)</span><span>0.21%</span></div>
                <div class="progress" style="height:6px;"><div class="progress-bar bg-success" style="width:12%"></div></div>
              </div>
            </div>
          </div>

          <div class="col-12 col-xl-4">
            <div class="card h-100">
              <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-hdd-stack me-2"></i>Storage & Backup</h4>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between small">
                  <span>Disk Usage</span><span>68%</span>
                </div>
                <div class="progress mb-3" style="height:6px;"><div class="progress-bar bg-primary" style="width:68%"></div></div>

                <ul class="list-group list-group-flush">
                  <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-file-earmark-text me-2"></i>Dokumen</span><span class="badge bg-secondary">24 GB</span>
                  </li>
                  <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-image me-2"></i>Media/Galeri</span><span class="badge bg-secondary">18 GB</span>
                  </li>
                  <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-archive me-2"></i>Backup</span><span class="badge bg-secondary">36 GB</span>
                  </li>
                </ul>

                <div class="mt-3 small">
                  <div class="d-flex justify-content-between"><span>Backup Terakhir</span><span>18 Sep 2025, 02:10</span></div>
                  <a href="#" class="btn btn-sm btn-outline-secondary mt-2 w-100"><i class="bi bi-download me-1"></i> Unduh Snapshot</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-xl-4">
            <div class="card h-100">
              <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-puzzle me-2"></i>Status Modul</h4>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span><i class="bi bi-check-circle-fill text-success me-2"></i>PPDB</span>
                  <span class="badge bg-success">Aktif</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span><i class="bi bi-check-circle-fill text-success me-2"></i>Akademik</span>
                  <span class="badge bg-success">Aktif</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span><i class="bi bi-dash-circle-fill text-warning me-2"></i>Keuangan</span>
                  <span class="badge bg-warning text-dark">Terbatas</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <span><i class="bi bi-x-circle-fill text-danger me-2"></i>Inventaris</span>
                  <span class="badge bg-danger">Nonaktif</span>
                </div>
                <a href="#" class="btn btn-sm btn-outline-primary w-100 mt-3">Kelola Modul</a>
              </div>
            </div>
          </div>
        </div>

        {{-- APPROVAL QUEUE + LATEST ACTIVITY --}}
        <div class="row g-3 mt-1">
          <div class="col-12 col-xl-6">
            <div class="card h-100">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-shield-check me-2"></i>Antrean Persetujuan</h4>
                <a href="#" class="btn btn-sm btn-outline-secondary">Semua</a>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table mb-0 align-middle">
                    <thead><tr><th>Jenis</th><th>Pengaju</th><th>Waktu</th><th>Aksi</th></tr></thead>
                    <tbody>
                      <tr>
                        <td>Perizinan Siswa</td>
                        <td>Andi K (XI IPA 2)</td>
                        <td>18 Sep 09:10</td>
                        <td>
                          <div class="btn-group btn-group-sm">
                            <a href="#" class="btn btn-success">Terima</a>
                            <a href="#" class="btn btn-danger">Tolak</a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Registrasi Guru</td>
                        <td>Sri W (Fisika)</td>
                        <td>18 Sep 08:22</td>
                        <td>
                          <div class="btn-group btn-group-sm">
                            <a href="#" class="btn btn-success">Aktifkan</a>
                            <a href="#" class="btn btn-outline-secondary">Detail</a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Artikel</td>
                        <td>Admin OSIS</td>
                        <td>17 Sep 21:03</td>
                        <td>
                          <div class="btn-group btn-group-sm">
                            <a href="#" class="btn btn-outline-primary">Review</a>
                            <a href="#" class="btn btn-outline-secondary">Edit</a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Pengadaan</td>
                        <td>Bendahara</td>
                        <td>17 Sep 16:40</td>
                        <td>
                          <div class="btn-group btn-group-sm">
                            <a href="#" class="btn btn-outline-primary">Cek</a>
                            <a href="#" class="btn btn-outline-secondary">Lampiran</a>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer small text-muted">
                4 item menunggu tindakan.
              </div>
            </div>
          </div>

          <div class="col-12 col-xl-6">
            <div class="card h-100">
              <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-clock-history me-2"></i>Aktivitas Terbaru</h4>
              </div>
              <div class="card-body">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item px-0 d-flex align-items-start">
                    <i class="bi bi-circle-fill text-success small me-2"></i>
                    <div><div class="fw-semibold">Sync Raport</div><div class="small text-muted">Berhasil • 18 Sep 08:05</div></div>
                  </li>
                  <li class="list-group-item px-0 d-flex align-items-start">
                    <i class="bi bi-circle-fill text-warning small me-2"></i>
                    <div><div class="fw-semibold">Backup Harian</div><div class="small text-muted">Peringatan storage • 18 Sep 02:10</div></div>
                  </li>
                  <li class="list-group-item px-0 d-flex align-items-start">
                    <i class="bi bi-circle-fill text-danger small me-2"></i>
                    <div><div class="fw-semibold">API Payment</div><div class="small text-muted">Timeout • 17 Sep 22:47</div></div>
                  </li>
                  <li class="list-group-item px-0 d-flex align-items-start">
                    <i class="bi bi-circle-fill text-primary small me-2"></i>
                    <div><div class="fw-semibold">Import Siswa Baru</div><div class="small text-muted">Selesai • 17 Sep 19:30</div></div>
                  </li>
                </ul>
                <a href="#" class="btn btn-sm btn-outline-secondary mt-3 w-100">Lihat Log</a>
              </div>
            </div>
          </div>
        </div>

        {{-- CONTENT MODERATION + COMMENTS --}}
        <div class="row g-3 mt-1">
          <div class="col-12 col-xl-5">
            <div class="card h-100">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-newspaper me-2"></i>Konten Menunggu Moderasi</h4>
                <a href="#" class="btn btn-sm btn-outline-secondary">Kelola</a>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table mb-0 align-middle">
                    <thead><tr><th>Judul</th><th>Pengirim</th><th>Kategori</th><th>Aksi</th></tr></thead>
                    <tbody>
                      <tr>
                        <td>Tips Belajar SNBT</td><td>BK</td><td>Artikel</td>
                        <td><a href="#" class="btn btn-sm btn-light">Review</a></td>
                      </tr>
                      <tr>
                        <td>Poster Lomba Kebersihan</td><td>OSIS</td><td>Pengumuman</td>
                        <td><a href="#" class="btn btn-sm btn-light">Review</a></td>
                      </tr>
                      <tr>
                        <td>Materi Hukum Ohm (PPT)</td><td>Fisika</td><td>Materi</td>
                        <td><a href="#" class="btn btn-sm btn-light">Review</a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer small text-muted">3 konten menunggu review.</div>
            </div>
          </div>

          <div class="col-12 col-xl-7">
            <div class="card h-100">
              <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-chat-dots me-2"></i>Komentar Terbaru</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover table-lg">
                    <thead><tr><th>Nama</th><th>Komentar</th><th>Konten</th><th>Waktu</th></tr></thead>
                    <tbody>
                      <tr>
                        <td class="col-3">
                          <div class="d-flex align-items-center">
                            <div class="avatar avatar-md"><img src="{{ asset('assets/compiled/jpg/5.jpg') }}"></div>
                            <p class="font-bold ms-3 mb-0">Liya Cantik</p>
                          </div>
                        </td>
                        <td class="col-auto"><p class="mb-0">Artikelnya membantu banget, makasih!</p></td>
                        <td class="col-2"><span class="badge bg-primary">Artikel</span></td>
                        <td class="col-2"><p class="mb-0">18-09-2025</p></td>
                      </tr>
                      <tr>
                        <td class="col-3">
                          <div class="d-flex align-items-center">
                            <div class="avatar avatar-md"><img src="{{ asset('assets/compiled/jpg/2.jpg') }}"></div>
                            <p class="font-bold ms-3 mb-0">Asyraf</p>
                          </div>
                        </td>
                        <td class="col-auto"><p class="mb-0">Mohon update jadwal tryout ya.</p></td>
                        <td class="col-2"><span class="badge bg-info">Pengumuman</span></td>
                        <td class="col-2"><p class="mb-0">17-09-2025</p></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="text-end">
                  <a href="#" class="btn btn-outline-primary btn-sm">Kelola Komentar</a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      {{-- ========= RIGHT: SIDEBAR WIDGETS ========= --}}
      <div class="col-12 col-xxl-3">

        {{-- PROFILE CARD --}}
        <div class="card">
          <div class="card-body py-4 px-4">
            <div class="d-flex align-items-center">
              <div class="avatar avatar-xl">
                <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Admin Avatar">
              </div>
              <div class="ms-3 name">
                <h5 class="font-bold">Super Admin</h5>
                <h6 class="text-muted mb-0">superadmin@sekolah.id</h6>
              </div>
            </div>
          </div>
        </div>

        {{-- QUICK ACTIONS --}}
        <div class="card">
          <div class="card-header">
            <h4 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h4>
          </div>
          <div class="card-body">
            <div class="d-grid gap-2">
              <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-person-plus me-1"></i> Tambah Akun</a>
              <a href="#" class="btn btn-outline-success btn-sm"><i class="bi bi-gear me-1"></i> Konfigurasi Sistem</a>
              <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-shield-lock me-1"></i> Roles & Permission</a>
              <a href="#" class="btn btn-outline-info btn-sm"><i class="bi bi-cloud-arrow-up me-1"></i> Jalankan Backup</a>
            </div>
          </div>
        </div>

        {{-- VISITOR/USAGE CHART --}}
        <div class="card">
          <div class="card-header">
            <h4 class="mb-0"><i class="bi bi-people me-2"></i>Traffic Aplikasi</h4>
          </div>
          <div class="card-body">
            <div id="chart-profile-visit" style="height:180px;"></div>
            <div class="row text-center mt-2">
              <div class="col-4"><div class="small text-muted">Hari Ini</div><div class="fw-semibold">1.2k</div></div>
              <div class="col-4"><div class="small text-muted">Minggu</div><div class="fw-semibold">7.8k</div></div>
              <div class="col-4"><div class="small text-muted">Bulan</div><div class="fw-semibold">31k</div></div>
            </div>
          </div>
        </div>

        {{-- REGION SPLIT --}}
        <div class="card">
          <div class="card-header"><h4 class="mb-0"><i class="bi bi-geo me-2"></i>Asal Pengguna</h4></div>
          <div class="card-body">
            <div class="row">
              <div class="col-7">
                <div class="d-flex align-items-center">
                  <svg class="bi text-primary" width="32" height="32" style="width:10px">
                    <use xlink:href="{{ asset('assets/static/images/bootstrap-icons.svg#circle-fill') }}"></use>
                  </svg>
                  <h6 class="mb-0 ms-3">Jawa</h6>
                </div>
              </div>
              <div class="col-5 text-end fw-semibold">862</div>
              <div class="col-12"><div id="chart-jawa" style="height:80px;"></div></div>
            </div>
            <div class="row mt-2">
              <div class="col-7">
                <div class="d-flex align-items-center">
                  <svg class="bi text-success" width="32" height="32" style="width:10px">
                    <use xlink:href="{{ asset('assets/static/images/bootstrap-icons.svg#circle-fill') }}"></use>
                  </svg>
                  <h6 class="mb-0 ms-3">Sumatera</h6>
                </div>
              </div>
              <div class="col-5 text-end fw-semibold">375</div>
              <div class="col-12"><div id="chart-sumatera" style="height:80px;"></div></div>
            </div>
            <div class="row mt-2">
              <div class="col-7">
                <div class="d-flex align-items-center">
                  <svg class="bi text-danger" width="32" height="32" style="width:10px">
                    <use xlink:href="{{ asset('assets/static/images/bootstrap-icons.svg#circle-fill') }}"></use>
                  </svg>
                  <h6 class="mb-0 ms-3">Kalimantan</h6>
                </div>
              </div>
              <div class="col-5 text-end fw-semibold">221</div>
              <div class="col-12"><div id="chart-kalimantan" style="height:80px;"></div></div>
            </div>
          </div>
        </div>

        {{-- TODOs --}}
        <div class="card">
          <div class="card-header"><h4 class="mb-0"><i class="bi bi-list-check me-2"></i>To-Do</h4></div>
          <div class="card-body">
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" id="todo1">
              <label class="form-check-label" for="todo1">Verifikasi 25 akun guru baru</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" id="todo2" checked>
              <label class="form-check-label" for="todo2">Jadwalkan backup mingguan</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="todo3">
              <label class="form-check-label" for="todo3">Audit permission modul Keuangan</label>
            </div>
            <a href="#" class="btn btn-sm btn-outline-secondary w-100 mt-3">Kelola To-Do</a>
          </div>
        </div>

      </div>
    </section>
  </div>

  <footer>
    <div class="footer clearfix mb-0 text-muted">
      <div class="float-start"><p>2025 &copy; Sekolah</p></div>
      <div class="float-end">
        <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span> by Asyraf</p>
      </div>
    </div>
  </footer>
</x-page.admin>
