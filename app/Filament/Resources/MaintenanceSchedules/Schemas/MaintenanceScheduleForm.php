<?php

namespace App\Filament\Resources\MaintenanceSchedules\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MaintenanceScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Schedule Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Select::make('asset_id')
                            ->relationship('asset', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                        Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'paused' => 'Paused',
                            ])
                            ->default('active')
                            ->required()
                            ->native(false),
                    ]),
                Section::make('Frequency')
                    ->columns(3)
                    ->schema([
                        Select::make('schedule_type')
                            ->options([
                                'time_based' => 'Time-Based',
                                'meter_based' => 'Meter-Based',
                            ])
                            ->required()
                            ->native(false)
                            ->live(),
                        TextInput::make('frequency_value')
                            ->label('Every')
                            ->numeric()
                            ->required(),
                        Select::make('frequency_unit')
                            ->options([
                                'days' => 'Days',
                                'weeks' => 'Weeks',
                                'months' => 'Months',
                                'miles' => 'Miles',
                                'hours' => 'Hours',
                            ])
                            ->required()
                            ->native(false),
                    ]),
                Section::make('Last Service')
                    ->columns(2)
                    ->schema([
                        DateTimePicker::make('last_completed_at')
                            ->label('Last Completed'),
                        TextInput::make('last_meter_value')
                            ->label('Last Meter Reading')
                            ->numeric(),
                    ]),
                Section::make('Next Due')
                    ->columns(2)
                    ->schema([
                        DateTimePicker::make('next_due_at')
                            ->label('Next Due Date'),
                        TextInput::make('next_due_meter')
                            ->label('Next Due Meter')
                            ->numeric(),
                    ]),
            ]);
    }
}
