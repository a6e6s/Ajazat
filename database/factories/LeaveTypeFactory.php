<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Annual Leave', 'Sick Leave', 'Unpaid Leave',
                'Maternity Leave', 'Paternity Leave', 'Emergency Leave',
            ]),
            'color' => fake()->hexColor(),
            'max_days_per_year' => fake()->randomElement([5, 10, 14, 21, 30]),
            'requires_attachment' => false,
            'is_active' => true,
        ];
    }

    /**
     * Mark the leave type as requiring an attachment.
     */
    public function requiresAttachment(): static
    {
        return $this->state(fn () => ['requires_attachment' => true]);
    }

    /**
     * Mark the leave type as inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
