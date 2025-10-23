<x-page.admin>
    <div class="page-heading">
    <h3 class="mb-3">Kelola Komentar</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
        </div>
    @endif

    {{-- Tabs status --}}
    @php
        $tab = $status ?: 'all';
        $badge = fn($s) => $counts[$s] ?? 0;
    @endphp

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
        <a class="nav-link {{ $tab==='all' ? 'active' : '' }}"
            href="{{ route('admin.comments.index', array_filter(['q'=>$q,'article_id'=>$articleId])) }}">
            Semua <span class="badge bg-secondary ms-1">{{ $countsAll }}</span>
        </a>
        </li>
        @foreach (['pending'=>'warning','approved'=>'success','rejected'=>'secondary','spam'=>'danger'] as $s => $cls)
        <li class="nav-item">
            <a class="nav-link {{ $tab===$s ? 'active' : '' }}"
            href="{{ route('admin.comments.index', array_filter(['status'=>$s,'q'=>$q,'article_id'=>$articleId])) }}">
            {{ ucfirst($s) }}
            <span class="badge bg-{{ $cls }} ms-1">{{ $badge($s) }}</span>
            </a>
        </li>
        @endforeach
    </ul>

    {{-- Filter --}}
    <form class="row g-2 align-items-end mb-3" method="GET" action="{{ route('admin.comments.index') }}">
        <input type="hidden" name="status" value="{{ $status }}">
        <div class="col-md-4">
        <label class="form-label">Cari</label>
        <input name="q" value="{{ $q }}" class="form-control" placeholder="nama, email, isi komentar">
        </div>
        <div class="col-md-4">
        <label class="form-label">Artikel</label>
        <select name="article_id" class="form-select">
            <option value="">— Semua Artikel —</option>
            @foreach($articles as $a)
            <option value="{{ $a->id }}" {{ (string)$articleId === (string)$a->id ? 'selected' : '' }}>
                {{ $a->title_id }}
            </option>
            @endforeach
        </select>
        </div>
        <div class="col-md-4">
        <button class="btn btn-primary">Terapkan</button>
        <a href="{{ route('admin.comments.index') }}" class="btn btn-light">Reset</a>
        </div>
    </form>

    {{-- Bulk actions --}}
    <form method="POST" action="{{ route('admin.comments.bulk') }}">
        @csrf
        @method('PATCH')

        <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                <tr>
                    <th style="width:34px">
                    <input type="checkbox" class="form-check-input" id="chk-all"
                            onclick="document.querySelectorAll('.chk-row').forEach(c=>c.checked=this.checked)">
                    </th>
                    <th>Isi</th>
                    <th>Penulis</th>
                    <th>Artikel</th>
                    <th>Status</th>
                    <th>Dikirim</th>
                    <th style="width:220px">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($comments as $c)
                    <tr>
                    <td>
                        <input type="checkbox" class="form-check-input chk-row" name="ids[]" value="{{ $c->id }}">
                    </td>
                    <td>
                        <div class="text-truncate" style="max-width: 380px;">
                        {{ Str::limit($c->body, 140) }}
                        </div>
                        <div class="small text-muted">
                        IP: {{ $c->ip ?? '-' }}
                        </div>
                    </td>
                    <td>
                        @if($c->user)
                        <div class="fw-semibold">{{ $c->user->name }}</div>
                        <div class="small text-muted">{{ $c->user->email }}</div>
                        @else
                        <div class="fw-semibold">{{ $c->guest_name ?? 'Tamu' }}</div>
                        <div class="small text-muted">{{ $c->guest_email ?? '-' }}</div>
                        @endif
                    </td>
                    <td>
                        @if($c->article)
                        <a href="{{ route('article', $c->article->slug) }}#comments" target="_blank">
                            {{ $c->article->title_id }}
                        </a>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @php
                        $map = ['pending'=>'warning','approved'=>'success','rejected'=>'secondary','spam'=>'danger'];
                        @endphp
                        <span class="badge bg-{{ $map[$c->status] ?? 'light' }}">{{ ucfirst($c->status) }}</span>
                    </td>
                    <td>
                        <div>{{ $c->created_at->format('d M Y H:i') }}</div>
                        <div class="small text-muted">{{ $c->created_at->diffForHumans() }}</div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                        {{-- Single update forms --}}
                        <form method="POST" action="{{ route('admin.comments.update', $c->id) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button class="btn btn-sm btn-success">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.comments.update', $c->id) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button class="btn btn-sm btn-outline-secondary">Reject</button>
                        </form>
                        <form method="POST" action="{{ route('admin.comments.update', $c->id) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="spam">
                            <button class="btn btn-sm btn-outline-danger">Spam</button>
                        </form>
                        <form method="POST" action="{{ route('admin.comments.destroy', $c->id) }}"
                                onsubmit="return confirm('Hapus komentar ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-light">Delete</button>
                        </form>
                        </div>
                    </td>
                    </tr>
                @empty
                    <tr>
                    <td colspan="7" class="text-center text-muted py-4">Tidak ada komentar.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            </div>
        </div>
        @if($comments->hasPages())
            <div class="card-footer">
            {{ $comments->links() }}
            </div>
        @endif
        </div>
    </form>
    </div>
</x-page.admin>
