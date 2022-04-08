<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Post::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'community_id' => rand(1, 100),
            'user_id' => rand(1, 100),
            'title' => $this->faker->text(50),
            'post_text' => $this->faker->text(500),
        ];
    }
}
