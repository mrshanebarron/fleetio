<?php

namespace App\Filament\Resources\Assets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class AssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'vehicle' => 'primary',
                        'trailer' => 'info',
                        'equipment' => 'warning',
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'gray',
                        'in_shop' => 'warning',
                        'out_of_service' => 'danger',
                    }),
                TextColumn::make('make')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('model')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('year')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('current_meter_value')
                    ->label('Meter')
                    ->numeric()
                    ->sortable()
                    ->suffix(fn ($record) => ' ' . $record->meter_unit),
                TextColumn::make('assignedTo.name')
                    ->label('Assigned To')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('license_plate')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('vin')
                    ->label('VIN')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'vehicle' => 'Vehicle',
                        'trailer' => 'Trailer',
                        'equipment' => 'Equipment',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'in_shop' => 'In Shop',
                        'out_of_service' => 'Out of Service',
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
            ->defaultSort('name');
    }
}
