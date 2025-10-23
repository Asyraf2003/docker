<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\PaymentPpdbController;
use App\Http\Controllers\User\TransaksiController as UserTransaksiController;

Route::middleware(['auth', 'role:user', 'verified'])
    ->prefix('user')
    ->as('user.')
    ->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    Route::post('/ppdb/payment', [PaymentPpdbController::class, 'store'])->name('ppdb.store');
    
    Route::get('/transaksi', [UserTransaksiController::class, 'index'])->name('transaksi.index');
});


