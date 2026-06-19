<?php

namespace App\Support\Reports;

use App\Models\ChildWeeklyReport;

class ReportWhatsApp
{
    public static function parentUrl(ChildWeeklyReport $report): ?string
    {
        $parent = $report->parent;

        if (! $parent) {
            return null;
        }

        $number = $parent->whatsapp_number ?: $parent->phone_number;

        if (! $number) {
            return null;
        }

        $message = sprintf(
            'Hello %s, this is Teatrino Nursery. The weekly report for %s for %s is ready. We will send the PDF here. Thank you.',
            $parent->full_name,
            $report->child?->full_name ?? 'your child',
            $report->week_range_label
        );

        return 'https://wa.me/'.preg_replace('/\D+/', '', $number).'?text='.urlencode($message);
    }
}
