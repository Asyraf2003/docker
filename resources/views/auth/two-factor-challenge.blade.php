<x-guest-layout>
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo mb-3">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/compiled/svg/logo.svg') }}" alt="Logo">
                    </a>
                </div>

                <h1 class="auth-title">Masukkan Kode 2FA</h1>
                <p class="auth-subtitle mb-5">
                    Ketik <strong>6 digit</strong> dari aplikasi authenticator <em>atau</em> gunakan <strong>recovery code</strong>.
                </p>

                {{-- Form: 6-Digit Authenticator Code --}}
                <form method="POST" action="{{ url('/two-factor-challenge') }}" class="mb-4">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input
                            name="code"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            minlength="6"
                            maxlength="6"
                            autofocus
                            class="form-control form-control-xl @error('code') is-invalid @enderror"
                            placeholder="Kode 6 digit">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg shadow-lg">
                            Verifikasi
                        </button>
                    </div>
                </form>

                {{-- Separator --}}
                <div class="text-center text-muted my-3">
                    <span>atau</span>
                </div>

                {{-- Form: Recovery Code --}}
                <form method="POST" action="{{ url('/two-factor-challenge') }}">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input
                            name="recovery_code"
                            class="form-control form-control-xl @error('recovery_code') is-invalid @enderror"
                            placeholder="Recovery code">
                        <div class="form-control-icon">
                            <i class="bi bi-key"></i>
                        </div>
                        @error('recovery_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                            Kembali ke Login
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg shadow-lg">
                            Verifikasi dengan Recovery Code
                        </button>
                    </div>
                </form>

                {{-- Opsional: bantuan --}}
                <div class="text-center mt-4">
                    <small class="text-muted">
                        Tidak bisa mengakses aplikasi authenticator? Gunakan recovery code yang kamu simpan saat mengaktifkan 2FA.
                    </small>
                </div>
            </div>
        </div>

        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">
                {{-- opsional: ilustrasi/background Mazer --}}
            </div>
        </div>
    </div>
</x-guest-layout>
