<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Asset Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->options([
                                'vehicle' => 'Vehicle',
                                'trailer' => 'Trailer',
                                'equipment' => 'Equipment',
                            ])
                            ->required()
                            ->native(false),
                        TextInput::make('make')
                            ->maxLength(100),
                        TextInput::make('model')
                            ->maxLength(100),
                        TextInput::make('year')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(2030),
                        Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'in_shop' => 'In Shop',
                                'out_of_service' => 'Out of Service',
                            ])
                            ->default('active')
                            ->required()
                            ->native(false),
                    ]),
                Section::make('Identification')
                    ->columns(2)
                    ->schema([
                        TextInput::make('vin')
                            ->label('VIN')
                            ->maxLength(17),
                        TextInput::make('license_plate')
                            ->maxLength(20),
                        TextInput::make('group')
                            ->maxLength(100),
                    ]),
                Section::make('Meter')
                    ->columns(2)
                    ->schema([
                        TextInput::make('current_meter_value')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Select::make('meter_unit')
                            ->options([
                                'miles' => 'Miles',
                                'hours' => 'Hours',
                                'kilometers' => 'Kilometers',
                            ])
                            ->default('miles')
                            ->required()
                            ->native(false),
                    ]),
                Section::make('Assignment')
                    ->schema([
                        Select::make('assigned_to')
                            ->relationship('assignedTo', 'name')
                            ->searchable()
                            ->preload(),
                        FileUpload::make('photo')
                            ->image()
                            ->directory('assets')
                            ->maxSize(5120),
                    ]),
            ]);
    }
}
