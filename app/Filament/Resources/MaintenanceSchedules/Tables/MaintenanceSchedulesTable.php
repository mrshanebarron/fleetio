<?php

namespace App\Filament\Resources\MaintenanceSchedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class MaintenanceSchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('asset.name')
                    ->searchable()
                    ->sortable(),
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
                TextColumn::make('frequency_value')
                    ->label('Frequency')
                    ->formatStateUsing(fn ($record) => $record->frequency_value . ' ' . ucfirst($record->frequency_unit)),
                TextColumn::make('next_due_at')
                    ->label('Next Due')
                    ->date()
                    ->sortable()
                    ->color(fn ($record) => $record->is_overdue ? 'danger' : ($record->is_upcoming ? 'warning' : null)),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'paused' => 'gray',
                    }),
                TextColumn::make('last_completed_at')
                    ->label('Last Done')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'paused' => 'Paused',
                    ]),
                SelectFilter::make('schedule_type')
                    ->label('Type')
                    ->options([
                        'time_based' => 'Time-Based',
                        'meter_based' => 'Meter-Based',
                    ]),
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
            ])
            ->defaultSort('next_due_at');
    }
}
