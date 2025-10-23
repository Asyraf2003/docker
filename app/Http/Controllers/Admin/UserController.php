<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role','user')->orderByDesc('id')->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    public function destroy(User $user)
    {
        if (($user->role ?? 'user') !== 'user') {
            return back()->with('error','Tidak diizinkan menghapus role ini.');
        }
        $user->delete();
        return back()->with('success','Pengguna dihapus.');
    }
}
