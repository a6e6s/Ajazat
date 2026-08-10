<?php

namespace App\Filament\Resources\LeaveRequests\Pages;

use App\Actions\ProcessLeaveDecision;
use App\Enums\LeaveRequestStatus;
use App\Filament\Resources\LeaveRequests\LeaveRequestResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditLeaveRequest extends EditRecord
{
    protected static string $resource = LeaveRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->label('موافقة')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('الموافقة على طلب الإجازة')
                ->modalDescription('هل أنت تأكد من موافقتك على طلب الإجازة هذا؟ سيتم خصم الأيام من رصيد الموظف.')
                ->form([
                    Textarea::make('comment')
                        ->label('ملاحظات (اختياري)')
                        ->rows(2),
                ])
                ->action(function (array $data) {
                    app(ProcessLeaveDecision::class)->approve(
                        $this->record,
                        auth()->user(),
                        $data['comment'] ?? null,
                    );

                    Notification::make()
                        ->title('تمت الموافقة على طلب الإجازة بنجاح')
                        ->success()
                        ->send();

                    $this->refreshFormData(['status', 'decided_by', 'decided_at']);
                })
                ->visible(fn () => $this->record->status === LeaveRequestStatus::Pending),

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
                        ->rows(3),
                ])
                ->action(function (array $data) {
                    app(ProcessLeaveDecision::class)->reject(
                        $this->record,
                        auth()->user(),
                        $data['reason'],
                    );

                    Notification::make()
                        ->title('تم رفض طلب الإجازة')
                        ->danger()
                        ->send();

                    $this->refreshFormData(['status', 'decided_by', 'decided_at', 'rejection_reason']);
                })
                ->visible(fn () => $this->record->status === LeaveRequestStatus::Pending),

            Action::make('cancel')
                ->label('إلغاء الطلب')
                ->icon('heroicon-o-minus-circle')
                ->color('gray')
                ->requiresConfirmation()
                ->modalHeading('إلغاء طلب الإجازة')
                ->modalDescription('سيتم إلغاء طلب الإجازة. إذا كان مقبولاً مسبقاً، سيتم إرجاع الخصم إلى رصيد الموظف.')
                ->form([
                    Textarea::make('comment')
                        ->label('سبب الإلغاء')
                        ->rows(2),
                ])
                ->action(function (array $data) {
                    app(ProcessLeaveDecision::class)->cancel(
                        $this->record,
                        auth()->user(),
                        $data['comment'] ?? null,
                    );

                    Notification::make()
                        ->title('تم إلغاء طلب الإجازة')
                        ->warning()
                        ->send();

                    $this->refreshFormData(['status']);
                })
                ->visible(fn () => in_array($this->record->status, [
                    LeaveRequestStatus::Pending,
                    LeaveRequestStatus::Approved,
                ])),

            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
