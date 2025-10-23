<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Extracurricular;

class ExtracurricularSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['id'=>'Pramuka', 'en'=>'Scouting', 'ar'=>'الكشافة'],
            ['id'=>'Paskibra', 'en'=>'Flag Hoisting Troop', 'ar'=>'فريق رفع العلم'],
            ['id'=>'Futsal', 'en'=>'Futsal', 'ar'=>'كرة الصالات'],
            ['id'=>'Basket', 'en'=>'Basketball', 'ar'=>'كرة السلة'],
            ['id'=>'Karate', 'en'=>'Karate', 'ar'=>'الكاراتيه'],
            ['id'=>'PMR', 'en'=>'Youth Red Cross', 'ar'=>'الهلال الأحمر الشبابي'],
            ['id'=>'KIR Sains', 'en'=>'Science Club', 'ar'=>'نادي العلوم'],
            ['id'=>'Paduan Suara', 'en'=>'Choir', 'ar'=>'جوقة'],
            ['id'=>'Robotics', 'en'=>'Robotics', 'ar'=>'الروبوتات'],
            ['id'=>'Desain Grafis', 'en'=>'Graphic Design', 'ar'=>'تصميم الجرافيك'],
        ];

        foreach ($rows as $i => $r) {
            Extracurricular::create([
                'name_id' => $r['id'],
                'name_en' => $r['en'],
                'name_ar' => $r['ar'],
                'is_published' => true,
                'sort_order' => $i,
            ]);
        }
    }
}
