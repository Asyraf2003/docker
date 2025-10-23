<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\HotInfo;

class HotInfoSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['PPDB 2026: Zonasi 35%', route('articles.index')],
            ['Tim Robotik Sekolah Juara 1 Nasional', route('articles.index')],
            ['Beasiswa Unggulan Dibuka s/d 31 Okt', route('articles.index')],
            ['Tips Lolos OSN: 7 Pola Wajib', route('articles.index')],
            ['Turnamen Futsal Antar Kelas Pekan Ini', route('articles.index')],
        ];

        foreach ($items as $i => [$title, $url]) {
            HotInfo::create([
                'title_id'   => $title,
                'title_en'   => $title.' (EN)',
                'title_ar'   => $title.' (AR)',
                'url'        => $url,
                'starts_at'  => Carbon::now()->subDays(1),
                'ends_at'    => Carbon::now()->addDays(10),
                'is_active'  => true,
                'sort_order' => $i,
            ]);
        }
    }
}
