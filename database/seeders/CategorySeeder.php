<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $roots = [
            'Pengumuman',
            'Beasiswa',
            'Prestasi',
            'Kegiatan',
            'PPDB',
            'Teknologi',
            'Olahraga',
            'Seni',
            'Sains',
        ];

        $map = [];
        foreach ($roots as $i => $name) {
            $map[$name] = Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name_id' => $name,
                    'name_en' => $name.' (EN)',
                    'name_ar' => $name.' (AR)',
                    'sort_order' => $i,
                    'is_active' => true,
                ]
            );
        }

        // Sub kategori di bawah "Kegiatan"
        $subs = ['Ekstrakurikuler', 'Workshop', 'Seminar', 'Lomba'];
        foreach ($subs as $j => $name) {
            Category::firstOrCreate(
                ['slug' => Str::slug('kegiatan-'.$name)],
                [
                    'name_id' => $name,
                    'name_en' => $name.' (EN)',
                    'name_ar' => $name.' (AR)',
                    'parent_id' => $map['Kegiatan']->id,
                    'sort_order' => $j,
                    'is_active' => true,
                ]
            );
        }
    }
}
