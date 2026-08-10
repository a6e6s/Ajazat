<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveBalance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'leave_type_id',
        'year',
        'entitled_days',
        'used_days',
        'adjustment_days',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'user_id' => 'integer',
            'leave_type_id' => 'integer',
            'year' => 'integer',
            'entitled_days' => 'decimal:2',
            'used_days' => 'decimal:2',
            'adjustment_days' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class);
    }

    /**
     * Calculated remaining leave days.
     */
    public function getRemainingDaysAttribute(): float
    {
        return (float) $this->entitled_days - (float) $this->used_days + (float) $this->adjustment_days;
    }
}
