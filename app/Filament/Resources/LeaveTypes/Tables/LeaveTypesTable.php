<?php

namespace App\Filament\Resources\LeaveTypes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class LeaveTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('اسم نوع الإجازة')
                    ->searchable()
                    ->sortable(),
                ColorColumn::make('color')
                    ->label('اللون'),
                TextColumn::make('max_days_per_year')
                    ->label('الحد الأقصى سنوياً')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('requires_attachment')
                    ->label('يتطلب مرفق')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('مفعل')
                    ->boolean(),
                TextColumn::make('leave_balances_count')
                    ->counts('leaveBalances')
                    ->label('عدد الأرصدة')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
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
