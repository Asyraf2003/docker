<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ppdb;
use App\Models\UangDaftarMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PaymentPpdbController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        $fee = (int) config('ppdb.fee', 50_000);

        $data = $request->validate([
            'ppdb_id' => ['nullable', Rule::exists('ppdbs','id')],
            'amount'  => ['required','integer','min:1000'], 
            'metode'  => ['nullable','string','max:100'],
            'tujuan'  => ['nullable','string','max:191'],
            'bukti'   => ['nullable','file','mimes:jpg,jpeg,png,webp','max:4096'],
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('ppdb/payments','public');
        }

        $ppdbId = null;
        if (!empty($data['ppdb_id'])) {
            $own = Ppdb::where('id', $data['ppdb_id'])->where('user_id', $user->id)->exists();
            if ($own) { $ppdbId = $data['ppdb_id']; }
        }

        $payment = UangDaftarMasuk::create([
            'user_id'   => $user->id,
            'ppdb_id'   => $ppdbId,
            'amount'    => $data['amount'],
            'metode'    => $data['metode'] ?? null,
            'tujuan'    => $data['tujuan'] ?? null,
            'bukti_path'=> $buktiPath,
            'status'    => 'pending',
            'paid_at'   => now(),
        ]);

        return back()->with('success', 'Bukti pembayaran terkirim. Menunggu verifikasi admin.');
    }
}
