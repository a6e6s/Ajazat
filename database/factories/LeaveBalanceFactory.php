<?php

namespace Database\Factories;

use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveBalanceFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $entitled = fake()->randomElement([10, 14, 21, 30]);
        $used = fake()->numberBetween(0, $entitled);

        return [
            'user_id' => User::factory(),
            'leave_type_id' => LeaveType::factory(),
            'year' => now()->year,
            'entitled_days' => $entitled,
            'used_days' => $used,
            'adjustment_days' => 0,
        ];
    }
}
