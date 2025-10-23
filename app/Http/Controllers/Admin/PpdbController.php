<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ppdb;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Filesystem\FilesystemAdapter;

class PpdbController extends Controller
{
    public function index()
    {
        $q       = request('q');
        $status  = request('status');
        $program = request('program');

        $ppdbs = Ppdb::query()
            ->select([
                'id','nama_lengkap','nik','nisn','email','no_hp',
                'program_pendidikan','status','created_at'
            ])
            ->when($q, function ($qr) use ($q) {
                $qr->where(function ($s) use ($q) {
                    $s->where('nama_lengkap','like',"%{$q}%")
                      ->orWhere('nik','like',"%{$q}%")
                      ->orWhere('nisn','like',"%{$q}%")
                      ->orWhere('email','like',"%{$q}%");
                });
            })
            ->when($status, fn($qr) => $qr->where('status', $status))
            ->when($program, fn($qr) => $qr->where('program_pendidikan','like',"%{$program}%"))
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('admin.ppdb.index', compact('ppdbs'));
    }

    public function show(Ppdb $ppdb)
    {
        $raw = [
            'Foto'   => $ppdb->file_foto,
            'Akta'   => $ppdb->file_akta,
            'Ijazah' => $ppdb->file_ijazah,
            'KK'     => $ppdb->file_kk,
        ];

        $disk = Storage::disk('public');

        $toPublicUrl = function (?string $path) use ($disk): ?string {
            if (!$path) return null;

            if (Str::startsWith($path, ['http://','https://'])) {
                return $path;
            }

            $normalized = ltrim($path, '/');
            if (Str::startsWith($normalized, 'storage/')) {
                $normalized = Str::after($normalized, 'storage/');
            }

            $publicUrl = Storage::url($normalized);


            return URL::to($publicUrl);
        };

        $files = [];
        foreach ($raw as $label => $path) {
            $files[$label] = $toPublicUrl($path);
        }

        return view('admin.ppdb.show', compact('ppdb','files'));
    }

    public function updateStatus(Ppdb $ppdb)
    {
        $data = request()->validate([
            'status' => ['required', Rule::in(['baru','diterima','ditolak'])],
        ]);

        $ppdb->update(['status' => $data['status']]);

        return back()->with('success', 'Status PPDB diperbarui.');
    }
}
