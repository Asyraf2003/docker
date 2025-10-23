<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'title_id'=>'MPLS (Masa Pengenalan Lingkungan Sekolah)',
                'title_en'=>'MPLS (School Orientation Program)',
                'title_ar'=>'برنامج التوجيه المدرسي',
                'place_id'=>'Aula','place_en'=>'Hall','place_ar'=>'قاعة',
                'event_date'=>'2025-07-12 07:30:00','link_url'=>'#',
            ],
            [
                'title_id'=>'Class Meeting',
                'title_en'=>'Class Meeting',
                'title_ar'=>'لقاء الصف',
                'place_id'=>'Lapangan','place_en'=>'Field','place_ar'=>'الملعب',
                'event_date'=>'2025-12-10 08:00:00','link_url'=>'#',
            ],
            [
                'title_id'=>'Seminar Parenting',
                'title_en'=>'Parenting Seminar',
                'title_ar'=>'ندوة الوالدية',
                'place_id'=>'Auditorium','place_en'=>'Auditorium','place_ar'=>'المدرج',
                'event_date'=>'2025-11-03 09:00:00','link_url'=>'#',
            ],
            [
                'title_id'=>'Lomba Poster Lingkungan',
                'title_en'=>'Environmental Poster Competition',
                'title_ar'=>'مسابقة الملصقات البيئية',
                'place_id'=>'Ruang Seni','place_en'=>'Art Room','place_ar'=>'قاعة الفنون',
                'event_date'=>'2025-10-20 13:00:00','link_url'=>'#',
            ],
        ];

        foreach ($rows as $i => $r) {
            Event::create(array_merge($r, [
                'is_published' => true,
                'sort_order' => $i,
            ]));
        }
    }
}
