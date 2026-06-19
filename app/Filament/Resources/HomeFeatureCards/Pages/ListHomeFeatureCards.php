<?php

namespace App\Filament\Resources\HomeFeatureCards\Pages;

use App\Filament\Resources\HomeFeatureCards\HomeFeatureCardResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHomeFeatureCards extends ListRecords
{
    protected static string $resource = HomeFeatureCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
