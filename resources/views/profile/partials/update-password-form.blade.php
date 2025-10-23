<form method="post" action="{{ route('password.update') }}" class="needs-validation" novalidate>
    @csrf
    @method('put')

    <div class="mb-3">
        <label for="current_password" class="form-label">Password Sekarang</label>
        <input id="current_password" name="current_password" type="password" 
               class="form-control @error('current_password') is-invalid @enderror"
               autocomplete="current-password">
        @error('current_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password Baru</label>
        <input id="password" name="password" type="password" 
               class="form-control @error('password') is-invalid @enderror"
               autocomplete="new-password">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
        <input id="password_confirmation" name="password_confirmation" type="password" 
               class="form-control"
               autocomplete="new-password">
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Ubah Password</button>
    </div>
</form>
