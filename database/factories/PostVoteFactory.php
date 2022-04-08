<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostVoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\PostVote::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $votes = [-1, 1];
        return [
            'user_id' => rand(1, 100),
            'post_id' => rand(1, 100),
            'vote' => $votes[rand(0, 1)],
        ];
    }
}
