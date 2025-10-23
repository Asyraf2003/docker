{{-- resources/views/auth/two-factor-settings.blade.php --}}
<x-guest-layout>
    @php
        /** @var \App\Models\User $user */
        $user = ($user ?? auth()->user());
        $enabled   = ! is_null($user?->two_factor_secret);
        $confirmed = ! is_null($user?->two_factor_confirmed_at);
        $codes     = $confirmed ? $user->recoveryCodes() : null;
    @endphp

    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">

                <div class="auth-logo mb-3">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/compiled/svg/logo.svg') }}" alt="Logo">
                    </a>
                </div>

                <h1 class="auth-title">Keamanan Akun Admin</h1>
                <p class="auth-subtitle mb-4">
                    Lindungi akun dengan <strong>Two-Factor Authentication</strong>.
                </p>

                {{-- Status flash --}}
                @if (session('status'))
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        <div>{!! session('status') !!}</div>
                    </div>
                @endif

                {{-- Validasi/Error umum --}}
                @if ($errors->any())
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <div>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- STEP 1: Enable 2FA --}}
                @unless ($enabled)
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h5 class="card-title mb-2">Langkah 1 — Aktifkan 2FA</h5>
                            <p class="text-muted mb-3">Klik tombol di bawah untuk menghasilkan QR.</p>
                            <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg shadow-lg">
                                    <i class="bi bi-shield-plus me-1"></i> Aktifkan 2FA
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    {{-- STEP 2: Confirm 2FA --}}
                    @unless ($confirmed)
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <h5 class="card-title mb-2">Langkah 2 — Konfirmasi 2FA</h5>
                                <p class="text-muted">
                                    Scan QR ini dengan aplikasi Authenticator (Google Authenticator, Authy, 1Password, Bitwarden, dll.),
                                    lalu masukkan <strong>kode 6 digit</strong>.
                                </p>

                                <div class="my-3">
                                    {!! $user->twoFactorQrCodeSvg() !!}
                                </div>

                                <form method="POST" action="{{ url('/user/confirmed-two-factor-authentication') }}">
                                    @csrf
                                    <div class="form-group position-relative has-icon-left mb-4">
                                        <input
                                            name="code"
                                            inputmode="numeric"
                                            pattern="[0-9]*"
                                            minlength="6"
                                            maxlength="6"
                                            required
                                            class="form-control form-control-xl @error('code') is-invalid @enderror"
                                            placeholder="Kode OTP (6 digit)">
                                        <div class="form-control-icon">
                                            <i class="bi bi-shield-lock"></i>
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
                                            Konfirmasi 2FA
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        {{-- ACTIVE & CONFIRMED --}}
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-shield-check me-2"></i>
                            <div>2FA sudah aktif & terkonfirmasi.</div>
                        </div>

                        <div class="d-flex gap-2 flex-wrap mb-3">
                            {{-- Regenerate recovery codes --}}
                            <form method="POST" action="{{ url('/user/two-factor-recovery-codes') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="bi bi-arrow-repeat me-1"></i> Regenerasi Recovery Codes
                                </button>
                            </form>

                            {{-- Disable 2FA --}}
                            <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger"
                                    onclick="return confirm('Nonaktifkan 2FA?')">
                                    <i class="bi bi-shield-slash me-1"></i> Nonaktifkan 2FA
                                </button>
                            </form>
                        </div>

                        {{-- Recovery codes (opsional tampil) --}}
                        @if (!empty($codes))
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title mb-2">
                                        <i class="bi bi-key me-1"></i> Recovery Codes
                                    </h6>
                                    <p class="text-muted mb-2">
                                        Simpan kode-kode ini di tempat aman. Gunakan saat tidak bisa mengakses aplikasi authenticator.
                                    </p>
                                    <pre class="mb-0" style="white-space:pre-wrap">{{ implode(PHP_EOL, $codes) }}</pre>
                                </div>
                            </div>
                        @endif
                    @endunless
                @endunless
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg shadow-lg mt-1 w-100 w-md-auto">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">
            </div>
        </div>
    </div>
</x-guest-layout>
