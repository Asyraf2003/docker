<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title_id' => fake('id_ID')->sentence(3),
            'title_en' => fake()->sentence(3),
            'title_ar' => 'إعلان قصير',
            'desc_id'  => fake('id_ID')->paragraph(),
            'desc_en'  => fake()->paragraph(),
            'desc_ar'  => 'نص وصفي مختصر',
            'event_date' => now()->toDateString(),
            'link_url'   => '#',
            'is_published' => true,
            'published_at' => now(),
            'sort_order' => 0,
        ];
    }
}
