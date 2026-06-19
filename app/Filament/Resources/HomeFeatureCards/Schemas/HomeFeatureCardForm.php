<?php

namespace App\Filament\Resources\HomeFeatureCards\Schemas;

use App\Filament\Support\LocalizedFields;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HomeFeatureCardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                LocalizedFields::tabs([
                    ['type' => 'text', 'name' => 'title', 'label' => 'Title'],
                    ['type' => 'textarea', 'name' => 'description', 'label' => 'Description', 'rows' => 3],
                ]),
                TextInput::make('icon')
                    ->label('Icon / Emoji')
                    ->maxLength(16)
                    ->default('🎨'),
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->default(true),
            ]),
        ]);
    }
}
