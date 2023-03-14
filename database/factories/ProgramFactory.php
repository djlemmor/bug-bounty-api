<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'pentesting_start_date' => $this->faker->date(),
            'pentesting_end_date' => $this->faker->date(),
        ];
    }
}
