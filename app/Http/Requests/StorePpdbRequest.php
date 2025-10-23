<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePpdbRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // publik (bisa ditambah rate limit di routes)
    }

    public function rules(): array
    {
        return [
            'nik'   => ['required','digits_between:8,20','regex:/^[0-9]+$/','unique:ppdbs,nik'],
            'nisn'  => ['nullable','digits_between:8,15','regex:/^[0-9]+$/','unique:ppdbs,nisn'],
            'nama_lengkap' => ['required','string','max:150'],
            'email' => ['nullable','email','max:150'],
            'no_hp' => ['nullable','string','max:30'],

            'jenis_kelamin' => ['required','in:L,P'],
            'agama' => ['nullable','string','max:50'],

            'tempat_lahir' => ['nullable','string','max:100'],
            'tanggal_lahir' => ['nullable','date','before:today'],

            'asal_sekolah' => ['nullable','string','max:150'],
            'tahun_lulus'  => ['nullable','digits:4'],

            'provinsi'  => ['nullable','string','max:100'],
            'kabupaten' => ['nullable','string','max:100'],
            'kecamatan' => ['nullable','string','max:100'],
            'alamat'    => ['nullable','string','max:1000'],

            'nama_ayah' => ['nullable','string','max:150'],
            'pekerjaan_ayah' => ['nullable','string','max:100'],
            'nama_ibu'  => ['nullable','string','max:150'],
            'pekerjaan_ibu' => ['nullable','string','max:100'],
            'penghasilan_wali' => ['nullable','integer','min:0'],

            'program_pendidikan' => ['required','string','max:100'],

            // file uploads: aman & ringan
            'file_foto'   => ['nullable','file','mimes:jpg,jpeg,png','max:2048'],
            'file_akta'   => ['nullable','file','mimes:jpg,jpeg,png,pdf','max:4096'],
            'file_ijazah' => ['nullable','file','mimes:jpg,jpeg,png,pdf','max:4096'],
            'file_kk'     => ['nullable','file','mimes:jpg,jpeg,png,pdf','max:4096'],

            // honeypot (harus kosong)
            'hp_check' => ['nullable','size:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'nik.regex' => 'NIK hanya boleh angka.',
            'nisn.regex' => 'NISN hanya boleh angka.',
            'hp_check.size' => 'Terjadi kesalahan pengisian formulir.',
        ];
    }
}
