<?php

namespace Database\Factories;

use App\Enums\ApprovalAction;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApprovalLogFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'leave_request_id' => LeaveRequest::factory(),
            'user_id' => User::factory(),
            'action' => fake()->randomElement(ApprovalAction::cases()),
            'comment' => fake()->optional()->sentence(),
        ];
    }
}
