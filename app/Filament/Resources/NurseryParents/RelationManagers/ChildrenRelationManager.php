<?php

namespace App\Filament\Resources\NurseryParents\RelationManagers;

use App\Filament\Resources\Children\ChildResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ChildrenRelationManager extends RelationManager
{
    protected static string $relationship = 'children';

    protected static ?string $title = 'Children';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                ImageColumn::make('profile_photo_thumbnail_path')
                    ->label('Photo')
                    ->disk(config('media.disk'))
                    ->square(),
                TextColumn::make('full_name')->searchable(),
                TextColumn::make('class_name')->placeholder('—'),
                TextColumn::make('date_of_birth')->date()->placeholder('—'),
                IconColumn::make('is_active')->boolean(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordUrl(fn ($record) => ChildResource::getUrl('view', ['record' => $record]));
    }
}
