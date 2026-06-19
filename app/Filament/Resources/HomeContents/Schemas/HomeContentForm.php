<?php

namespace App\Filament\Resources\HomeContents\Schemas;

use App\Filament\Support\LocalizedFields;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HomeContentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Hero')->schema([
                LocalizedFields::tabs([
                    ['type' => 'text', 'name' => 'hero_title', 'label' => 'Hero Title'],
                    ['type' => 'text', 'name' => 'hero_subtitle', 'label' => 'Hero Subtitle'],
                    ['type' => 'textarea', 'name' => 'hero_description', 'label' => 'Hero Description', 'rows' => 3],
                    ['type' => 'text', 'name' => 'cta_portfolio', 'label' => 'Portfolio CTA Label'],
                    ['type' => 'text', 'name' => 'cta_whatsapp', 'label' => 'WhatsApp CTA Label'],
                ]),
                LocalizedFields::imageUpload('hero_image_upload', 'Hero Image (optional)'),
            ]),
            Section::make('Welcome Section')->schema([
                LocalizedFields::tabs([
                    ['type' => 'text', 'name' => 'welcome_heading', 'label' => 'Welcome Heading'],
                ]),
            ]),
            Section::make('Explore Section')->schema([
                LocalizedFields::tabs([
                    ['type' => 'text', 'name' => 'explore_heading', 'label' => 'Explore Heading'],
                    ['type' => 'textarea', 'name' => 'explore_text', 'label' => 'Explore Text', 'rows' => 4],
                ]),
            ]),
        ]);
    }
}
