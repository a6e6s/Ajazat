<?php

namespace App\Actions;

use App\Enums\ApprovalAction;
use App\Enums\LeaveRequestStatus;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProcessLeaveDecision
{
    /**
     * Approve a leave request and deduct from the employee's balance.
     */
    public function approve(LeaveRequest $leaveRequest, User $decidedBy, ?string $comment = null): void
    {
        DB::transaction(function () use ($leaveRequest, $decidedBy, $comment) {
            $leaveRequest->update([
                'status' => LeaveRequestStatus::Approved,
                'decided_by' => $decidedBy->id,
                'decided_at' => now(),
            ]);

            $leaveRequest->approvalLogs()->create([
                'user_id' => $decidedBy->id,
                'action' => ApprovalAction::Approved,
                'comment' => $comment,
            ]);

            $this->deductBalance($leaveRequest);
        });
    }

    /**
     * Reject a leave request.
     */
    public function reject(LeaveRequest $leaveRequest, User $decidedBy, ?string $reason = null, ?string $comment = null): void
    {
        DB::transaction(function () use ($leaveRequest, $decidedBy, $reason, $comment) {
            $leaveRequest->update([
                'status' => LeaveRequestStatus::Rejected,
                'decided_by' => $decidedBy->id,
                'decided_at' => now(),
                'rejection_reason' => $reason,
            ]);

            $leaveRequest->approvalLogs()->create([
                'user_id' => $decidedBy->id,
                'action' => ApprovalAction::Rejected,
                'comment' => $comment ?? $reason,
            ]);
        });
    }

    /**
     * Cancel an approved leave request and reverse the balance deduction.
     */
    public function cancel(LeaveRequest $leaveRequest, User $cancelledBy, ?string $comment = null): void
    {
        $wasApproved = $leaveRequest->status === LeaveRequestStatus::Approved;

        DB::transaction(function () use ($leaveRequest, $cancelledBy, $comment, $wasApproved) {
            $leaveRequest->update([
                'status' => LeaveRequestStatus::Cancelled,
            ]);

            $leaveRequest->approvalLogs()->create([
                'user_id' => $cancelledBy->id,
                'action' => ApprovalAction::Cancelled,
                'comment' => $comment,
            ]);

            if ($wasApproved) {
                $this->reverseBalance($leaveRequest);
            }
        });
    }

    /**
     * Deduct days from the employee's leave balance.
     */
    private function deductBalance(LeaveRequest $leaveRequest): void
    {
        $balance = LeaveBalance::firstOrCreate(
            [
                'user_id' => $leaveRequest->user_id,
                'leave_type_id' => $leaveRequest->leave_type_id,
                'year' => $leaveRequest->start_date->year,
            ],
            [
                'entitled_days' => 0,
                'used_days' => 0,
                'adjustment_days' => 0,
            ]
        );

        $balance->increment('used_days', (float) $leaveRequest->days_count);
    }

    /**
     * Reverse a balance deduction when a leave is cancelled.
     */
    private function reverseBalance(LeaveRequest $leaveRequest): void
    {
        $balance = LeaveBalance::where([
            'user_id' => $leaveRequest->user_id,
            'leave_type_id' => $leaveRequest->leave_type_id,
            'year' => $leaveRequest->start_date->year,
        ])->first();

        if ($balance) {
            $balance->decrement('used_days', (float) $leaveRequest->days_count);
        }
    }
}
