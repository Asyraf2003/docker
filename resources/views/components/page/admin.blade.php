<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Judul fallback ke APP_NAME --}}
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    {{-- Keamanan --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO ringan --}}
    <meta name="description" content="@yield('meta_description', 'Dashboard')">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Favicon (pakai salah satu yang konsisten) --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/compiled/svg/favicon.svg') }}">
    <link rel="alternate icon" type="image/png" href="{{ asset('assets/compiled/img/favicon-32x32.png') }}">

    {{-- Warna UI browser (sesuaikan brand) --}}
    <meta name="theme-color" content="#0ea5e9">

    {{-- Styles: otomatis pilih light/dark --}}
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}">

</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="#">
                                <img src="{{ asset('assets/compiled/svg/logo.svg') }}" alt="Logo">
                            </a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                role="img" class="iconify iconify--system-uicons" width="20" height="20"
                                preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                </path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        {{-- ====== DASHBOARD / MENU UTAMA ====== --}}
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ Request::routeIs('admin.ppdb.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.ppdb.index') }}" class="sidebar-link">
                                <i class="bi bi-mortarboard-fill"></i>
                                <span>PPDB</span>
                                @isset($ppdbCount)
                                @if($ppdbCount > 0)
                                    <span class="badge bg-danger rounded-pill">{{ $ppdbCount }}</span>
                                @endif
                                @endisset
                            </a>
                        </li>

                        {{-- ====== SISWA ====== --}}
                        <li class="sidebar-item has-sub {{ Request::routeIs('admin.users.*') ? 'active' : '' }}">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-people-fill"></i>
                                <span>Siswa</span>
                            </a>
                            <ul class="submenu">
                                <li class="submenu-item {{ Request::routeIs('admin.users.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.users.index') }}" class="submenu-link">Siswa</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="#" class="submenu-link">Menu Siswa</a>
                                </li>
                            </ul>
                        </li>

                        {{-- ====== PEGAWAI ====== --}}
                        <li class="sidebar-title">Menu Pegawai</li>

                        <li class="sidebar-item has-sub {{ Request::routeIs('admin.others.*') ? 'active' : '' }}">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-briefcase-fill"></i>
                                <span>Pegawai</span>
                            </a>
                            <ul class="submenu">
                                <li class="submenu-item {{ Request::routeIs('admin.others.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.others.index') }}" class="submenu-link">Pegawai</a>
                                </li>
                                <li class="submenu-item">
                                    <a href="#" class="submenu-link">Absensi Pegawai</a>
                                </li>
                            </ul>
                        </li>

                        {{-- ====== KEUANGAN ====== --}}
                        <li class="sidebar-title">Keuangan</li>

                        <li class="sidebar-item has-sub {{ Request::routeIs('admin.transaksi.*') ? 'active' : '' }}">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-cash-coin"></i>
                                <span>Transaksi Siswa</span>
                            </a>
                            <ul class="submenu">
                                <li class="submenu-item {{ Request::routeIs('admin.transaksi.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.transaksi.index') }}" class="submenu-link">Transaksi PPDB</a>
                                </li>
                                <li class="submenu-item"><a href="#" class="submenu-link">Tabungan Siswa</a></li>
                                <li class="submenu-item"><a href="#" class="submenu-link">Transaksi Umum</a></li>
                                <li class="submenu-item"><a href="#" class="submenu-link">Penggajian</a></li>
                                <li class="submenu-item"><a href="#" class="submenu-link">Setting Pembayaran</a></li>
                                <li class="submenu-item"><a href="#" class="submenu-link">Laporan</a></li>
                            </ul>
                        </li>

                        {{-- ====== AKADEMIK ====== --}}
                        <li class="sidebar-title">Menu Akademik</li>

                        <li class="sidebar-item has-sub {{ Request::routeIs('admin.akademik.*') ? 'active' : '' }}">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-journal-bookmark-fill"></i>
                                <span>Akademik</span>
                            </a>
                            <ul class="submenu">
                                <li class="submenu-item"><a href="#" class="submenu-link">Mata Pelajaran</a></li>
                                <li class="submenu-item"><a href="#" class="submenu-link">Prestasi</a></li>
                            </ul>
                        </li>

                        {{-- ====== WEBSITE ====== --}}
                        <li class="sidebar-title">Website</li>

                        <li class="sidebar-item has-sub {{ Request::routeIs('admin.gallery.*') || Request::routeIs('admin.articles.*') || Request::routeIs('admin.comments.*') ? 'active' : '' }}">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-globe2"></i>
                                <span>Website</span>
                            </a>
                            <ul class="submenu">
                                <li class="submenu-item"><a href="#" class="submenu-link">Kegiatan</a></li>
                                <li class="submenu-item {{ Request::routeIs('admin.gallery.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.gallery.index') }}" class="submenu-link">Gallery</a>
                                </li>
                                <li class="submenu-item {{ Request::routeIs('admin.articles.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.articles.index') }}" class="submenu-link">Artikel</a>
                                </li>
                                <li class="submenu-item {{ Request::routeIs('admin.comments.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.comments.index') }}" class="submenu-link">Komentar</a>
                                </li>
                                <li class="submenu-item"><a href="#" class="submenu-link">Kontak</a></li>
                                <li class="submenu-item"><a href="#" class="submenu-link">Home</a></li>
                                <li class="submenu-item"><a href="#" class="submenu-link">Website</a></li>
                            </ul>
                        </li>

                        {{-- ====== PENGATURAN ====== --}}
                        <li class="sidebar-title">Pengaturan</li>

                        <li class="sidebar-item has-sub {{ Request::routeIs('admin.pengaturan.*') ? 'active' : '' }}">
                            <a href="#" class="sidebar-link">
                                <i class="bi bi-gear-fill"></i>
                                <span>Pengaturan</span>
                            </a>
                            <ul class="submenu">
                                <li class="submenu-item"><a href="#" class="submenu-link">Master Data</a></li>
                                <li class="submenu-item"><a href="#" class="submenu-link">Setting Umum</a></li>
                                <li class="submenu-item"><a href="#" class="submenu-link">Setting Akun</a></li>
                            </ul>
                        </li>

                        {{-- ====== AKUN (opsional di luar group) ====== --}}
                        <li class="sidebar-item {{ Request::routeIs('profile.edit') ? 'active' : '' }}"> 
                            <a href="{{ route('profile.edit') }}" class="sidebar-link"> 
                                <i class="bi bi-person"></i><span>Profile</span> 
                            </a> 
                        </li>
                        <li class="sidebar-item"> 
                            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                                @csrf 
                            </form>
                            <a href="{{ route('logout') }}" class="sidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> 
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span> 
                            </a> 
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main">
            {{ $slot }}
        </div>
    </div>
    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>

    <!-- Need: Apexcharts -->
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>

    <script src="{{ asset('assets/static/js/pages/dashboard.js') }}"></script>
    @stack('scripts')
</body>

</html>