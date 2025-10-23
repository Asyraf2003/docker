<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ppdb;
use App\Models\User;

class PpdbSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')
            ->whereBetween('id', [7, 21])
            ->get();

        foreach ($users as $u) {
            // Cek untuk menghindari duplikasi
            if (!Ppdb::where('user_id', $u->id)->exists()) {
                Ppdb::create([
                    'user_id'        => $u->id,
                    'nik'            => fake()->unique()->numerify('3204###########'),
                    'nisn'           => fake()->unique()->numerify('00######'),
                    'nama_lengkap'   => $u->name,
                    'email'          => $u->email,
                    'no_hp'          => fake()->phoneNumber(),

                    'jenis_kelamin'  => fake()->randomElement(['L', 'P']),
                    'agama'          => fake()->randomElement(['Islam','Kristen','Hindu','Budha','Katolik']),

                    'tempat_lahir'   => fake()->city(),
                    'tanggal_lahir'  => fake()->date(),

                    'asal_sekolah'   => fake()->company().' School',
                    'tahun_lulus'    => (string)fake()->year(),

                    'provinsi'       => fake()->state(),
                    'kabupaten'      => fake()->city(),
                    'kecamatan'      => fake()->streetName(),
                    'alamat'         => fake()->address(),

                    'nama_ayah'      => fake()->name('male'),
                    'pekerjaan_ayah' => fake()->jobTitle(),
                    'nama_ibu'       => fake()->name('female'),
                    'pekerjaan_ibu'  => fake()->jobTitle(),
                    'penghasilan_wali' => fake()->numberBetween(1000000, 10000000),

                    'program_pendidikan' => fake()->randomElement(['IPA','IPS','TKJ','Multimedia','Bahasa']),

                    'file_foto'      => 'gallery/gambar1.jpg',
                    'file_akta'      => 'gallery/gambar2.jpg',
                    'file_ijazah'    => 'gallery/gambar3.jpg',
                    'file_kk'        => 'gallery/gambar4.jpg',

                    'status'         => 'baru',
                ]);
            }
        }
    }
}
