<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UangDaftarMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->string('status')->toString();

        $payments = UangDaftarMasuk::query()
            ->where('user_id', Auth::id())
            ->when($status, fn($qr) => $qr->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(10);

        // accessor di model menyediakan $payment->bukti_url
        return view('user.transaksi.index', compact('payments','status'));
    }
}
