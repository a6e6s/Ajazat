<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات الموظف')
                    ->schema([
                        TextInput::make('name')
                            ->label('اسم الموظف')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('password')
                            ->label('كلمة المرور')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create'),
                    ])->columns(2),
                Section::make('القسم والتبعية الإدارية')
                    ->schema([
                        Select::make('department_id')
                            ->label('القسم')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('manager_id')
                            ->label('المدير المباشر')
                            ->relationship('manager', 'name')
                            ->searchable()
                            ->preload(),
                    ])->columns(2),
            ]);
    }
}
