<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            GalleryImageSeeder::class,
            ArticleSeeder::class,
            TagSeeder::class,
            CategorySeeder::class,
            CommentSeeder::class,
            ArticleLikeSeeder::class,
            HotInfoSeeder::class,
            AnnouncementSeeder::class,
            ProgramSeeder::class,
            ExtracurricularSeeder::class,
            EventSeeder::class,
            PpdbSeeder::class,
            UangDaftarMasukSeeder::class,
        ]);
    }
}
