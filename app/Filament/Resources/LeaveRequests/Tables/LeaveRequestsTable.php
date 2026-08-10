<?php

namespace App\Filament\Resources\LeaveRequests\Tables;

use App\Enums\LeaveRequestStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class LeaveRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('الموظف')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('leaveType.name')
                    ->label('نوع الإجازة')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->label('تاريخ البداية')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('تاريخ النهاية')
                    ->date()
                    ->sortable(),
                TextColumn::make('days_count')
                    ->label('الأيام')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->sortable(),
                TextColumn::make('decidedBy.name')
                    ->label('صاحب القرار')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('decided_at')
                    ->label('تاريخ القرار')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('تاريخ التقديم')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(LeaveRequestStatus::class),
                SelectFilter::make('leave_type_id')
                    ->relationship('leaveType', 'name')
                    ->label('نوع الإجازة')
                    ->preload(),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
