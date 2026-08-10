<?php

namespace App\Filament\Resources\LeaveBalances;

use App\Filament\Resources\LeaveBalances\Pages\CreateLeaveBalance;
use App\Filament\Resources\LeaveBalances\Pages\EditLeaveBalance;
use App\Filament\Resources\LeaveBalances\Pages\ListLeaveBalances;
use App\Filament\Resources\LeaveBalances\Schemas\LeaveBalanceForm;
use App\Filament\Resources\LeaveBalances\Tables\LeaveBalancesTable;
use App\Models\LeaveBalance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LeaveBalanceResource extends Resource
{
    protected static ?string $model = LeaveBalance::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalculator;

    protected static string|UnitEnum|null $navigationGroup = 'إدارة الإجازات';

    protected static ?string $modelLabel = 'رصيد إجازات';

    protected static ?string $pluralModelLabel = 'أرصدة الإجازات';

    protected static ?string $navigationLabel = 'أرصدة الإجازات';

    public static function form(Schema $schema): Schema
    {
        return LeaveBalanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LeaveBalancesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLeaveBalances::route('/'),
            'create' => CreateLeaveBalance::route('/create'),
            'edit' => EditLeaveBalance::route('/{record}/edit'),
        ];
    }
}
