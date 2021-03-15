<?php

namespace Database\Factories\Entities;

use App\Entities\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'full_name' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'username' => $this->faker->userName,
            'email' => $this->faker->unique()->email,
            'password' => bcrypt('123456'),
            'verified' => true,
            'remember_token' => Str::random(10),
            'language' => 'en',
        ];
    }

    /**
     * admin user state
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'full_name' => 'Miguel Manzano',
                'username' => 'mmanzano',
                'email' => 'mmanzano@gmail.com',
                'password' => bcrypt('secret'),
                'verified' => true,
                'remember_token' => Str::random(10),
                'language' => 'en',
            ];
        });
    }
}
