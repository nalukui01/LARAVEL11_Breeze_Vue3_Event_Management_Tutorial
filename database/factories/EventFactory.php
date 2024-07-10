<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" =>$this->faker->name,
            "from_datetime"=>$this->faker->dateTimeBetween("now","+1 month"),
            "to_datetime"=>$this->faker->dateTimeBetween('+1 month','++3 month'),
            "location"=>$this->faker->city, 
        ];
    }
}
