<?php

namespace App\Filament\Resources\LeaveBalances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LeaveBalancesTable
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
                TextColumn::make('year')
                    ->label('السنة')
                    ->sortable(),
                TextColumn::make('entitled_days')
                    ->label('المستحق')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('used_days')
                    ->label('المستهلك')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('adjustment_days')
                    ->label('التعديل')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('remaining_days')
                    ->label('المتبقي')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn ($state): string => match (true) {
                        $state <= 0 => 'danger',
                        $state <= 3 => 'warning',
                        default => 'success',
                    }),
            ])
            ->defaultSort('year', 'desc')
            ->filters([
                SelectFilter::make('year')
                    ->label('السنة')
                    ->options(fn () => collect(range(now()->year, now()->year - 2))
                        ->mapWithKeys(fn ($year) => [$year => $year])
                        ->toArray()),
                SelectFilter::make('leave_type_id')
                    ->relationship('leaveType', 'name')
                    ->label('نوع الإجازة')
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
