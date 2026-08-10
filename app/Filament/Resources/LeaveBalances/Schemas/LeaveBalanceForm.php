<?php

namespace App\Filament\Resources\LeaveBalances\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LeaveBalanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('الموظف')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('leave_type_id')
                    ->label('نوع الإجازة')
                    ->relationship('leaveType', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
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
}
