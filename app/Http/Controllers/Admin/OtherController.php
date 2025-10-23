<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class OtherController extends Controller
{
    public function index()
    {
        $others = User::where('role','other')->orderByDesc('id')->paginate(10);
        return view('admin.other.index', compact('others'));
    }

    public function destroy(User $user)
    {
        if (($user->role ?? 'other') !== 'other') {
            return back()->with('error','Tidak diizinkan menghapus role ini.');
        }
        $user->delete();
        return back()->with('success','Akun dihapus.');
    }
}
