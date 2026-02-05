<?php

namespace App\Filament\Resources\Inspections\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InspectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Inspection Details')
                    ->columns(2)
                    ->schema([
                        Select::make('asset_id')
                            ->relationship('asset', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('template_name')
                            ->label('Template')
                            ->required()
                            ->maxLength(255),
                        Select::make('inspector_id')
                            ->relationship('inspector', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'passed' => 'Passed',
                                'failed' => 'Failed',
                            ])
                            ->default('pending')
                            ->required()
                            ->native(false),
                        DateTimePicker::make('completed_at'),
                        Textarea::make('notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                Section::make('Inspection Items')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                TextInput::make('label')
                                    ->required()
                                    ->maxLength(255),
                                Select::make('result')
                                    ->options([
                                        'pass' => 'Pass',
                                        'fail' => 'Fail',
                                        'na' => 'N/A',
                                    ])
                                    ->required()
                                    ->native(false),
                                Textarea::make('notes')
                                    ->rows(2),
                            ])
                            ->columns(3)
                            ->defaultItems(0)
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null),
                    ]),
            ]);
    }
}
