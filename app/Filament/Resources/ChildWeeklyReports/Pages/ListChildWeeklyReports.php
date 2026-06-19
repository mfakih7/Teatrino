<?php

namespace App\Filament\Resources\ChildWeeklyReports\Pages;

use App\Filament\Resources\ChildWeeklyReports\ChildWeeklyReportResource;
use App\Models\ChildWeeklyReport;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChildWeeklyReports extends ListRecords
{
    protected static string $resource = ChildWeeklyReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
