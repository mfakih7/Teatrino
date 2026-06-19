<?php

namespace App\Filament\Resources\AboutPages\Schemas;

use App\Filament\Support\LocalizedFields;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AboutPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Content')->schema([
                LocalizedFields::tabs([
                    ['type' => 'text', 'name' => 'title', 'label' => 'Page Title'],
                    ['type' => 'richtext', 'name' => 'body', 'label' => 'Story / Body'],
                    ['type' => 'textarea', 'name' => 'mission', 'label' => 'Mission', 'rows' => 4],
                    ['type' => 'textarea', 'name' => 'vision', 'label' => 'Vision', 'rows' => 4],
                ]),
                LocalizedFields::galleryUpload('gallery_upload', 3),
                Toggle::make('is_active')->default(true),
            ]),
        ]);
    }
}
