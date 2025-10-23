<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UangDaftarMasuk;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:user']);
    }

    public function index()
    {
        $latestPayment = UangDaftarMasuk::where('user_id', Auth::id())->latest()->first();

        [$icon, $color, $title] = match (optional($latestPayment)->status) {
            'verified' => ['bi-patch-check-fill', 'text-primary', 'Akun terverifikasi'],
            'pending'  => ['bi-patch-check',      'text-success', 'Menunggu verifikasi admin'],
            'rejected' => ['bi-x-circle-fill',    'text-danger',  'Bukti ditolak, unggah ulang'],
            default    => ['bi-dash-circle',      'text-secondary','Belum ada pembayaran'],
        };

        $showPayCard = ! $latestPayment || $latestPayment->status === 'rejected';

        return view('user.dashboard', compact('icon','color','title', 'showPayCard', 'latestPayment'));
    }
}
