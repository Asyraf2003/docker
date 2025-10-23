<x-page.admin :title="__('Daftar Pengguna (Role: user)')">
  {{-- Breadcrumb --}}
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">User</li>
    </ol>
  </nav>

  {{-- Card Tabel --}}
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title mb-0">Pengguna</h5>
      {{-- Tidak ada tombol Create/Edit sesuai aturan --}}
      <span class="badge bg-secondary">Aksi: Hanya Hapus</span>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width:56px">#</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Role</th>
              <th style="width:120px" class="text-end">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $i => $u)
              <tr>
                <td>{{ $users->firstItem() + $i }}</td>
                <td class="fw-medium">{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>
                  @php $role = $u->role ?? 'user'; @endphp
                  <span class="badge {{ $role==='user' ? 'bg-primary' : 'bg-secondary' }}">{{ $role }}</span>
                </td>
                <td class="text-end">
                  {{-- ADMIN hanya boleh hapus akun dengan role "user" --}}
                  @if (($u->role ?? 'user') === 'user')
                    <button class="btn btn-sm btn-outline-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#modalDeleteUser{{ $u->id }}">
                      <i class="bi bi-trash"></i>
                      <span class="ms-1">Hapus</span>
                    </button>
                  @else
                    <button class="btn btn-sm btn-outline-secondary" disabled title="Tidak diizinkan">
                      <i class="bi bi-x-circle"></i>
                      <span class="ms-1">Terkunci</span>
                    </button>
                  @endif
                </td>
              </tr>

              {{-- Modal Konfirmasi Hapus --}}
              <div class="modal fade" id="modalDeleteUser{{ $u->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Hapus Pengguna</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Yakin ingin menghapus akun <strong>{{ $u->name }}</strong>? Tindakan ini tidak dapat dibatalkan.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                      <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                          <i class="bi bi-trash"></i>
                          <span class="ms-1">Hapus</span>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">Belum ada data.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center">
      <small class="text-muted">Hanya akun ber-role <code>user</code> yang bisa dihapus.</small>
      {{ $users->links() }}
    </div>
  </div>
</x-page.admin>
