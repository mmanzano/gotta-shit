<?php

namespace Database\Factories\Entities;

use App\Entities\Place;
use App\Entities\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Place::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $initialLat = 40.5;
        $initialLng = -3.7;
        $deltaMin = -4000;
        $deltaMax = 3000;
        $latitude = $initialLat + $this->faker->numberBetween($deltaMin, $deltaMax) / 1000;
        $longitude = $initialLng + $this->faker->numberBetween($deltaMin, $deltaMax) / 1000;

        return [
            'name' => $this->faker->company,
            'geo_lat' => $latitude,
            'geo_lng' => $longitude,
            'user_id' => User::factory(),
        ];
    }
}

