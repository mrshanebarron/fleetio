<?php

namespace App\Filament\Resources\MaintenanceSchedules;

use App\Filament\Resources\MaintenanceSchedules\Pages\CreateMaintenanceSchedule;
use App\Filament\Resources\MaintenanceSchedules\Pages\EditMaintenanceSchedule;
use App\Filament\Resources\MaintenanceSchedules\Pages\ListMaintenanceSchedules;
use App\Filament\Resources\MaintenanceSchedules\Schemas\MaintenanceScheduleForm;
use App\Filament\Resources\MaintenanceSchedules\Tables\MaintenanceSchedulesTable;
use App\Models\MaintenanceSchedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaintenanceScheduleResource extends Resource
{
    protected static ?string $model = MaintenanceSchedule::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|\UnitEnum|null $navigationGroup = 'Maintenance';

    protected static ?string $navigationLabel = 'PM Schedules';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return MaintenanceScheduleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaintenanceSchedulesTable::configure($table);
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
            'index' => ListMaintenanceSchedules::route('/'),
            'create' => CreateMaintenanceSchedule::route('/create'),
            'edit' => EditMaintenanceSchedule::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
