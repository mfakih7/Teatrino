<?php

namespace App\Filament\Resources\Teachers\Schemas;

use App\Filament\Support\LocalizedFields;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                LocalizedFields::tabs([
                    ['type' => 'text', 'name' => 'name', 'label' => 'Name', 'required' => true, 'maxLength' => 255],
                    ['type' => 'text', 'name' => 'position', 'label' => 'Position / Title', 'maxLength' => 255],
                    ['type' => 'textarea', 'name' => 'description', 'label' => 'Description / Bio', 'rows' => 5, 'required' => true],
                    ['type' => 'textarea', 'name' => 'education', 'label' => 'Education / Qualifications', 'rows' => 4],
                ]),
                LocalizedFields::imageUpload('image_upload', 'Teacher Photo'),
                TextInput::make('sort_order')->numeric()->default(0)->minValue(0),
                Toggle::make('is_active')->default(true)->label('Active'),
            ]),
        ]);
    }
}
