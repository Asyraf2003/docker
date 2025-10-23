<div class="alert alert-danger">
    <h6 class="alert-heading">Hapus Akun</h6>
    <p class="mb-0">
        Menghapus akun akan menghapus seluruh data secara permanen. 
        Tindakan ini <strong>tidak bisa dibatalkan</strong>.
    </p>
</div>

<form method="post" action="{{ route('profile.destroy') }}">
    @csrf
    @method('delete')

    <div class="mb-3">
        <label for="password" class="form-label">Masukkan Password untuk Konfirmasi</label>
        <input id="password" name="password" type="password" 
               class="form-control @error('password') is-invalid @enderror"
               placeholder="Password Anda">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-danger">Hapus Akun</button>
    </div>
</form>
