<?php

namespace App\Filament\Widgets;

use App\Models\MaintenanceSchedule;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class UpcomingMaintenanceTable extends TableWidget
{
    protected static ?string $heading = 'Upcoming & Overdue Maintenance';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                MaintenanceSchedule::query()
                    ->where('status', 'active')
                    ->where(function ($query) {
                        $query->where('next_due_at', '<=', now()->addDays(30))
                            ->orWhereNull('next_due_at');
                    })
                    ->orderBy('next_due_at')
            )
            ->columns([
                TextColumn::make('name')
                    ->weight('bold'),
                TextColumn::make('asset.name')
                    ->label('Asset'),
                TextColumn::make('schedule_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'time_based' => 'info',
                        'meter_based' => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'time_based' => 'Time',
                        'meter_based' => 'Meter',
                    }),
                TextColumn::make('next_due_at')
                    ->label('Due Date')
                    ->date()
                    ->color(fn ($record) => $record->is_overdue ? 'danger' : ($record->is_upcoming ? 'warning' : null))
                    ->weight(fn ($record) => $record->is_overdue ? 'bold' : null),
                TextColumn::make('frequency_value')
                    ->label('Frequency')
                    ->formatStateUsing(fn ($record) => $record->frequency_value . ' ' . ucfirst($record->frequency_unit)),
            ])
            ->paginated([5]);
    }
}
