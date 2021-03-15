<?php

namespace Database\Factories\Entities;

use App\Entities\Place;
use App\Entities\PlaceStar;
use App\Entities\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceStarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PlaceStar::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'place_id' => Place::factory(),
            'stars' => $this->faker->numberBetween(1, 5),
        ];
    }
}
