<?php

namespace App\Filament\Resources\NurseryParents\Pages;

use App\Filament\Resources\NurseryParents\NurseryParentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNurseryParents extends ListRecords
{
    protected static string $resource = NurseryParentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
