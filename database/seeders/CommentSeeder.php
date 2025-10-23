<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{Article, Comment, User};

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $articles = Article::published()->get();
        $userIds  = User::pluck('id')->all();

        foreach ($articles as $article) {
            $count = rand(2, 6);
            $created = 0;

            for ($i=0; $i<$count; $i++) {
                $comment = Comment::create([
                    'article_id' => $article->id,
                    'user_id'    => rand(0,1) ? ($userIds[array_rand($userIds)] ?? null) : null,
                    'guest_name' => rand(0,1) ? $faker->firstName() : null,
                    'guest_email'=> rand(0,1) ? $faker->safeEmail() : null,
                    'parent_id'  => null,
                    'body'       => $faker->sentence(rand(8,16)),
                    'status'     => rand(0,4) ? 'approved' : 'pending',
                    'ip'         => $faker->ipv4(),
                    'user_agent' => 'Seeder',
                ]);
                if ($comment->status === 'approved') $created++;

                // Balasan
                if (rand(0,1)) {
                    $reply = Comment::create([
                        'article_id' => $article->id,
                        'user_id'    => null,
                        'guest_name' => $faker->firstName(),
                        'guest_email'=> $faker->safeEmail(),
                        'parent_id'  => $comment->id,
                        'body'       => $faker->sentence(rand(6,12)),
                        'status'     => rand(0,4) ? 'approved' : 'pending',
                        'ip'         => $faker->ipv4(),
                        'user_agent' => 'Seeder',
                    ]);
                    if ($reply->status === 'approved') $created++;
                }
            }

            $article->update(['comment_count' => $created]);
        }
    }
}
