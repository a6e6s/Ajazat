<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LeaveBalancesRelationManager extends RelationManager
{
    protected static string $relationship = 'leaveBalances';

    protected static ?string $title = 'أرصدة إجازات الموظف';

    protected static ?string $modelLabel = 'رصيد إجازات';

    protected static ?string $pluralModelLabel = 'أرصدة الإجازات';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('leave_type_id')
                    ->label('نوع الإجازة')
                    ->relationship('leaveType', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('year')
                    ->label('السنة')
                    ->required()
                    ->numeric()
                    ->default((int) date('Y')),
                TextInput::make('entitled_days')
                    ->label('الأيام المستحقة')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('used_days')
                    ->label('الأيام المستهلكة')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('adjustment_days')
                    ->label('أيام التعديل (تسوية)')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('leaveType.name')
            ->columns([
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
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
