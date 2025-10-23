<x-guest-layout>
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/compiled/svg/logo.svg') }}" alt="Logo">
                    </a>
                </div>

                <h1 class="auth-title">Verifikasi Email</h1>
                <p class="auth-subtitle mb-4">
                    Terima kasih sudah mendaftar!  
                    Silakan cek email Anda dan klik link verifikasi.  
                    Jika belum menerima email, klik tombol di bawah untuk kirim ulang.
                </p>

                {{-- Status sukses kirim ulang --}}
                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success mb-4">
                        Link verifikasi baru telah dikirim ke email Anda.
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mt-4">
                    {{-- Kirim ulang email --}}
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            Kirim Ulang Email
                        </button>
                    </form>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">
                {{-- Bisa isi ilustrasi/bg sesuai kebutuhan --}}
            </div>
        </div>
    </div>
</x-guest-layout>
