<form method="post" action="{{ route('profile.update') }}" class="needs-validation" novalidate>
    @csrf
    @method('patch')

    <div class="mb-3">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input id="name" name="name" type="text" 
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $user->name) }}" required autofocus>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Alamat Email</label>
        <input id="email" name="email" type="email" 
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="mb-3">
            <p class="text-warning">
                Email Anda belum terverifikasi.
                <button form="send-verification" class="btn btn-sm btn-outline-primary ms-2">
                    Kirim Ulang Link Verifikasi
                </button>
            </p>
        </div>
    @endif

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>
