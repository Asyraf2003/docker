<x-guest-layout>
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/compiled/svg/logo.svg') }}" alt="Logo">
                    </a>
                </div>

                <h1 class="auth-title">Reset Password</h1>
                <p class="auth-subtitle mb-5">
                    Masukkan email dan password baru Anda.
                </p>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    {{-- Token reset dari link email --}}
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    {{-- Email --}}
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="email" type="email" name="email"
                            class="form-control form-control-xl @error('email') is-invalid @enderror"
                            placeholder="Email"
                            value="{{ old('email', $request->email) }}"
                            required autofocus autocomplete="username">
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password baru --}}
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="password" type="password" name="password"
                            class="form-control form-control-xl @error('password') is-invalid @enderror"
                            placeholder="Password baru" required autocomplete="new-password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Konfirmasi password --}}
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            class="form-control form-control-xl @error('password_confirmation') is-invalid @enderror"
                            placeholder="Konfirmasi password baru" required autocomplete="new-password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="submit">
                        Reset Password
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a class="font-bold" href="{{ route('login') }}">Kembali ke Login</a>
                </div>
            </div>
        </div>

        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">
                {{-- opsional: ilustrasi / background --}}
            </div>
        </div>
    </div>
</x-guest-layout>
