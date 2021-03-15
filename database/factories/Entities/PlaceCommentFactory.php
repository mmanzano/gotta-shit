<?php

namespace Database\Factories\Entities;

use App\Entities\Place;
use App\Entities\PlaceComment;
use App\Entities\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceCommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PlaceComment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'  => User::factory(),
            'place_id' => Place::factory(),
            'comment'  => $this->faker->realText(300),
        ];
    }
}
