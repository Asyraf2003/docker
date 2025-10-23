<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UangDaftarMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $q      = $request->string('q')->toString();
        $status = $request->string('status')->toString();
        $metode = $request->string('metode')->toString();

        $payments = UangDaftarMasuk::query()
            ->with(['user:id,name,email', 'ppdb:id,user_id'])
            ->when($q, function ($qr) use ($q) {
                $qr->where(function ($s) use ($q) {
                    $s->whereHas('user', function ($u) use ($q) {
                        $u->where('name','like',"%{$q}%")
                        ->orWhere('email','like',"%{$q}%");
                    })->orWhere('tujuan','like',"%{$q}%");
                });
            })
            ->when($status, fn($qr) => $qr->where('status', $status))
            ->when($metode, fn($qr) => $qr->where('metode','like',"%{$metode}%"))
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('admin.transaksi.index', compact('payments','q','status','metode'));
    }

    public function updateStatus(Request $request, UangDaftarMasuk $payment)
    {
        $data = $request->validate([
            'status'  => ['required', Rule::in(['pending','verified','rejected'])],
            'catatan' => ['nullable','string','max:2000'],
        ]);

        $attrs = [
            'status'  => $data['status'],
            'catatan' => $data['catatan'] ?? null,
        ];

        // isi/bersihkan verified_by sesuai status
        if ($data['status'] === 'verified') {
            $attrs['verified_by'] = Auth::id();
        } else {
            $attrs['verified_by'] = null;
        }

        $payment->update($attrs);

        return back()->with('success','Status transaksi diperbarui.');
    }
}
