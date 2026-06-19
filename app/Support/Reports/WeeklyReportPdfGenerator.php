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

        $pdf = Pdf::loadView('pdf.weekly-child-report', $this->viewData($report))
            ->setPaper('a4');

        Storage::disk('public')->put($filename, $pdf->output());

        $report->update(['pdf_path' => $filename]);

        return $filename;
    }

    /**
     * @return array<string, mixed>
     */
    public function viewData(ChildWeeklyReport $report): array
    {
        $settings = SiteSetting::cached();
        $mediaDisk = config('media.disk');
        $child = $report->child;

        $logoDataUri = PdfInlineImage::fromStorage('public', $settings->logo_path)
            ?? PdfInlineImage::fromPath(public_path('favicon.svg'));

        $childPhotoDataUri = null;

        if ($child) {
            $photoPath = $child->profile_photo_thumbnail_path
                ?? $child->profile_photo_optimized_path
                ?? $child->profile_photo_original_path;

            $childPhotoDataUri = PdfInlineImage::fromStorage($mediaDisk, $photoPath);
        }

        $childInitials = collect(explode(' ', (string) $child?->full_name))
            ->filter()
            ->take(2)
            ->map(fn (string $part) => Str::upper(Str::substr($part, 0, 1)))
            ->implode('');

        $overviewAreas = [
            'Eating' => $report->eating_status,
            'Sleeping' => $report->sleeping_status,
            'Learning' => $report->learning_status,
            'Playing' => $report->playing_status,
            'Behavior' => $report->behavior_status,
            'Mood' => $report->mood_status,
        ];

        $overviewCards = collect($overviewAreas)
            ->map(fn (?string $status, string $area) => [
                'area' => $area,
                'icon' => ReportStatusPalette::areaIcons()[$area] ?? Str::upper(Str::substr($area, 0, 1)),
                'status' => ReportStatusPalette::for($status),
            ])
            ->values()
            ->all();

        $sections = collect(ReportStatusPalette::sections())
            ->map(fn (array $meta, string $field) => [
                ...$meta,
                'field' => $field,
                'content' => $report->{$field},
            ])
            ->filter(fn (array $section) => filled($section['content']))
            ->values()
            ->all();

        return [
            'report' => $report,
            'settings' => $settings,
            'nurseryName' => $settings->t('website_name') ?: 'Teatrino Nursery',
            'logoDataUri' => $logoDataUri,
            'childPhotoDataUri' => $childPhotoDataUri,
            'childInitials' => $childInitials ?: '?',
            'whatsappNumber' => $settings->whatsapp_number ?: config('site.whatsapp_number'),
            'overviewCards' => $overviewCards,
            'sections' => $sections,
        ];
    }

    public function downloadFilename(ChildWeeklyReport $report): string
    {
        $childSlug = Str::slug($report->child?->full_name ?? 'child');

        return "teatrino-weekly-report-{$childSlug}-{$report->week_start_date->format('Y-m-d')}.pdf";
    }
}
