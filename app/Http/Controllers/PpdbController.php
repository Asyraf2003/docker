<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePpdbRequest;
use App\Models\Ppdb;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PpdbController extends Controller
{
    public function create()
    {
        if (Auth::check() && Auth::user()->ppdb) {
            return redirect()->route('user.dashboard'); 
        }
 
        $jenisKelamin = ['L' => 'Laki-laki', 'P' => 'Perempuan'];
        $agama = ['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu','Lainnya'];
        $program = ['SD','SMP','SMA','SMK TKJ','SMK RPL','Paket A','Paket B','Paket C'];

        return view('ppdb', compact('jenisKelamin','agama','program'));
    }

    public function store(StorePpdbRequest $request)
    {
        $user = Auth::user();
        if ($user->ppdb) {
            return redirect()->route('user.dashboard')
                ->with('success', 'Anda sudah mengirim pendaftaran. Silakan pantau statusnya.');
        }
        $data = $request->validated();
        $data['user_id'] = $user->id;

        foreach (['file_foto','file_akta','file_ijazah','file_kk'] as $key) {
            if ($request->hasFile($key)) {
                $data[$key] = $request->file($key)->storeAs(
                    'ppdb',
                    now()->format('YmdHis').'_'.$key.'_'.Str::random(8).'.'.$request->file($key)->getClientOriginalExtension(),
                    'public'
                );
            }
        }

        Ppdb::create($data);

        return redirect()
            ->route('ppdb.create')
            ->with('success', 'Pendaftaran berhasil dikirim. Panitia akan memverifikasi data Anda.');
    }
}
