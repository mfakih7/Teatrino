<?php

namespace App\Filament\Widgets;

use App\Enums\PaymentStatus;
use App\Models\ChildPayment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PaymentStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $month = now()->month;
        $year = now()->year;

        $stats = ChildPayment::query()
            ->selectRaw('SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as pending_count', [PaymentStatus::Pending->value])
            ->selectRaw('SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as overdue_count', [PaymentStatus::Overdue->value])
            ->selectRaw(
                'SUM(CASE WHEN month = ? AND year = ? AND status = ? THEN 1 ELSE 0 END) as paid_this_month',
                [$month, $year, PaymentStatus::Paid->value]
            )
            ->selectRaw(
                'SUM(CASE WHEN month = ? AND year = ? AND status IN (?, ?) THEN amount ELSE 0 END) as unpaid_amount',
                [$month, $year, PaymentStatus::Pending->value, PaymentStatus::Overdue->value]
            )
            ->first();

        return [
            Stat::make('Pending Payments', (int) ($stats->pending_count ?? 0))
                ->description('Awaiting payment')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Overdue Payments', (int) ($stats->overdue_count ?? 0))
                ->description('Needs follow-up')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
            Stat::make('Paid This Month', (int) ($stats->paid_this_month ?? 0))
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Unpaid Amount (This Month)', number_format((float) ($stats->unpaid_amount ?? 0), 2).' USD')
                ->description('Pending + overdue')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('danger'),
        ];
    }
}
