<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();
        return [
            'title' => $title,
            'slug' => str($title)->slug(),
            'content' => $this->faker->paragraph(8),
            'category_id' => Category::factory(),
            'user_id' => User::all()->random()->id,
            'status' => $this->faker->randomElement(['published', 'draft']),
            'views' => rand(100, 85900),
        ];

        for ($i = 0; $i < 25; $i++) {
            DB::table('post_tag')->insert([
                'post_id' => rand(1, 4999),
                'tag_id' => rand(1, 30)
            ]);
        }
    }
}
