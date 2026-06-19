<?php

namespace App\Filament\Resources\PortfolioItems\Schemas;

use App\Filament\Support\LocalizedFields;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PortfolioItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                LocalizedFields::tabs([
                    ['type' => 'text', 'name' => 'title', 'label' => 'Title'],
                    ['type' => 'textarea', 'name' => 'description', 'label' => 'Description', 'rows' => 4],
                ]),
                LocalizedFields::imageUpload('image_upload', 'Portfolio Image'),
                TextInput::make('sort_order')->numeric()->default(0),
                Toggle::make('is_active')->default(true),
            ]),
        ]);
    }
}
