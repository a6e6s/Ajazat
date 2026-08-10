<?php

namespace App\Filament\Widgets;

use App\Actions\ProcessLeaveDecision;
use App\Enums\LeaveRequestStatus;
use App\Models\LeaveRequest;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingLeaveRequestsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'أحدث طلبات الإجازات المعلقة (قيد الانتظار)';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                LeaveRequest::query()
                    ->where('status', LeaveRequestStatus::Pending)
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('الموظف')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('user.department.name')
                    ->label('القسم')
                    ->badge()
                    ->color('info'),
                TextColumn::make('leaveType.name')
                    ->label('نوع الإجازة')
                    ->badge(),
                TextColumn::make('start_date')
                    ->label('من تاريخ')
                    ->date(),
                TextColumn::make('end_date')
                    ->label('إلى تاريخ')
                    ->date(),
                TextColumn::make('days_count')
                    ->label('الأيام')
                    ->numeric()
                    ->badge()
                    ->color('gray'),
                TextColumn::make('reason')
                    ->label('السبب')
                    ->limit(35),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('اعتماد / موافقة')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('الموافقة على طلب الإجازة')
                    ->modalDescription('هل أنت تأكد من اعتماد طلب الإجازة؟ سيتم خصم الأيام من رصيد الموظف.')
                    ->form([
                        Textarea::make('comment')
                            ->label('ملاحظات (اختياري)')
                            ->rows(2),
                    ])
                    ->action(function (LeaveRequest $record, array $data) {
                        app(ProcessLeaveDecision::class)->approve(
                            $record,
                            auth()->user(),
                            $data['comment'] ?? null,
                        );

                        Notification::make()
                            ->title('تمت الموافقة على طلب الإجازة بنجاح')
                            ->success()
                            ->send();
                    }),

                Action::make('reject')
                    ->label('رفض')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('رفض طلب الإجازة')
                    ->form([
                        Textarea::make('reason')
                            ->label('سبب الرفض')
                            ->required()
                            ->rows(2),
                    ])
                    ->action(function (LeaveRequest $record, array $data) {
                        app(ProcessLeaveDecision::class)->reject(
                            $record,
                            auth()->user(),
                            $data['reason'],
                        );

                        Notification::make()
                            ->title('تم رفض طلب الإجازة')
                            ->danger()
                            ->send();
                    }),
            ]);
    }
}
