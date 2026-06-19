<?php

namespace App\Filament\Resources\Children\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ChildInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Child Details')->schema([
                ImageEntry::make('profile_photo_thumbnail_path')
                    ->label('Profile Photo')
                    ->disk(config('media.disk'))
                    ->height(120)
                    ->columnSpanFull(),
                TextEntry::make('full_name'),
                TextEntry::make('parent.full_name')->label('Parent'),
                TextEntry::make('date_of_birth')->date()->placeholder('—'),
                TextEntry::make('gender')->placeholder('—'),
                TextEntry::make('class_name')->label('Class')->placeholder('—'),
                IconEntry::make('is_active')->boolean(),
            ])->columns(2),
            Section::make('Health & Notes')->schema([
                TextEntry::make('allergies')->placeholder('—')->columnSpanFull(),
                TextEntry::make('health_notes')->placeholder('—')->columnSpanFull(),
                TextEntry::make('special_notes')->placeholder('—')->columnSpanFull(),
            ]),
        ]);
    }
}
