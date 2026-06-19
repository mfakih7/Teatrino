<?php

namespace App\Filament\Resources\Teachers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class TeachersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('thumbnail_path')
                    ->label('Photo')
                    ->getStateUsing(fn ($record) => $record->image()?->thumbnail_path)
                    ->disk(config('media.disk'))
                    ->circular(),
                TextColumn::make('name_en')->label('Name (EN)')->searchable(),
                TextColumn::make('position_en')->label('Position (EN)')->searchable()->toggleable(),
                TextColumn::make('sort_order')->sortable(),
                IconColumn::make('is_active')->boolean()->label('Active'),
            ])
            ->filters([
                TernaryFilter::make('is_active')->label('Active'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
