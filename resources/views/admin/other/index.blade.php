<x-page.admin :title="__('Daftar Akun (Role: other)')">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Other</li>
    </ol>
  </nav>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="card-title mb-0">Akun Role: other</h5>
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
            @forelse ($others as $i => $o)
              <tr>
                <td>{{ $others->firstItem() + $i }}</td>
                <td class="fw-medium">{{ $o->name }}</td>
                <td>{{ $o->email }}</td>
                <td>
                  @php $role = $o->role ?? 'other'; @endphp
                  <span class="badge {{ $role==='other' ? 'bg-info' : 'bg-secondary' }}">{{ $role }}</span>
                </td>
                <td class="text-end">
                  {{-- Hanya boleh hapus saat role persis "other" --}}
                  @if (($o->role ?? 'other') === 'other')
                    <button class="btn btn-sm btn-outline-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#modalDeleteOther{{ $o->id }}">
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

              {{-- Modal Konfirmasi --}}
              <div class="modal fade" id="modalDeleteOther{{ $o->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Hapus Akun</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Yakin ingin menghapus akun <strong>{{ $o->name }}</strong> (role: other)?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                      <form action="{{ route('admin.others.destroy', $o->id) }}" method="POST" class="d-inline">
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
      <small class="text-muted">Hanya akun ber-role <code>other</code> yang bisa dihapus.</small>
      {{ $others->links() }}
    </div>
  </div>
</x-page.admin>
