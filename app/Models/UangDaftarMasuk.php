<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;

class UangDaftarMasuk extends Model
{
    use SoftDeletes;

    protected $table = 'uang_daftar_masuk';

    protected $fillable = [
        'user_id','ppdb_id','amount','metode','tujuan',
        'bukti_path','status','paid_at','verified_by','catatan'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function user()    { return $this->belongsTo(User::class); }
    public function ppdb()    { return $this->belongsTo(Ppdb::class); }
    public function verifier(){ return $this->belongsTo(User::class, 'verified_by'); }

    public function getBuktiUrlAttribute(): ?string
    {
        $path = $this->bukti_path;
        if (!$path) return null;
        $path = ltrim($path, '/');

        if (Str::startsWith($path, ['http://','https://'])) {
            return $path;
        }
        if (Str::startsWith($path, 'storage/')) {
            $path = Str::after($path, 'storage/');
        }

        $disk = Storage::disk('public');

        return asset('storage/'.$path);

    }
}
