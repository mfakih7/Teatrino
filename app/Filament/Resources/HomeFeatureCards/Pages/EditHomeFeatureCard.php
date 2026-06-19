<?php

namespace App\Filament\Resources\HomeFeatureCards\Pages;

use App\Filament\Resources\HomeFeatureCards\HomeFeatureCardResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHomeFeatureCard extends EditRecord
{
    protected static string $resource = HomeFeatureCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
