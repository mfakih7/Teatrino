<?php

namespace App\Filament\Resources\ChildPayments\Pages;

use App\Filament\Resources\ChildPayments\ChildPaymentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChildPayments extends ListRecords
{
    protected static string $resource = ChildPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
