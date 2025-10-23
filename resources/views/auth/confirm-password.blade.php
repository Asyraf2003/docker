<x-guest-layout>
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/compiled/svg/logo.svg') }}" alt="Logo">
                    </a>
                </div>

                <h1 class="auth-title">Konfirmasi Password</h1>
                <p class="auth-subtitle mb-5">
                    Ini area aman. Masukkan password untuk melanjutkan.
                </p>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="password" type="password" name="password"
                            class="form-control form-control-xl @error('password') is-invalid @enderror"
                            placeholder="Password" required autocomplete="current-password" autofocus>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg shadow-lg">
                            Konfirmasi
                        </button>
                    </div>
                </form>

                @if (Route::has('password.request'))
                    <div class="text-center mt-4">
                        <a class="font-bold" href="{{ route('password.request') }}">Lupa password?</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">
                {{-- opsional: ilustrasi/background --}}
            </div>
        </div>
    </div>
</x-guest-layout>
