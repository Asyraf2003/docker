<x-page.user>
    <x-slot name="header">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
    </x-slot>
    <div class="page-heading">
        <h1 class="font-semibold text-xxl text-gray-800 leading-tight">
            {{ __('Dashboard Siswa') }}
        </h1>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Terjadi kesalahan pada form pembayaran. Silakan periksa kembali.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div> 
    <div class="page-content"> 
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
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
                @if ($showPayCard)
                    <div class="card border border-warning mb-4">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-warning bg-opacity-25 text-warning d-flex align-items-center justify-content-center" style="width:3rem; height:3rem;">
                            <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                            <h5 class="card-title mb-1">Pembayaran Pendaftaran Belum Lunas</h5>
                            <p class="card-text text-muted mb-0">
                                Silakan segera melunasi biaya pendaftaran untuk mengaktifkan akun siswa Anda.
                            </p>
                            </div>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalBayarPpdb">
                            Bayar Sekarang
                            </button>
                        </div>
                    </div>
                @elseif ($latestPayment && $latestPayment->status === 'pending')
                    <div class="alert alert-info d-flex justify-content-between align-items-center">
                        <span>Bukti pembayaran sudah dikirim. Menunggu verifikasi admin.</span>
                        <a href="{{ route('user.transaksi.index') }}" class="btn btn-sm btn-outline-primary">Lihat status</a>
                    </div>
                @elseif ($latestPayment && $latestPayment->status === 'verified')
                    <div class="alert alert-success">Pembayaran terverifikasi. Terima kasih!</div>
                @endif
                <div class="modal fade" id="modalBayarPpdb" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Pembayaran Pendaftaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>

                        <form action="{{ route('user.ppdb.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                            {{-- Info tujuan & nominal --}}
                            <div class="row g-3">
                                <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <div class="fw-semibold mb-2">Tujuan Pembayaran</div>
                                    <ul class="mb-0 small">
                                    <li>BRI: <strong>1234-567-890</strong> a.n. <strong>Sekolah ABC</strong></li>
                                    <li>BNI: <strong>9876-543-210</strong> a.n. <strong>Sekolah ABC</strong></li>
                                    <li>QRIS: <em>Scan pada loket atau unduh dari portal</em></li>
                                    </ul>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <div class="fw-semibold mb-2">Nominal</div>
                                    @php $fee = (int) config('ppdb.fee', 150000); @endphp
                                    <input type="text" class="form-control mb-2" value="Rp {{ number_format($fee,0,',','.') }}" readonly>
                                    <div class="form-text">Nominal diizinkan lebih besar (rounding/biaya admin).</div>
                                </div>
                                </div>
                            </div>

                            {{-- Field form --}}
                            <div class="row g-3 mt-1">
                                <div class="col-md-4">
                                <label class="form-label">Metode</label>
                                <select name="metode" class="form-select">
                                    <option value="">Pilih...</option>
                                    <option>Transfer BRI</option>
                                    <option>Transfer BNI</option>
                                    <option>QRIS</option>
                                </select>
                                </div>
                                <div class="col-md-8">
                                <label class="form-label">Tujuan (No. Rekening / Keterangan)</label>
                                <input type="text" name="tujuan" class="form-control" placeholder="cth: BRI 1234-567-890 a.n Sekolah ABC">
                                </div>
                                <div class="col-md-6">
                                <label class="form-label">Nominal Transfer (Rp)</label>
                                <input type="number" name="amount" class="form-control" min="1000" value="{{ old('amount', $fee) }}">
                                </div>
                                <div class="col-md-6">
                                <label class="form-label">Bukti Pembayaran (jpg/png/webp)</label>
                                <input type="file" name="bukti" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                                </div>

                                {{-- optional jika kamu ingin kaitkan ke satu PPDB tertentu --}}
                                @isset($ppdb)
                                <input type="hidden" name="ppdb_id" value="{{ $ppdb->id }}">
                                @endisset
                            </div>

                            {{-- error tampil --}}
                            @if ($errors->any())
                                <div class="alert alert-danger mt-3 mb-0">
                                <ul class="mb-0 small">
                                    @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                                </div>
                            @endif
                            </div>

                            <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-cloud-arrow-up"></i> Kirim Bukti
                            </button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Statistik Kehadiran</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Statistik Belajar</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="d-flex align-items-center">
                                            <svg class="bi text-primary" width="32" height="32" fill="blue"
                                                style="width:10px">
                                                <use xlink:href="{{ asset('assets/static/images/bootstrap-icons.svg#circle-fill') }}"></use>
                                            </svg>
                                            <h5 class="mb-0 ms-3">Ipa</h5>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <h5 class="mb-0 text-end">91.50</h5>
                                    </div>
                                    <div class="col-12">
                                        <div id="chart-europe"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-7">
                                        <div class="d-flex align-items-center">
                                            <svg class="bi text-success" width="32" height="32" fill="blue"
                                                style="width:10px">
                                                <use xlink:href="{{ asset('assets/static/images/bootstrap-icons.svg#circle-fill') }}"></use>
                                            </svg>
                                            <h5 class="mb-0 ms-3">Bahasa Indonesia</h5>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <h5 class="mb-0 text-end">89.00</h5>
                                    </div>
                                    <div class="col-12">
                                        <div id="chart-america"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-7">
                                        <div class="d-flex align-items-center">
                                            <svg class="bi text-danger" width="32" height="32" fill="blue"
                                                style="width:10px">
                                                <use xlink:href="{{ asset('assets/static/images/bootstrap-icons.svg#circle-fill') }}"></use>
                                            </svg>
                                            <h5 class="mb-0 ms-3">Matematika</h5>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <h5 class="mb-0 text-end">81.50</h5>
                                    </div>
                                    <div class="col-12">
                                        <div id="chart-indonesia"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Histori Pembayaran SPP</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-lg">
                                        <thead>
                                            <tr>
                                                <th>Bulan</th>
                                                <th>Status</th>
                                                <th>Tanggal Bayar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md bg-primary text-white d-flex justify-content-center align-items-center">
                                                            <i class="bi bi-calendar"></i>
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Januari 2025</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <span class="badge bg-success">Lunas</span>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">05-01-2025</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md bg-primary text-white d-flex justify-content-center align-items-center">
                                                            <i class="bi bi-calendar"></i>
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Februari 2025</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <span class="badge bg-danger">Belum Bayar</span>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">-</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md bg-primary text-white d-flex justify-content-center align-items-center">
                                                            <i class="bi bi-calendar"></i>
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Maret 2025</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                                </td>
                                                <td class="col-auto">
                                                    <p class="mb-0">02-03-2025</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                @php
                    $latest = \App\Models\UangDaftarMasuk::where('user_id', Auth::id())
                        ->latest()->first();

                    [$icon, $color, $title] = match (optional($latest)->status) {
                        'verified' => ['bi-patch-check-fill', 'text-primary', 'Akun terverifikasi'],          
                        'pending'  => ['bi-patch-check',      'text-success', 'Menunggu verifikasi admin'],   
                        'rejected' => ['bi-x-circle-fill',    'text-danger',  'Bukti ditolak, unggah ulang'], 
                        default    => ['bi-dash-circle',      'text-secondary','Belum ada pembayaran'],       
                    };
                @endphp
                <div class="card">
                    <div class="card-body py-4 px-4">
                        <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="User Avatar">
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-bold d-flex align-items-center gap-2">
                                {{ Auth::user()->name }}
                                <i class="bi {{ $icon }} {{ $color }} raised-icon" 
                                    data-bs-toggle="tooltip" data-bs-title="{{ $title }}"
                                    aria-label="{{ $title }}"></i>
                            </h5>
                            <h6 class="text-muted mb-0">{{ Auth::user()->email }}</h6>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Tugas dari Guru</h4>
                    </div>
                    <div class="card-content pb-4">
                        <div class="recent-message d-flex px-4 py-3">
                            <div class="avatar avatar-lg">
                                <img src="{{ asset('assets/compiled/jpg/4.jpg') }}" alt="Guru 1">
                            </div>
                            <div class="name ms-4">
                                <h5 class="mb-1">Bu Siti</h5>
                                <h6 class="text-muted mb-0">Matematika - PR Bab 3</h6>
                            </div>
                        </div>
                        <div class="recent-message d-flex px-4 py-3">
                            <div class="avatar avatar-lg">
                                <img src="{{ asset('assets/compiled/jpg/5.jpg') }}" alt="Guru 2">
                            </div>
                            <div class="name ms-4">
                                <h5 class="mb-1">Pak Budi</h5>
                                <h6 class="text-muted mb-0">Bahasa Indonesia - Analisis Puisi</h6>
                            </div>
                        </div>
                        <div class="recent-message d-flex px-4 py-3">
                            <div class="avatar avatar-lg">
                                <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" alt="Guru 3">
                            </div>
                            <div class="name ms-4">
                                <h5 class="mb-1">Bu Lina</h5>
                                <h6 class="text-muted mb-0">IPA - Laporan Praktikum</h6>
                            </div>
                        </div>
                        <div class="px-4">
                            <button class='btn btn-block btn-xl btn-outline-primary font-bold mt-3'>
                                Lihat Semua Tugas
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Visitors Profile</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-visitors-profile"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer>
        <div class="footer clearfix mb-0 text-muted">
            <div class="float-start">
                <p>2023 &copy; Mazer</p>
            </div>
            <div class="float-end">
                <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                    by <a href="#">Asyraf</a></p>
            </div>
        </div>
    </footer>
    @if ($errors->any())
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function(){
                new bootstrap.Modal(document.getElementById('modalBayarPpdb')).show();
                });
            </script>
        @endpush
    @endif
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function(){
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
                .forEach(el => new bootstrap.Tooltip(el));
            });
        </script>
    @endpush
</x-page.user>
