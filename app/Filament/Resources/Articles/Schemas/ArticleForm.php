<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Filament\Support\LocalizedFields;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                LocalizedFields::tabs([
                    ['type' => 'text', 'name' => 'title', 'label' => 'Title'],
                    ['type' => 'textarea', 'name' => 'excerpt', 'label' => 'Excerpt', 'rows' => 3],
                    ['type' => 'richtext', 'name' => 'body', 'label' => 'Body'],
                ]),
                LocalizedFields::imageUpload('image_upload', 'Featured Image'),
                DateTimePicker::make('published_at'),
                Toggle::make('is_active')->default(true),
            ]),
        ]);
    }
}
