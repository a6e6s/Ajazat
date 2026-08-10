<?php

use App\Actions\ProcessLeaveDecision;
use App\Enums\ApprovalAction;
use App\Enums\LeaveRequestStatus;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;

beforeEach(function () {
    $this->manager = User::factory()->create();
    $this->employee = User::factory()->create(['manager_id' => $this->manager->id]);
    $this->leaveType = LeaveType::factory()->create(['max_days_per_year' => 21]);
    $this->balance = LeaveBalance::factory()->create([
        'user_id' => $this->employee->id,
        'leave_type_id' => $this->leaveType->id,
        'year' => now()->year,
        'entitled_days' => 21,
        'used_days' => 0,
        'adjustment_days' => 0,
    ]);
    $this->leaveRequest = LeaveRequest::factory()->create([
        'user_id' => $this->employee->id,
        'leave_type_id' => $this->leaveType->id,
        'start_date' => now()->addDays(5),
        'end_date' => now()->addDays(9),
        'days_count' => 5,
        'status' => LeaveRequestStatus::Pending,
    ]);
    $this->action = new ProcessLeaveDecision;
});

test('approving a leave request updates status and deducts balance', function () {
    $this->action->approve($this->leaveRequest, $this->manager, 'Approved for vacation');

    $this->leaveRequest->refresh();
    $this->balance->refresh();

    expect($this->leaveRequest->status)->toBe(LeaveRequestStatus::Approved)
        ->and($this->leaveRequest->decided_by)->toBe($this->manager->id)
        ->and($this->leaveRequest->decided_at)->not->toBeNull()
        ->and((float) $this->balance->used_days)->toBe(5.0)
        ->and($this->balance->remaining_days)->toBe(16.0);
});

test('approving creates an approval log', function () {
    $this->action->approve($this->leaveRequest, $this->manager, 'Looks good');

    expect($this->leaveRequest->approvalLogs)->toHaveCount(1)
        ->and($this->leaveRequest->approvalLogs->first()->action)->toBe(ApprovalAction::Approved)
        ->and($this->leaveRequest->approvalLogs->first()->comment)->toBe('Looks good');
});

test('rejecting a leave request updates status and records reason', function () {
    $this->action->reject($this->leaveRequest, $this->manager, 'Team is understaffed');

    $this->leaveRequest->refresh();
    $this->balance->refresh();

    expect($this->leaveRequest->status)->toBe(LeaveRequestStatus::Rejected)
        ->and($this->leaveRequest->rejection_reason)->toBe('Team is understaffed')
        ->and((float) $this->balance->used_days)->toBe(0.0);
});

test('rejecting creates a rejection approval log', function () {
    $this->action->reject($this->leaveRequest, $this->manager, 'No capacity');

    expect($this->leaveRequest->approvalLogs)->toHaveCount(1)
        ->and($this->leaveRequest->approvalLogs->first()->action)->toBe(ApprovalAction::Rejected);
});

test('cancelling an approved request reverses balance deduction', function () {
    // First approve
    $this->action->approve($this->leaveRequest, $this->manager);
    $this->balance->refresh();
    expect((float) $this->balance->used_days)->toBe(5.0);

    // Then cancel
    $this->action->cancel($this->leaveRequest->refresh(), $this->manager, 'Plans changed');
    $this->balance->refresh();

    expect($this->leaveRequest->refresh()->status)->toBe(LeaveRequestStatus::Cancelled)
        ->and((float) $this->balance->used_days)->toBe(0.0);
});

test('cancelling a pending request does not affect balance', function () {
    $this->action->cancel($this->leaveRequest, $this->employee, 'Changed my mind');

    $this->leaveRequest->refresh();
    $this->balance->refresh();

    expect($this->leaveRequest->status)->toBe(LeaveRequestStatus::Cancelled)
        ->and((float) $this->balance->used_days)->toBe(0.0);
});

test('remaining days accessor computes correctly', function () {
    $balance = LeaveBalance::factory()->create([
        'entitled_days' => 21,
        'used_days' => 5,
        'adjustment_days' => 2,
    ]);

    expect($balance->remaining_days)->toBe(18.0);
});
