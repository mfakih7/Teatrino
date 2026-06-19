<?php

namespace App\Filament\Widgets;

use App\Models\ChildWeeklyReport;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WeeklyReportStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 3;

    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();

        $stats = ChildWeeklyReport::query()
            ->selectRaw('SUM(CASE WHEN created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) as created_this_week', [$weekStart, $weekEnd])
            ->selectRaw('SUM(CASE WHEN pdf_path IS NULL THEN 1 ELSE 0 END) as pending_pdf')
            ->selectRaw('SUM(CASE WHEN sent_at BETWEEN ? AND ? THEN 1 ELSE 0 END) as sent_this_week', [$weekStart, $weekEnd])
            ->first();

        return [
            Stat::make('Reports This Week', (int) ($stats->created_this_week ?? 0))
                ->description('Created this week')
                ->color('primary'),
            Stat::make('Pending PDF', (int) ($stats->pending_pdf ?? 0))
                ->description('Needs PDF generation')
                ->color('warning'),
            Stat::make('Sent This Week', (int) ($stats->sent_this_week ?? 0))
                ->description('WhatsApp handoff marked')
                ->color('success'),
        ];
    }
}
