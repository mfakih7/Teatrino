<?php

namespace App\Filament\Resources\NurseryParents\Pages;

use App\Filament\Resources\NurseryParents\NurseryParentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewNurseryParent extends ViewRecord
{
    protected static string $resource = NurseryParentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
