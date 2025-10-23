<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ppdb extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id','nik','nisn','nama_lengkap','email','no_hp',
        'jenis_kelamin','agama','tempat_lahir','tanggal_lahir',
        'asal_sekolah','tahun_lulus',
        'provinsi','kabupaten','kecamatan','alamat',
        'nama_ayah','pekerjaan_ayah','nama_ibu','pekerjaan_ibu','penghasilan_wali',
        'program_pendidikan',
        'file_foto','file_akta','file_ijazah','file_kk',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'penghasilan_wali' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
