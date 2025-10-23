<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Article, ArticleLike, User};

class ArticleLikeSeeder extends Seeder
{
    public function run(): void
    {
        $articles = Article::published()->get();
        $users    = User::pluck('id')->all();

        foreach ($articles as $a) {
            $likers = collect($users)->shuffle()->take(rand(1, min(8, count($users))));
            foreach ($likers as $uid) {
                ArticleLike::firstOrCreate([
                    'article_id' => $a->id,
                    'user_id'    => $uid,
                ]);
            }
        }
    }
}
