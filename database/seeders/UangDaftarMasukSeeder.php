<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UangDaftarMasuk;

class UangDaftarMasukSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        // Daftar opsi data untuk diacak
        $metodePembayaran = ['Transfer BRI', 'Tunai', 'Virtual Account BNI', 'OVO/Gopay'];
        $statusPembayaran = ['verified', 'pending', 'rejected'];
        
        // Loop untuk membuat data dari user_id 7 hingga 20
        for ($i = 7; $i <= 21; $i++) {
            // Cek apakah data untuk user_id ini sudah ada
            if (! UangDaftarMasuk::where('user_id', $i)->exists()) {
                
                // 1. Acak Data
                $amount = (int) config('ppdb.fee', 50000) + (random_int(0, 3) * 10000); // Jumlah sedikit diacak
                $metode  = $metodePembayaran[array_rand($metodePembayaran)];
                $status  = $statusPembayaran[array_rand($statusPembayaran)];
                
                // Tentukan tujuan berdasarkan metode
                $tujuan = match ($metode) {
                    'Transfer BRI' => 'BRI 1234-567-890 a.n. Sekolah ABC',
                    'Tunai' => 'Kantor Administrasi Sekolah',
                    'Virtual Account BNI' => 'BNI VA-' . random_int(100000, 999999),
                    default => '08' . random_int(100000000, 999999999), // Untuk OVO/Gopay
                };

                $image_number = (($i - 7) % 6) + 1;
                $bukti_path = 'gallery/gambar' . $image_number . '.jpg';

                $ppdb_id = random_int(1, 15);

                // Buat entri baru
                UangDaftarMasuk::create([
                    'user_id' => $i,
                    'ppdb_id' => $ppdb_id,
                    'amount'  => $amount,
                    'metode'  => $metode,
                    'tujuan'  => $tujuan,
                    'bukti_path' => $bukti_path,
                    'status'  => $status,
                    'paid_at' => ($status === 'paid' ? now() : null), 
                ]);
            }
        }
    }
}
