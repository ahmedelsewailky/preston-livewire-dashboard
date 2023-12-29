<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = collect([]);

        for ($i = 0; $i < 5000; $i++) {
            $title = fake()->unique()->sentence;
            $collections->push([
                'title' => $title,
                'slug' => str($title)->slug,
                'content' => fake()->paragraph(8),
                'category_id' => rand(1,8),
                'user_id' => 1,
                'status' => fake()->randomElement(['published', 'draft']),
                'views' => rand(100, 85950),
            ]);
        }

        foreach ($collections->chunk(500)->toArray() as $chunk) {
            \App\Models\Post::insert($chunk);
        }

        for ($i = 0; $i < 5000; $i++) {
            DB::table('post_tag')->insert([
                'post_id' => rand(1, 4999),
                'tag_id' => rand(1, 30)
            ]);
        }
    }
}
