<?php

namespace App\Filament\Resources\NurseryParents\Pages;

use App\Filament\Resources\NurseryParents\NurseryParentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditNurseryParent extends EditRecord
{
    protected static string $resource = NurseryParentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
