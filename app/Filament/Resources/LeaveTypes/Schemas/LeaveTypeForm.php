<?php

namespace App\Filament\Resources\LeaveTypes\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LeaveTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل نوع الإجازة')
                    ->schema([
                        TextInput::make('name')
                            ->label('اسم نوع الإجازة')
                            ->required()
                            ->maxLength(255),
                        ColorPicker::make('color')
                            ->label('اللون')
                            ->required()
                            ->default('#3B82F6'),
                        TextInput::make('max_days_per_year')
                            ->label('الحد الأقصى للأيام سنوياً')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                    ])->columns(3),
                Section::make('الإعدادات')
                    ->schema([
                        Toggle::make('requires_attachment')
                            ->label('يتطلب إرفاق مستند')
                            ->helperText('يجب على الموظف رفع تقرير أو مستند عند طلب هذه الإجازة.'),
                        Toggle::make('is_active')
                            ->label('مفعل')
                            ->default(true),
                    ])->columns(2),
            ]);
    }
}
