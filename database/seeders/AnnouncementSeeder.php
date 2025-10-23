<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use Carbon\Carbon;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'title_id' => 'Libur Maulid Nabi',
                'title_en' => 'Holiday: Prophet’s Birthday',
                'title_ar' => 'عطلة المولد النبوي',
                'desc_id'  => 'Kegiatan belajar mengajar diliburkan selama 1 hari.',
                'desc_en'  => 'Teaching and learning activities are off for one day.',
                'desc_ar'  => 'تعطّل الدراسة ليوم واحد.',
                'event_date' => '2025-09-15',
                'link_url'   => '#',
                'sort_order' => 0,
            ],
            [
                'title_id' => 'PPDB Gelombang 2 Dibuka',
                'title_en' => 'Student Admission Wave 2 Open',
                'title_ar' => 'فتح التسجيل المرحلة الثانية',
                'desc_id'  => 'Pendaftaran peserta didik baru gelombang 2 resmi dibuka.',
                'desc_en'  => 'New student admission (wave 2) is officially open.',
                'desc_ar'  => 'تم فتح التسجيل للطلاب الجدد (المرحلة الثانية).',
                'event_date' => '2025-10-01',
                'link_url'   => '#',
                'sort_order' => 0,
            ],
            [
                'title_id' => 'Tryout AKM Kelas 8',
                'title_en' => 'AKM Tryout for Grade 8',
                'title_ar' => 'اختبار تجريبي AKM للصف الثامن',
                'desc_id'  => 'Tryout Asesmen Kompetensi Minimum untuk kelas 8.',
                'desc_en'  => 'Minimum Competency Assessment tryout for grade 8.',
                'desc_ar'  => 'اختبار تجريبي لتقييم الكفاءة الدنيا للصف الثامن.',
                'event_date' => '2025-09-25',
                'link_url'   => '#',
                'sort_order' => 0,
            ],
        ];

        foreach ($rows as $r) {
            Announcement::create(array_merge($r, [
                'is_published' => true,
                'published_at' => Carbon::now(),
            ]));
        }
    }
}
