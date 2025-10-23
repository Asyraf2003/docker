<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GalleryImageSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $rows = [
            [
                'title_id' => 'Upacara Bendera',
                'title_en' => 'Flag Ceremony',
                'title_ar' => 'مراسم رفع العلم',
                'description_id' => 'Kegiatan rutin setiap Senin untuk menanamkan disiplin dan cinta tanah air.',
                'description_en' => 'Weekly Monday ceremony to foster discipline and patriotism.',
                'description_ar' => 'فعالية أسبوعية صباح يوم الإثنين لتعزيز الانضباط وحب الوطن.',
                'image_path' => 'gallery/gambar1.jpg',
                'link_url' => 'http://127.0.0.1:8000/',
                'is_published' => true,
                'sort_order' => 1,
                'published_at' => $now->copy()->subDays(5),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_id' => 'Kegiatan Pramuka',
                'title_en' => 'Scout Activities',
                'title_ar' => 'نشاط الكشافة',
                'description_id' => 'Latihan kepemimpinan, kemandirian, dan kerja sama dalam regu.',
                'description_en' => 'Leadership, self-reliance, and teamwork training in patrols.',
                'description_ar' => 'تدريب على القيادة والاعتماد على النفس والعمل الجماعي ضمن السرايا.',
                'image_path' => 'gallery/gambar2.jpg',
                'link_url' => 'http://127.0.0.1:8000/',
                'is_published' => true,
                'sort_order' => 2,
                'published_at' => $now->copy()->subDays(4),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_id' => 'Wisuda Siswa',
                'title_en' => 'Graduation Day',
                'title_ar' => 'حفل التخرج',
                'description_id' => 'Perayaan kelulusan siswa dan apresiasi kepada orang tua.',
                'description_en' => 'A celebration of students’ graduation and parents’ support.',
                'description_ar' => 'احتفال بتخرج الطلاب وتقدير دعم أولياء الأمور.',
                'image_path' => 'gallery/gambar3.jpg',
                'link_url' => 'http://127.0.0.1:8000/',
                'is_published' => true,
                'sort_order' => 3,
                'published_at' => $now->copy()->subDays(3),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_id' => 'Lomba Sains',
                'title_en' => 'Science Fair',
                'title_ar' => 'معرض العلوم',
                'description_id' => 'Ajang kreativitas sains dan inovasi karya siswa.',
                'description_en' => 'A stage for creativity in science and student innovations.',
                'description_ar' => 'منصة لإبداع العلوم وابتكارات الطلاب.',
                'image_path' => 'gallery/gambar4.jpg',
                'link_url' => 'http://127.0.0.1:8000/',
                'is_published' => true,
                'sort_order' => 4,
                'published_at' => $now->copy()->subDays(2),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_id' => 'Kelas Komputer',
                'title_en' => 'Computer Class',
                'title_ar' => 'حصة الحاسوب',
                'description_id' => 'Pembelajaran TIK dasar hingga pemrograman untuk siswa.',
                'description_en' => 'ICT lessons from basics to programming for students.',
                'description_ar' => 'دروس تكنولوجيا المعلومات من الأساسيات حتى البرمجة للطلاب.',
                'image_path' => 'gallery/gambar5.jpg',
                'link_url' => 'http://127.0.0.1:8000/',
                'is_published' => true,
                'sort_order' => 5,
                'published_at' => $now->copy()->subDay(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_id' => 'Kegiatan Olahraga',
                'title_en' => 'Sports Day',
                'title_ar' => 'يوم الرياضة',
                'description_id' => 'Menjaga kebugaran dan sportivitas melalui berbagai cabang olahraga.',
                'description_en' => 'Keeping fit and building sportsmanship through various sports.',
                'description_ar' => 'الحفاظ على اللياقة وبناء الروح الرياضية عبر أنشطة متنوعة.',
                'image_path' => 'gallery/gambar6.jpg',
                'link_url' => 'http://127.0.0.1:8000/',
                'is_published' => true,
                'sort_order' => 6,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('gallery_images')->insert($rows);
    }
}
