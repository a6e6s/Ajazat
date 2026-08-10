<?php

namespace App\Filament\Widgets;

use App\Enums\LeaveRequestStatus;
use App\Models\Department;
use App\Models\LeaveRequest;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeaveStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $pendingCount = LeaveRequest::where('status', LeaveRequestStatus::Pending)->count();
        $approvedCount = LeaveRequest::where('status', LeaveRequestStatus::Approved)->count();
        $employeesCount = User::count();
        $departmentsCount = Department::count();

        return [
            Stat::make('طلبات قيد الانتظار', $pendingCount)
                ->description('بانتظار اعتماد المدير المباشر')
                ->descriptionIcon('heroicon-o-clock')
                ->chart([3, 5, 2, 4, $pendingCount])
                ->color($pendingCount > 0 ? 'warning' : 'gray'),

            Stat::make('الطلبات المقبولة', $approvedCount)
                ->description('إجمالي الإجازات المعتمودة هذا الشهر')
                ->descriptionIcon('heroicon-o-check-circle')
                ->chart([1, 2, 4, 3, $approvedCount])
                ->color('success'),

            Stat::make('إجمالي الموظفين', $employeesCount)
                ->description('موزعين على مختلف الأقسام')
                ->descriptionIcon('heroicon-o-users')
                ->chart([2, 3, 4, 5, $employeesCount])
                ->color('info'),

            Stat::make('إجمالي الأقسام الإدارية', $departmentsCount)
                ->description('الأقسام التشغيلية والإدارية')
                ->descriptionIcon('heroicon-o-building-office')
                ->chart([1, 2, 3, $departmentsCount])
                ->color('primary'),
        ];
    }
}
