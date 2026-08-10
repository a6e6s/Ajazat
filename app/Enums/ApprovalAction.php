<?php

namespace App\Enums;

enum ApprovalAction: string
{
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';
    case Escalated = 'escalated';

    public function label(): string
    {
        return match ($this) {
            self::Approved => 'موافقة',
            self::Rejected => 'رفض',
            self::Cancelled => 'إلغاء',
            self::Escalated => 'تصعيد',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Approved => 'success',
            self::Rejected => 'danger',
            self::Cancelled => 'gray',
            self::Escalated => 'info',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Approved => 'heroicon-o-check-circle',
            self::Rejected => 'heroicon-o-x-circle',
            self::Cancelled => 'heroicon-o-minus-circle',
            self::Escalated => 'heroicon-o-arrow-up-circle',
        };
    }
}
