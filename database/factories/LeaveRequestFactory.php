<?php

namespace Database\Factories;

use App\Enums\LeaveRequestStatus;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('now', '+3 months');
        $days = fake()->randomElement([1, 2, 3, 5, 7, 10]);
        $endDate = (clone $startDate)->modify("+{$days} days");

        return [
            'user_id' => User::factory(),
            'leave_type_id' => LeaveType::factory(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'days_count' => $days,
            'reason' => fake()->sentence(),
            'status' => LeaveRequestStatus::Pending,
            'attachment_path' => null,
            'decided_by' => null,
            'decided_at' => null,
            'rejection_reason' => null,
        ];
    }

    /**
     * Mark the leave request as approved.
     */
    public function approved(): static
    {
        return $this->state(fn () => [
            'status' => LeaveRequestStatus::Approved,
            'decided_by' => User::factory(),
            'decided_at' => now(),
        ]);
    }

    /**
     * Mark the leave request as rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn () => [
            'status' => LeaveRequestStatus::Rejected,
            'decided_by' => User::factory(),
            'decided_at' => now(),
            'rejection_reason' => fake()->sentence(),
        ]);
    }

    /**
     * Mark the leave request as cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn () => [
            'status' => LeaveRequestStatus::Cancelled,
        ]);
    }
}
