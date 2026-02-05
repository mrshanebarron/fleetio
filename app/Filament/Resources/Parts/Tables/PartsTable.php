<?php

namespace App\Filament\Resources\Parts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PartsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('part_number')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('category')
                    ->searchable()
                    ->badge()
                    ->color('gray'),
                TextColumn::make('quantity_on_hand')
                    ->label('Qty')
                    ->numeric()
                    ->sortable()
                    ->color(fn ($record) => $record->is_low_stock ? 'danger' : null)
                    ->weight(fn ($record) => $record->is_low_stock ? 'bold' : null),
                TextColumn::make('minimum_quantity')
                    ->label('Min')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('unit_cost')
                    ->money('usd')
                    ->sortable(),
                TextColumn::make('location')
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
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
