<?php

namespace App\Filament\Resources\LeaveRequests\Schemas;

use App\Enums\LeaveRequestStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LeaveRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تفاصيل الطلب')
                    ->schema([
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
                        DatePicker::make('start_date')
                            ->label('تاريخ البداية')
                            ->required()
                            ->native(false),
                        DatePicker::make('end_date')
                            ->label('تاريخ النهاية')
                            ->required()
                            ->native(false)
                            ->afterOrEqual('start_date'),
                        TextInput::make('days_count')
                            ->label('عدد الأيام')
                            ->required()
                            ->numeric()
                            ->minValue(0.5)
                            ->step(0.5),
                    ])->columns(2),
                Section::make('التفاصيل والمرفقات')
                    ->schema([
                        Textarea::make('reason')
                            ->label('سبب الإجازة')
                            ->rows(3)
                            ->columnSpanFull(),
                        FileUpload::make('attachment_path')
                            ->label('المرفق')
                            ->directory('leave-attachments')
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                            ->maxSize(5120)
                            ->columnSpanFull(),
                    ]),
                Section::make('القرار والإجراءات')
                    ->schema([
                        Select::make('status')
                            ->label('الحالة')
                            ->options(LeaveRequestStatus::class)
                            ->default(LeaveRequestStatus::Pending)
                            ->required(),
                        Select::make('decided_by')
                            ->label('صاحب القرار')
                            ->relationship('decidedBy', 'name')
                            ->searchable()
                            ->preload(),
                        Textarea::make('rejection_reason')
                            ->label('سبب الرفض')
                            ->rows(2)
                            ->columnSpanFull()
                            ->visible(fn ($get) => $get('status') === LeaveRequestStatus::Rejected->value),
                    ])->columns(2)
                    ->collapsible(),
            ]);
    }
}
