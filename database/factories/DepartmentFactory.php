<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Engineering', 'Human Resources', 'Marketing', 'Finance',
                'Operations', 'Sales', 'Legal', 'Customer Support',
            ]),
            'description' => fake()->sentence(),
        ];
    }
}
