<?php

namespace App\Filament\Resources\NurseryParents\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NurseryParentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Parent Details')->schema([
                TextEntry::make('full_name'),
                TextEntry::make('phone_number'),
                TextEntry::make('whatsapp_number')->placeholder('—'),
                TextEntry::make('address')->placeholder('—')->columnSpanFull(),
                IconEntry::make('is_active')->boolean(),
                TextEntry::make('children_count')->label('Children'),
            ])->columns(2),
            Section::make('Emergency Contact')->schema([
                TextEntry::make('emergency_contact_name')->placeholder('—'),
                TextEntry::make('emergency_contact_phone')->placeholder('—'),
            ])->columns(2),
            Section::make('Notes')->schema([
                TextEntry::make('notes')->placeholder('—')->columnSpanFull(),
            ]),
        ]);
    }
}
