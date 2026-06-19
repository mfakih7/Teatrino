<?php

namespace App\Filament\Widgets;

use App\Models\Child;
use App\Models\NurseryParent;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class NurseryStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $parentStats = NurseryParent::query()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active')
            ->first();

        $childStats = Child::query()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active')
            ->first();

        return [
            Stat::make('Total Parents', (int) ($parentStats->total ?? 0))
                ->description('Registered families')
                ->color('primary'),
            Stat::make('Active Parents', (int) ($parentStats->active ?? 0))
                ->description('Currently active')
                ->color('success'),
            Stat::make('Total Children', (int) ($childStats->total ?? 0))
                ->description('Enrolled children')
                ->color('warning'),
            Stat::make('Active Children', (int) ($childStats->active ?? 0))
                ->description('Currently enrolled')
                ->color('success'),
        ];
    }
}
