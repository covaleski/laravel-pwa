<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (Post $post) {
            $post->slug = (string) str($post->title)->slug();
            $post->updated_at = $post->created_at;
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => (string) str(fake()->sentence())->trim('.')->title(),
            'content' => implode("\n\n", fake()->paragraphs()),
            'created_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
