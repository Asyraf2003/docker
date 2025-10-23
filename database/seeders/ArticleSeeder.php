<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\{Article, ArticleSection, Category, Tag, User};

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $userIds = User::pluck('id')->all();
        $catIds  = Category::pluck('id')->all();
        $tagIds  = Tag::pluck('id')->all();

        $total = 12;
        for ($i = 1; $i <= $total; $i++) {
            $titleId = $this->judulSekolah($i);
            $titleEn = 'Sample School Article '.$i;
            $titleAr = 'مقالة مدرسية رقم '.$i;

            $slugBase = Str::slug($titleId);
            $slug = $slugBase;
            $n = 2;
            while (Article::withTrashed()->where('slug', $slug)->exists()) {
                $slug = $slugBase.'-'.$n++;
            }

            $status = $i % 7 === 0 ? 'scheduled' : 'published';
            $isHot = $i % 5 === 0;
            $isFeatured = $i % 3 === 0;

            $publishedAt = $status === 'published'
                ? Carbon::now()->subDays(rand(0, 10))
                : null;

            $scheduledFor = $status === 'scheduled'
                ? Carbon::now()->addDays(rand(1, 7))
                : null;

            $article = Article::create([
                'author_id'    => $faker->randomElement($userIds),
                'title_id'     => $titleId,
                'title_en'     => $titleEn,
                'title_ar'     => $titleAr,
                'slug'         => $slug,
                'hero_image'   => 'article/gambar'.(($i-1)%6+1).'.jpg',
                'excerpt_id'   => 'Ringkasan singkat: '.$faker->sentence(10),
                'excerpt_en'   => $faker->sentence(10),
                'excerpt_ar'   => 'ملخص قصير: '.$faker->sentence(10),

                'meta_title_id'=> $titleId,
                'meta_title_en'=> $titleEn,
                'meta_title_ar'=> $titleAr,
                'meta_desc_id' => $faker->sentence(18),
                'meta_desc_en' => $faker->sentence(18),
                'meta_desc_ar' => $faker->sentence(18),

                'is_published' => $status === 'published',
                'status'       => $status,
                'published_at' => $publishedAt,
                'scheduled_for'=> $scheduledFor,

                'is_featured'  => $isFeatured,
                'is_hot'       => $isHot,
                'hot_until'    => $isHot ? Carbon::now()->addDays(5) : null,
                'pinned_until' => null,

                'view_count'   => rand(50, 5000),
                'comment_count'=> 0,
                'share_count'  => rand(0, 200),
                'reading_time' => 0,
            ]);

            // Sections
            $secCount = rand(3, 5);
            for ($s = 0; $s < $secCount; $s++) {
                $type = ['paragraph','paragraph','paragraph','quote','image_only'][array_rand([0,1,2,3,4])];

                ArticleSection::create([
                    'article_id'   => $article->id,
                    'type'         => $type,
                    'body_id'      => $type !== 'image_only' ? $faker->paragraphs(rand(2,3), true) : null,
                    'body_en'      => $type !== 'image_only' ? $faker->paragraphs(rand(2,3), true) : null,
                    'body_ar'      => $type !== 'image_only' ? $faker->paragraphs(rand(2,3), true) : null,
                    'image_path'   => $type === 'image_only' ? 'article/sections/sec'.rand(1,6).'.jpg' : null,
                    'image_alt_id' => $type === 'image_only' ? 'Kegiatan sekolah' : null,
                    'image_alt_en' => $type === 'image_only' ? 'School activity' : null,
                    'image_alt_ar' => $type === 'image_only' ? 'فعالية مدرسية' : null,
                    'sort_order'   => $s,
                ]);
            }

            // Kategori (1-2)
            $attachCats = collect($catIds)->shuffle()->take(rand(1,2))->values()->all();
            $article->categories()->sync($attachCats);

            // Tag (2-4)
            $attachTags = collect($tagIds)->shuffle()->take(rand(2,4))->values()->all();
            $article->tags()->sync($attachTags);

            // Hitung reading_time dari isi
            $article->reading_time = $this->computeReadingMinutes($article->id);
            $article->save();
        }

        // Update use_count tag berdasar pivot
        $this->refreshTagUseCount();
    }

    private function judulSekolah(int $i): string
    {
        $judul = [
            'Kegiatan Ekstrakurikuler Paskibra',
            'Tips Lolos OSN Matematika',
            'PPDB Tahun Ajaran Baru',
            'Kompetisi Robotik Nasional',
            'Beasiswa Unggulan Semester Ini',
            'Gerakan Literasi Sekolah',
            'Pelatihan Coding untuk Siswa',
            'Turnamen Futsal Antar Kelas',
            'Pameran Seni Rupa',
            'Prakarya Sains Sederhana',
            'Workshop Kesehatan Remaja',
            'Kunjungan Industri Teknologi'
        ];
        return $judul[($i-1) % count($judul)];
    }

    private function computeReadingMinutes(int $articleId): int
    {
        $sections = ArticleSection::where('article_id', $articleId)->get();
        $text = '';
        foreach ($sections as $sec) {
            $text .= ' '.strip_tags($sec->body_id ?? '');
            $text .= ' '.strip_tags($sec->body_en ?? '');
            $text .= ' '.strip_tags($sec->body_ar ?? '');
        }
        $words = str_word_count($text);
        $wpm = 220;
        return max(1, (int)ceil($words / $wpm));
    }

    private function refreshTagUseCount(): void
    {
        $rows = DB::table('article_tag')
            ->select('tag_id', DB::raw('COUNT(*) as c'))
            ->groupBy('tag_id')
            ->pluck('c', 'tag_id');

        foreach ($rows as $tagId => $count) {
            DB::table('tags')->where('id', $tagId)->update(['use_count' => $count]);
        }
    }
}
