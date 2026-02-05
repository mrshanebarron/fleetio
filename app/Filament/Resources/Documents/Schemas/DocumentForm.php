<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Document Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Select::make('documentable_type')
                            ->label('Attached To')
                            ->options([
                                'App\\Models\\Asset' => 'Asset',
                                'App\\Models\\WorkOrder' => 'Work Order',
                            ])
                            ->native(false)
                            ->live(),
                        TextInput::make('documentable_id')
                            ->label('Record ID')
                            ->numeric(),
                        DatePicker::make('expires_at')
                            ->label('Expiry Date'),
                        FileUpload::make('file_path')
                            ->label('File')
                            ->directory('documents')
                            ->required()
                            ->maxSize(10240)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
