<?php

namespace App\Filament\Resources\NurseryParents\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NurseryParentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Parent Details')->schema([
                TextInput::make('full_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone_number')
                    ->tel()
                    ->required()
                    ->maxLength(50),
                TextInput::make('whatsapp_number')
                    ->tel()
                    ->maxLength(50),
                Textarea::make('address')
                    ->rows(3)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->default(true),
            ])->columns(2),
            Section::make('Emergency Contact')->schema([
                TextInput::make('emergency_contact_name')
                    ->maxLength(255),
                TextInput::make('emergency_contact_phone')
                    ->tel()
                    ->maxLength(50),
            ])->columns(2),
            Section::make('Notes')->schema([
                Textarea::make('notes')
                    ->rows(4)
                    ->columnSpanFull(),
            ]),
        ]);
    }
}
