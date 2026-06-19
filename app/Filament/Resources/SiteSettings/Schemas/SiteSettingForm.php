<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use App\Filament\Support\LocalizedFields;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('General')->schema([
                LocalizedFields::tabs([
                    ['type' => 'text', 'name' => 'website_name', 'label' => 'Website Name'],
                ]),
                TextInput::make('email')
                    ->email()
                    ->maxLength(255),
            ]),
            Section::make('Footer')->schema([
                LocalizedFields::tabs([
                    ['type' => 'textarea', 'name' => 'footer_text', 'label' => 'Footer Short Text', 'rows' => 3],
                ]),
            ]),
            Section::make('Contact Page')->schema([
                LocalizedFields::tabs([
                    ['type' => 'text', 'name' => 'contact_title', 'label' => 'Contact Title'],
                    ['type' => 'textarea', 'name' => 'contact_description', 'label' => 'Contact Description', 'rows' => 4],
                ]),
            ]),
        ]);
    }
}
