<?php

namespace Database\Factories\Blog;

use App\Models\Blog\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 
            'title' => $this->faker->word,
            'content' => $this->faker->text,
            'excerpt' => $this->faker->sentence,
        ];
    }
}
