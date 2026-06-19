<?php

namespace App\Filament\Resources\Children\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;

class ChildrenTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('full_name')
            ->columns([
                ImageColumn::make('profile_photo_thumbnail_path')
                    ->label('Photo')
                    ->disk(config('media.disk'))
                    ->square(),
                TextColumn::make('full_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('parent.full_name')
                    ->label('Parent')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('class_name')
                    ->label('Class')
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('class_name')
                    ->label('Class')
                    ->options(fn (): array => Cache::remember(
                        'admin.children.class_names',
                        now()->addHour(),
                        fn (): array => \App\Models\Child::query()
                            ->whereNotNull('class_name')
                            ->distinct()
                            ->orderBy('class_name')
                            ->pluck('class_name', 'class_name')
                            ->all()
                    )),
                TernaryFilter::make('is_active')->label('Active'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
