<x-guest-layout>
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">

                <div class="auth-logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/compiled/svg/logo.svg') }}" alt="Logo">
                    </a>
                </div>

                <h1 class="auth-title">Log in</h1>
                <p class="auth-subtitle mb-5">
                    Masuk dengan email dan password yang sudah kamu daftarkan.
                </p>
        
                {{-- Laravel login form --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" name="email"
                            class="form-control form-control-xl @error('email') is-invalid @enderror"
                            placeholder="Email" value="{{ old('email') }}" required autofocus autocomplete="username">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" name="password"
                            class="form-control form-control-xl @error('password') is-invalid @enderror"
                            placeholder="Password" required autocomplete="current-password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Remember me --}}
                    <div class="form-check form-check-lg d-flex align-items-end">
                        <input class="form-check-input me-2" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label text-gray-600" for="remember">
                            Keep me logged in
                        </label>
                    </div>

                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="submit">
                        Log in
                    </button>
                </form>

                {{-- Footer links --}}
                <div class="text-center mt-5 text-lg fs-4">
                    <p class="text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="font-bold">Sign up</a>.
                    </p>
                    @if (Route::has('password.request'))
                        <p>
                            <a class="font-bold" href="{{ route('password.request') }}">Forgot password?</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right">
            </div>
        </div>
    </div>
</x-guest-layout>
