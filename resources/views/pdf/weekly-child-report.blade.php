<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Weekly Report — {{ $report->child?->full_name }}</title>
    <style>
        @page {
            margin: 28px 32px 72px 32px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #2D3436;
            font-size: 11px;
            line-height: 1.55;
            margin: 0;
            padding: 0;
            background: #FFFFFF;
        }

        table {
            border-collapse: collapse;
        }

        .page-shell {
            width: 100%;
        }

        /* ── Header ── */
        .report-header {
            width: 100%;
            margin-bottom: 18px;
            border: 1px solid #E8ECEF;
            border-radius: 16px;
            overflow: hidden;
            background: #FFF9F0;
        }

        .report-header-top {
            background: #2EC4B6;
            color: #FFFFFF;
            padding: 14px 18px 12px;
        }

        .report-header-top td {
            vertical-align: middle;
        }

        .logo-wrap {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            background: #FFFFFF;
            text-align: center;
            vertical-align: middle;
            overflow: hidden;
        }

        .logo-wrap img {
            width: 52px;
            height: 52px;
            object-fit: contain;
        }

        .brand-title {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
            color: #FFFFFF;
            letter-spacing: -0.02em;
        }

        .brand-subtitle {
            margin: 4px 0 0;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.92);
            font-weight: normal;
        }

        .child-photo-wrap {
            width: 72px;
            height: 72px;
            border-radius: 36px;
            border: 3px solid rgba(255, 255, 255, 0.85);
            overflow: hidden;
            background: #FFFFFF;
            text-align: center;
        }

        .child-photo-wrap img {
            width: 72px;
            height: 72px;
            object-fit: cover;
        }

        .child-initials {
            width: 72px;
            height: 72px;
            line-height: 72px;
            font-size: 22px;
            font-weight: bold;
            color: #2EC4B6;
            text-align: center;
        }

        .rainbow-bar td {
            height: 5px;
            padding: 0;
            font-size: 0;
            line-height: 0;
        }

        .rainbow-yellow { background: #FFD166; width: 25%; }
        .rainbow-teal { background: #2EC4B6; width: 25%; }
        .rainbow-coral { background: #E76F51; width: 25%; }
        .rainbow-pink { background: #FFB4A2; width: 25%; }

        .report-header-body {
            padding: 16px 18px 14px;
        }

        .child-hero-name {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            color: #2D3436;
        }

        .child-hero-meta {
            margin: 4px 0 0;
            color: #636E72;
            font-size: 10.5px;
        }

        /* ── Summary cards ── */
        .summary-grid {
            width: 100%;
            margin-bottom: 16px;
            border-spacing: 10px 0;
        }

        .summary-card {
            width: 25%;
            border: 1px solid #E8ECEF;
            border-radius: 14px;
            background: #FFFFFF;
            padding: 12px 12px 11px;
            vertical-align: top;
            page-break-inside: avoid;
        }

        .summary-label {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #2EC4B6;
            margin: 0 0 6px;
        }

        .summary-value {
            font-size: 12px;
            font-weight: bold;
            color: #2D3436;
            margin: 0;
            line-height: 1.35;
        }

        .summary-subvalue {
            font-size: 10px;
            color: #636E72;
            margin: 3px 0 0;
        }

        /* ── Section headings ── */
        .section-heading {
            margin: 0 0 10px;
            page-break-after: avoid;
        }

        .section-heading-title {
            font-size: 14px;
            font-weight: bold;
            color: #2D3436;
            margin: 0;
        }

        .section-heading-subtitle {
            font-size: 10px;
            color: #636E72;
            margin: 3px 0 0;
        }

        /* ── Status cards ── */
        .status-grid {
            width: 100%;
            margin-bottom: 18px;
            border-spacing: 8px 8px;
        }

        .status-card {
            width: 33.33%;
            border: 1px solid #E8ECEF;
            border-radius: 14px;
            background: #FFFFFF;
            padding: 11px 12px 10px;
            vertical-align: top;
            page-break-inside: avoid;
        }

        .status-card-top {
            width: 100%;
            margin-bottom: 8px;
        }

        .status-icon {
            width: 24px;
            height: 24px;
            border-radius: 8px;
            background: #FFF9F0;
            color: #2EC4B6;
            font-size: 11px;
            font-weight: bold;
            text-align: center;
            line-height: 24px;
            display: inline-block;
        }

        .status-area {
            font-size: 11px;
            font-weight: bold;
            color: #2D3436;
            margin: 0;
        }

        .status-badge {
            display: inline-block;
            margin-top: 2px;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: bold;
            line-height: 1.2;
            border: 1px solid transparent;
        }

        /* ── Content sections ── */
        .content-section {
            width: 100%;
            margin-bottom: 12px;
            border: 1px solid #E8ECEF;
            border-radius: 16px;
            overflow: hidden;
            page-break-inside: auto;
        }

        .content-section-header {
            padding: 11px 14px;
            border-bottom: 1px solid rgba(45, 52, 54, 0.06);
        }

        .content-section-icon {
            width: 28px;
            height: 28px;
            border-radius: 10px;
            color: #FFFFFF;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            line-height: 28px;
            display: inline-block;
        }

        .content-section-title {
            font-size: 12px;
            font-weight: bold;
            color: #2D3436;
            margin: 0;
        }

        .content-section-body {
            padding: 12px 14px 14px;
            font-size: 11px;
            line-height: 1.65;
            color: #4A5560;
            white-space: pre-wrap;
        }

        /* ── Footer ── */
        .report-footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: -52px;
            height: 52px;
            border-top: 2px solid #FFD166;
            padding-top: 10px;
            font-size: 9.5px;
            color: #636E72;
        }

        .footer-brand {
            font-size: 11px;
            font-weight: bold;
            color: #2D3436;
            margin: 0 0 2px;
        }

        .footer-contact {
            margin: 0;
            line-height: 1.45;
        }

        .footer-page {
            text-align: right;
            font-size: 9px;
            color: #95A5A6;
        }

        .spacer-sm { height: 6px; }
        .spacer-md { height: 12px; }
    </style>
</head>
<body>
    <div class="page-shell">
        {{-- Premium header --}}
        <table class="report-header" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="3" style="padding: 0;">
                    <table width="100%" cellpadding="0" cellspacing="0" class="report-header-top">
                        <tr>
                            <td width="68" style="padding-right: 12px;">
                                @if ($logoDataUri)
                                    <div class="logo-wrap">
                                        <img src="{{ $logoDataUri }}" alt="{{ $nurseryName }}">
                                    </div>
                                @endif
                            </td>
                            <td>
                                <p class="brand-title">{{ $nurseryName }}</p>
                                <p class="brand-subtitle">Weekly Child Progress Report</p>
                            </td>
                            <td width="84" align="right">
                                @if ($childPhotoDataUri)
                                    <div class="child-photo-wrap">
                                        <img src="{{ $childPhotoDataUri }}" alt="{{ $report->child?->full_name }}">
                                    </div>
                                @elseif ($report->child?->full_name)
                                    <div class="child-photo-wrap">
                                        <div class="child-initials">{{ $childInitials }}</div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding: 0;">
                    <table width="100%" cellpadding="0" cellspacing="0" class="rainbow-bar">
                        <tr>
                            <td class="rainbow-yellow"></td>
                            <td class="rainbow-teal"></td>
                            <td class="rainbow-coral"></td>
                            <td class="rainbow-pink"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="report-header-body">
                    <p class="child-hero-name">{{ $report->child?->full_name }}</p>
                    <p class="child-hero-meta">
                        {{ $report->week_range_label }}
                        @if ($report->child?->class_name)
                            &nbsp;•&nbsp; {{ $report->child->class_name }}
                        @endif
                    </p>
                </td>
            </tr>
        </table>

        {{-- Summary cards --}}
        <table class="summary-grid" cellpadding="0" cellspacing="0">
            <tr>
                <td class="summary-card">
                    <p class="summary-label">Child</p>
                    <p class="summary-value">{{ $report->child?->full_name ?: '—' }}</p>
                </td>
                <td class="summary-card">
                    <p class="summary-label">Parent</p>
                    <p class="summary-value">{{ $report->parent?->full_name ?: '—' }}</p>
                </td>
                <td class="summary-card">
                    <p class="summary-label">Class</p>
                    <p class="summary-value">{{ $report->child?->class_name ?: '—' }}</p>
                </td>
                <td class="summary-card">
                    <p class="summary-label">Week</p>
                    <p class="summary-value">{{ $report->week_start_date->format('M j') }} – {{ $report->week_end_date->format('M j, Y') }}</p>
                    <p class="summary-subvalue">Reporting period</p>
                </td>
            </tr>
        </table>

        {{-- Weekly overview --}}
        <div class="section-heading">
            <p class="section-heading-title">Weekly Overview</p>
            <p class="section-heading-subtitle">A snapshot of your child's week at nursery</p>
        </div>

        @foreach (array_chunk($overviewCards, 3) as $row)
            <table class="status-grid" cellpadding="0" cellspacing="0">
                <tr>
                    @foreach ($row as $card)
                        <td class="status-card">
                            <table width="100%" cellpadding="0" cellspacing="0" class="status-card-top">
                                <tr>
                                    <td width="30" style="vertical-align: top;">
                                        <span class="status-icon">{{ $card['icon'] }}</span>
                                    </td>
                                    <td style="vertical-align: top;">
                                        <p class="status-area">{{ $card['area'] }}</p>
                                    </td>
                                </tr>
                            </table>
                            <span
                                class="status-badge"
                                style="background: {{ $card['status']['bg'] }}; color: {{ $card['status']['color'] }}; border-color: {{ $card['status']['border'] }};"
                            >
                                {{ $card['status']['label'] }}
                            </span>
                        </td>
                    @endforeach
                    @for ($i = count($row); $i < 3; $i++)
                        <td style="width: 33.33%;"></td>
                    @endfor
                </tr>
            </table>
        @endforeach

        <div class="spacer-md"></div>

        {{-- Narrative sections --}}
        @if (count($sections))
            <div class="section-heading">
                <p class="section-heading-title">Teacher Insights</p>
                <p class="section-heading-subtitle">Highlights, observations, and gentle guidance for home</p>
            </div>
        @endif

        @foreach ($sections as $section)
            <table class="content-section" cellpadding="0" cellspacing="0" style="background: {{ $section['bg'] }};">
                <tr>
                    <td class="content-section-header">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="36" style="vertical-align: middle;">
                                    <span class="content-section-icon" style="background: {{ $section['accent'] }};">
                                        {{ $section['icon'] }}
                                    </span>
                                </td>
                                <td style="vertical-align: middle;">
                                    <p class="content-section-title">{{ $section['title'] }}</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="content-section-body">{{ $section['content'] }}</td>
                </tr>
            </table>
        @endforeach

        @if (! count($sections))
            <table width="100%" cellpadding="0" cellspacing="0" style="border: 1px dashed #DFE6E9; border-radius: 14px; background: #FFF9F0;">
                <tr>
                    <td style="padding: 18px; text-align: center; color: #636E72; font-size: 11px;">
                        Additional teacher notes will appear here when provided.
                    </td>
                </tr>
            </table>
        @endif
    </div>

    {{-- Footer --}}
    <div class="report-footer">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="70%">
                    <p class="footer-brand">{{ $nurseryName }}</p>
                    <p class="footer-contact">
                        @if ($settings->email)
                            {{ $settings->email }}
                        @endif
                        @if ($settings->email && $whatsappNumber)
                            &nbsp;•&nbsp;
                        @endif
                        @if ($whatsappNumber)
                            WhatsApp: {{ $whatsappNumber }}
                        @endif
                    </p>
                    <p class="footer-contact" style="margin-top: 2px;">
                        Generated {{ now()->format('M j, Y') }}
                    </p>
                </td>
                <td class="footer-page" width="30%">
                    <script type="text/php">
                        if (isset($pdf)) {
                            $text = 'Page {PAGE_NUM} of {PAGE_COUNT}';
                            $font = $fontMetrics->getFont('DejaVu Sans');
                            $size = 9;
                            $color = [0.58, 0.65, 0.65];
                            $width = $fontMetrics->getTextWidth($text, $font, $size);
                            $x = $pdf->get_width() - $width - 36;
                            $y = $pdf->get_height() - 42;
                            $pdf->page_text($x, $y, $text, $font, $size, $color);
                        }
                    </script>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
