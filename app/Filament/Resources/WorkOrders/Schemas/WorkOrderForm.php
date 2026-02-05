<?php

namespace App\Filament\Resources\WorkOrders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class WorkOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Work Order Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('number')
                            ->label('WO Number')
                            ->disabled()
                            ->dehydrated()
                            ->placeholder('Auto-generated'),
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                        Select::make('asset_id')
                            ->relationship('asset', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('priority')
                            ->options([
                                'low' => 'Low',
                                'medium' => 'Medium',
                                'high' => 'High',
                                'critical' => 'Critical',
                            ])
                            ->default('medium')
                            ->required()
                            ->native(false),
                        Select::make('status')
                            ->options([
                                'open' => 'Open',
                                'in_progress' => 'In Progress',
                                'on_hold' => 'On Hold',
                                'completed' => 'Completed',
                                'closed' => 'Closed',
                            ])
                            ->default('open')
                            ->required()
                            ->native(false),
                    ]),
                Section::make('Assignment')
                    ->columns(2)
                    ->schema([
                        Select::make('assigned_to')
                            ->relationship('assignee', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('vendor_id')
                            ->relationship('vendor', 'name')
                            ->searchable()
                            ->preload(),
                    ]),
                Section::make('Timing')
                    ->columns(2)
                    ->schema([
                        DateTimePicker::make('started_at'),
                        DateTimePicker::make('completed_at'),
                        TextInput::make('downtime_hours')
                            ->numeric()
                            ->suffix('hours'),
                    ]),
                Section::make('Costs')
                    ->columns(2)
                    ->schema([
                        TextInput::make('total_parts_cost')
                            ->numeric()
                            ->prefix('$')
                            ->default(0)
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('total_labor_cost')
                            ->numeric()
                            ->prefix('$')
                            ->default(0)
                            ->disabled()
                            ->dehydrated(),
                    ]),
            ]);
    }
}
