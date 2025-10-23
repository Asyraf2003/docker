<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'ppdb', 'osn', 'robotik', 'pramuka', 'coding',
            'literasi', 'beasiswa', 'turnamen', 'kesehatan', 'karya-siswa'
        ];

        foreach ($tags as $t) {
            Tag::firstOrCreate(
                ['slug' => Str::slug($t)],
                ['name' => ucwords(str_replace('-', ' ', $t)), 'use_count' => 0]
            );
        }
    }
}
