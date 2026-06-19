<?php

namespace App\Support\Reports;

use App\Models\ChildWeeklyReport;
use App\Models\SiteSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WeeklyReportPdfGenerator
{
    public function generate(ChildWeeklyReport $report): string
    {
        $report->loadMissing(['child', 'parent']);

        if ($report->pdf_path && Storage::disk('public')->exists($report->pdf_path)) {
            Storage::disk('public')->delete($report->pdf_path);
        }

        $directory = 'reports/weekly';
        Storage::disk('public')->makeDirectory($directory);

        $filename = sprintf(
            '%s/child-%d-week-%s.pdf',
            $directory,
            $report->child_id,
            $report->week_start_date->format('Y-m-d')
        );

        $whatsappNumber = SiteSetting::cached()->whatsapp_number ?: config('site.whatsapp_number');

        $pdf = Pdf::loadView('pdf.weekly-child-report', [
            'report' => $report,
            'whatsappNumber' => $whatsappNumber,
        ])->setPaper('a4');

        Storage::disk('public')->put($filename, $pdf->output());

        $report->update(['pdf_path' => $filename]);

        return $filename;
    }

    public function downloadFilename(ChildWeeklyReport $report): string
    {
        $childSlug = Str::slug($report->child?->full_name ?? 'child');

        return "teatrino-weekly-report-{$childSlug}-{$report->week_start_date->format('Y-m-d')}.pdf";
    }
}
