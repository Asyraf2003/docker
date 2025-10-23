<x-page.other>
    <x-slot name="header">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
    </x-slot>
    <section class="row">
        <div class="d-none d-xl-flex align-items-center gap-2">
          <span class="badge bg-primary-subtle text-primary">Tahun Ajaran 2025/2026</span>
          <span class="badge bg-info-subtle text-info">Semester Ganjil</span>
        </div>
        <hr>
      {{-- ====== LEFT CONTENT ====== --}}
      <div class="col-12 col-lg-9">
        {{-- STATS --}}
        <div class="row g-3">
          <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                    <div class="stats-icon purple mb-2">
                      <i class="bi bi-book"></i>
                    </div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">Mata Pelajaran</h6>
                    <h6 class="font-extrabold mb-0">12</h6>
                  </div>
                </div> 
              </div>
            </div>
          </div>

          <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                    <div class="stats-icon blue mb-2">
                      <i class="bi bi-clipboard-check"></i>
                    </div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">Tugas Pending</h6>
                    <h6 class="font-extrabold mb-0">5</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                    <div class="stats-icon green mb-2">
                      <i class="bi bi-bar-chart-line"></i>
                    </div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">Nilai Rata-rata</h6>
                    <h6 class="font-extrabold mb-0">87</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
              <div class="card-body px-4 py-4-5">
                <div class="row">
                  <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                    <div class="stats-icon red mb-2">
                      <i class="bi bi-calendar-check"></i>
                    </div>
                  </div>
                  <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                    <h6 class="text-muted font-semibold">Kehadiran</h6>
                    <h6 class="font-extrabold mb-0">95%</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- UPCOMING CLASSES --}}
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-calendar3 me-2"></i>Jadwal Mengajar Hari Ini</h5>
            <a href="#" class="btn btn-sm btn-outline-primary">
              <i class="bi bi-view-list me-1"></i> Lihat Semua
            </a>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table mb-0 align-middle">
                <thead>
                  <tr>
                    <th>Waktu</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th>Ruangan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>07:30 - 09:10</td>
                    <td>X IPA 1</td>
                    <td>Matematika</td>
                    <td>R-201</td>
                    <td><a href="#" class="btn btn-sm btn-light">Detail</a></td>
                  </tr>
                  <tr>
                    <td>09:30 - 11:10</td>
                    <td>XII IPS 2</td>
                    <td>Ekonomi</td>
                    <td>R-305</td>
                    <td><a href="#" class="btn btn-sm btn-light">Detail</a></td>
                  </tr>
                  <tr>
                    <td>13:00 - 14:40</td>
                    <td>XI IPA 3</td>
                    <td>Fisika</td>
                    <td>Lab Fisika</td>
                    <td><a href="#" class="btn btn-sm btn-light">Detail</a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        {{-- TASKS / TUGAS PENDING --}}
        <div class="row">
          <div class="col-12 col-xl-7">
            <div class="card h-100">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clipboard-data me-2"></i>Tugas / PR Pending</h5>
                <a href="#" class="btn btn-sm btn-outline-secondary">Kelola</a>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table mb-0 align-middle">
                    <thead>
                      <tr>
                        <th>Judul</th>
                        <th>Kelas</th>
                        <th>Deadline</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Latihan Trigonometri</td>
                        <td>X IPA 1</td>
                        <td>20 Okt</td>
                        <td><span class="badge bg-warning">Menunggu Nilai</span></td>
                      </tr>
                      <tr>
                        <td>Esai Pasar Bebas</td>
                        <td>XII IPS 2</td>
                        <td>22 Okt</td>
                        <td><span class="badge bg-info">Proses</span></td>
                      </tr>
                      <tr>
                        <td>Praktikum Hukum Ohm</td>
                        <td>XI IPA 3</td>
                        <td>23 Okt</td>
                        <td><span class="badge bg-secondary">Draft</span></td>
                      </tr>
                      <tr>
                        <td>Kuis Bab 4</td>
                        <td>X IPA 2</td>
                        <td>24 Okt</td>
                        <td><span class="badge bg-warning">Menunggu Nilai</span></td>
                      </tr>
                      <tr>
                        <td>Review Ulangan Harian</td>
                        <td>X IPA 1</td>
                        <td>25 Okt</td>
                        <td><span class="badge bg-info">Proses</span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer small text-muted">
                5 tugas perlu perhatian. <a href="#">Lihat semua tugas</a>
              </div>
            </div>
          </div>

          {{-- QUICK ACTIONS / SHORTCUTS --}}
          <div class="col-12 col-xl-5">
            <div class="card h-100">
              <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h5>
              </div>
              <div class="card-body">
                <div class="row g-2">
                  <div class="col-6">
                    <a href="#" class="btn btn-outline-primary w-100"><i class="bi bi-plus-circle me-1"></i> Buat Tugas</a>
                  </div>
                  <div class="col-6">
                    <a href="#" class="btn btn-outline-success w-100"><i class="bi bi-clipboard-check me-1"></i> Input Nilai</a>
                  </div>
                  <div class="col-6">
                    <a href="#" class="btn btn-outline-secondary w-100"><i class="bi bi-people me-1"></i> Absensi Siswa</a>
                  </div>
                  <div class="col-6">
                    <a href="#" class="btn btn-outline-info w-100"><i class="bi bi-calendar-event me-1"></i> Tambah Agenda</a>
                  </div>
                </div>

                <hr class="my-3">

                <div class="small text-muted">Progress Penilaian Minggu Ini</div>
                <div class="mt-2">
                  <div class="d-flex justify-content-between small"><span>Matematika X IPA 1</span><span>60%</span></div>
                  <div class="progress mb-2" style="height: 6px;">
                    <div class="progress-bar bg-primary" style="width: 60%"></div>
                  </div>
                  <div class="d-flex justify-content-between small"><span>Ekonomi XII IPS 2</span><span>35%</span></div>
                  <div class="progress mb-2" style="height: 6px;">
                    <div class="progress-bar bg-success" style="width: 35%"></div>
                  </div>
                  <div class="d-flex justify-content-between small"><span>Fisika XI IPA 3</span><span>80%</span></div>
                  <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-warning" style="width: 80%"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- GRADE OVERVIEW --}}
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Ringkasan Nilai & Kehadiran</h5>
            <div class="btn-group btn-group-sm">
              <a href="#" class="btn btn-outline-secondary active">Minggu Ini</a>
              <a href="#" class="btn btn-outline-secondary">Bulan Ini</a>
              <a href="#" class="btn btn-outline-secondary">Semester</a>
            </div>
          </div>
          <div class="card-body">
            {{-- Placeholder chart area (dummy) --}}
            <div class="border rounded-3 p-4 text-center text-muted">
              <i class="bi bi-graph-up-arrow fs-3 d-block mb-2"></i>
              <div>Area grafik placeholder. Nanti bisa diganti pakai Chart.js/any.</div>
            </div>
            <div class="row text-center mt-3">
              <div class="col-6 col-md-3">
                <div class="small text-muted">Tuntas KKM</div>
                <div class="fs-5 fw-semibold">78%</div>
              </div>
              <div class="col-6 col-md-3">
                <div class="small text-muted">Rata Nilai</div>
                <div class="fs-5 fw-semibold">87.3</div>
              </div>
              <div class="col-6 col-md-3">
                <div class="small text-muted">Absensi Siswa</div>
                <div class="fs-5 fw-semibold">95%</div>
              </div>
              <div class="col-6 col-md-3">
                <div class="small text-muted">Absensi Guru</div>
                <div class="fs-5 fw-semibold">100%</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- ====== RIGHT SIDEBAR WIDGETS ====== --}}
      <div class="col-12 col-lg-3">
        {{-- AGENDA --}}
        <div class="card">
          <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-calendar-event me-2"></i>Agenda / Acara</h6>
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush">
              <li class="list-group-item px-0 d-flex align-items-start">
                <i class="bi bi-circle-fill me-2 text-primary small"></i>
                <div>
                  <div class="fw-semibold">Rapat Kurikulum</div>
                  <div class="small text-muted">Hari ini, 15:00 • Ruang Guru</div>
                </div>
              </li>
              <li class="list-group-item px-0 d-flex align-items-start">
                <i class="bi bi-circle-fill me-2 text-success small"></i>
                <div>
                  <div class="fw-semibold">Tryout Kelas XII</div>
                  <div class="small text-muted">20 Okt, 08:00 • AULA</div>
                </div>
              </li>
              <li class="list-group-item px-0 d-flex align-items-start">
                <i class="bi bi-circle-fill me-2 text-warning small"></i>
                <div>
                  <div class="fw-semibold">Workshop PTK</div>
                  <div class="small text-muted">22 Okt, 09:00 • Lab Komputer</div>
                </div>
              </li>
            </ul>
            <a href="#" class="btn btn-sm btn-outline-primary mt-3 w-100">Lihat Kalender</a>
          </div>
        </div>

        {{-- PENGUMUMAN --}}
        <div class="card">
          <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-megaphone me-2"></i>Pengumuman</h6>
          </div>
          <div class="card-body">
            <div class="alert alert-info py-2 px-3 mb-2">
              <div class="fw-semibold">Seragam Hari Jumat</div>
              <div class="small">Menggunakan batik sekolah.</div>
            </div>
            <div class="alert alert-warning py-2 px-3 mb-2">
              <div class="fw-semibold">Upload Nilai</div>
              <div class="small">Batas input nilai bab 3: 25 Okt 23:59.</div>
            </div>
            <div class="alert alert-success py-2 px-3">
              <div class="fw-semibold">Lab Baru</div>
              <div class="small">Lab Fisika siap dipakai.</div>
            </div>
          </div>
        </div>

        {{-- BERKAS TERAKHIR --}}
        <div class="card">
          <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-folder2-open me-2"></i>Berkas / Dokumen</h6>
          </div>
          <div class="card-body">
            <ul class="list-unstyled mb-0">
              <li class="mb-2 d-flex justify-content-between align-items-center">
                <a href="#" class="text-decoration-none">
                  <i class="bi bi-file-earmark-text me-2"></i> Silabus Matematika X
                </a>
                <span class="badge bg-secondary">PDF</span>
              </li>
              <li class="mb-2 d-flex justify-content-between align-items-center">
                <a href="#" class="text-decoration-none">
                  <i class="bi bi-file-earmark-spreadsheet me-2"></i> Rekap Nilai XI
                </a>
                <span class="badge bg-success">XLSX</span>
              </li>
              <li class="d-flex justify-content-between align-items-center">
                <a href="#" class="text-decoration-none">
                  <i class="bi bi-file-earmark-ppt me-2"></i> Materi Hukum Ohm
                </a>
                <span class="badge bg-danger">PPT</span>
              </li>
            </ul>
            <a href="#" class="btn btn-sm btn-outline-secondary mt-3 w-100">Manajemen Berkas</a>
          </div>
        </div>

        {{-- PERIZINAN & KONSELING SHORTCUTS --}}
        <div class="card">
          <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-door-open-fill me-2"></i>Perizinan & Konseling</h6>
          </div>
          <div class="card-body">
            <div class="d-grid gap-2">
              <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-envelope-paper me-1"></i> Buat Surat Izin</a>
              <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-chat-dots-fill me-1"></i> Form Konseling</a>
              <a href="#" class="btn btn-outline-secondary btn-sm"><i class="bi bi-exclamation-triangle-fill me-1"></i> Data Pelanggaran</a>
            </div>
          </div>
        </div>
      </div>
    </section>
</x-page.other>
