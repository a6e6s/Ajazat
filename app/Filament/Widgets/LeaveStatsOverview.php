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
                ->description('بانتظار موافقة المدير المباشر')
                ->descriptionIcon('heroicon-o-clock')
                ->color($pendingCount > 0 ? 'warning' : 'gray'),

            Stat::make('الطلبات المقبولة', $approvedCount)
                ->description('إجمالي الإجازات المعتمودة')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('إجمالي الموظفين', $employeesCount)
                ->description('في مختلف الأقسام')
                ->descriptionIcon('heroicon-o-users')
                ->color('info'),

            Stat::make('إجمالي الأقسام', $departmentsCount)
                ->description('الأقسام الإدارية والتشغيلية')
                ->descriptionIcon('heroicon-o-building-office')
                ->color('primary'),
        ];
    }
}
