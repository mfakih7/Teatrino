<?php

namespace App\Filament\Resources\Children\Schemas;

use App\Filament\Support\LocalizedFields;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ChildForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Child Details')->schema([
                Select::make('parent_id')
                    ->relationship('parent', 'full_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('full_name')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('date_of_birth'),
                Select::make('gender')
                    ->options([
                        'female' => 'Female',
                        'male' => 'Male',
                    ])
                    ->nullable(),
                TextInput::make('class_name')
                    ->label('Class')
                    ->maxLength(100),
                Toggle::make('is_active')
                    ->default(true),
            ])->columns(2),
            Section::make('Profile Photo')->schema([
                LocalizedFields::imageUpload('profile_photo_upload', 'Profile Photo'),
            ]),
            Section::make('Health & Notes')->schema([
                Textarea::make('allergies')->rows(3)->columnSpanFull(),
                Textarea::make('health_notes')->rows(3)->columnSpanFull(),
                Textarea::make('special_notes')->rows(3)->columnSpanFull(),
            ]),
        ]);
    }
}
