<?php

namespace App\Filament\Support;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class LocalizedFields
{
    /**
     * @param  array<int, array{type: string, name: string, label: string, rows?: int, required?: bool, maxLength?: int}>  $fields
     */
    public static function tabs(array $fields): Tabs
    {
        return Tabs::make('Translations')
            ->tabs([
                self::localeTab('English', 'en', $fields),
                self::localeTab('Arabic', 'ar', $fields),
                self::localeTab('French', 'fr', $fields),
            ])
            ->columnSpanFull();
    }

    /**
     * @param  array<int, array{type: string, name: string, label: string, rows?: int, required?: bool, maxLength?: int}>  $fields
     */
    private static function localeTab(string $label, string $locale, array $fields): Tab
    {
        return Tab::make($label)->schema(
            collect($fields)
                ->map(fn (array $field) => self::makeField($field, $locale))
                ->all()
        );
    }

    /**
     * @param  array{type: string, name: string, label: string, rows?: int, required?: bool, maxLength?: int}  $field
     */
    private static function makeField(array $field, string $locale): TextInput|Textarea|RichEditor
    {
        $name = "{$field['name']}_{$locale}";
        $label = $field['label'];

        $component = match ($field['type']) {
            'textarea' => Textarea::make($name)
                ->label($label)
                ->rows($field['rows'] ?? 4)
                ->columnSpanFull(),
            'richtext' => RichEditor::make($name)
                ->label($label)
                ->columnSpanFull(),
            default => TextInput::make($name)->label($label),
        };

        if (($field['required'] ?? false) && $locale === 'en') {
            $component->required();
        }

        if (isset($field['maxLength'])) {
            $component->maxLength($field['maxLength']);
        }

        return $component;
    }

    public static function imageUpload(string $name = 'image_upload', string $label = 'Image'): FileUpload
    {
        return FileUpload::make($name)
            ->label($label)
            ->image()
            ->disk(config('media.disk'))
            ->directory(trim(config('media.base_path'), '/').'/tmp')
            ->visibility('public')
            ->maxSize(8192)
            ->nullable()
            ->columnSpanFull();
    }

    public static function galleryUpload(string $name = 'gallery_upload', int $maxFiles = 3): FileUpload
    {
        return FileUpload::make($name)
            ->label('Gallery Images')
            ->image()
            ->multiple()
            ->maxFiles($maxFiles)
            ->reorderable()
            ->disk(config('media.disk'))
            ->directory(trim(config('media.base_path'), '/').'/tmp')
            ->visibility('public')
            ->maxSize(8192)
            ->nullable()
            ->columnSpanFull();
    }
}
