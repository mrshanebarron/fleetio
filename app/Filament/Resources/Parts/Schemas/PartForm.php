<?php

namespace App\Filament\Resources\Parts\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PartForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Part Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('part_number')
                            ->maxLength(100),
                        TextInput::make('category')
                            ->maxLength(100),
                        TextInput::make('location')
                            ->maxLength(255),
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                Section::make('Stock & Pricing')
                    ->columns(3)
                    ->schema([
                        TextInput::make('quantity_on_hand')
                            ->label('Qty on Hand')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        TextInput::make('minimum_quantity')
                            ->label('Min Qty')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        TextInput::make('unit_cost')
                            ->numeric()
                            ->prefix('$'),
                    ]),
            ]);
    }
}
