<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'title_id' => 'Kelas Tahfidz',
                'title_en' => 'Tahfidz Class',
                'title_ar' => 'صف التحفيظ',
                'desc_id'  => 'Pendampingan hafalan dan tahsin terstruktur.',
                'desc_en'  => 'Structured memorization and recitation guidance.',
                'desc_ar'  => 'مرافقة الحفظ والتجويد بشكل منظم.',
            ],
            [
                'title_id' => 'Riset Sains',
                'title_en' => 'Science Research',
                'title_ar' => 'البحث العلمي',
                'desc_id'  => 'Pembinaan olimpiade & project lab sains.',
                'desc_en'  => 'Olympiad coaching & science lab projects.',
                'desc_ar'  => 'تدريب الأولمبياد ومشاريع المختبرات العلمية.',
            ],
            [
                'title_id' => 'Literasi Digital',
                'title_en' => 'Digital Literacy',
                'title_ar' => 'الثقافة الرقمية',
                'desc_id'  => 'Kelas coding, UI/UX, dan keamanan siber dasar.',
                'desc_en'  => 'Coding, UI/UX, and basic cybersecurity classes.',
                'desc_ar'  => 'دروس البرمجة وواجهة المستخدم والأمن السيبراني الأساسي.',
            ],
            [
                'title_id' => 'Kewirausahaan',
                'title_en' => 'Entrepreneurship',
                'title_ar' => 'ريادة الأعمال',
                'desc_id'  => 'Market day, project business, dan branding.',
                'desc_en'  => 'Market day, business projects, and branding.',
                'desc_ar'  => 'يوم السوق، مشاريع الأعمال، وبناء العلامة التجارية.',
            ],
        ];

        foreach ($rows as $i => $r) {
            Program::create(array_merge($r, [
                'sort_order' => $i,
                'is_published' => true,
            ]));
        }
    }
}
