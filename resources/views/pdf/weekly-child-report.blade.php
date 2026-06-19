<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Weekly Report — {{ $report->child?->full_name }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #2D3436;
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
            padding: 24px;
        }
        .header {
            border-bottom: 4px solid #FFD166;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        .brand {
            font-size: 24px;
            font-weight: bold;
            color: #2EC4B6;
            margin: 0;
        }
        .subtitle {
            color: #636e72;
            margin-top: 4px;
        }
        .umbrella {
            margin-top: 8px;
            height: 8px;
            background: linear-gradient(to right, #FFD166, #2EC4B6, #E76F51, #FFB4A2);
        }
        h2 {
            color: #2EC4B6;
            font-size: 16px;
            margin: 18px 0 8px;
            border-bottom: 1px solid #dfe6e9;
            padding-bottom: 4px;
        }
        .meta-table, .status-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .meta-table td {
            padding: 6px 8px;
            vertical-align: top;
        }
        .meta-table td.label {
            width: 28%;
            font-weight: bold;
            color: #2D3436;
        }
        .status-table th, .status-table td {
            border: 1px solid #dfe6e9;
            padding: 8px;
            text-align: left;
        }
        .status-table th {
            background: #FFF9F0;
            color: #2D3436;
        }
        .notes {
            background: #FFF9F0;
            border-left: 4px solid #E76F51;
            padding: 10px 12px;
            margin-bottom: 10px;
            white-space: pre-wrap;
        }
        .footer {
            margin-top: 28px;
            padding-top: 12px;
            border-top: 2px solid #FFD166;
            font-size: 11px;
            color: #636e72;
            text-align: center;
        }
        .footer strong {
            color: #2D3436;
        }
    </style>
</head>
<body>
    <div class="header">
        <p class="brand">☂️ Teatrino Nursery</p>
        <p class="subtitle">Weekly Child Progress Report</p>
        <div class="umbrella"></div>
    </div>

    <table class="meta-table">
        <tr>
            <td class="label">Child</td>
            <td>{{ $report->child?->full_name }}</td>
            <td class="label">Class</td>
            <td>{{ $report->child?->class_name ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Parent</td>
            <td>{{ $report->parent?->full_name }}</td>
            <td class="label">Week</td>
            <td>{{ $report->week_range_label }}</td>
        </tr>
    </table>

    <h2>Weekly Overview</h2>
    <table class="status-table">
        <thead>
            <tr>
                <th>Area</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ([
                'Eating' => $report->eating_status,
                'Sleeping' => $report->sleeping_status,
                'Learning' => $report->learning_status,
                'Playing' => $report->playing_status,
                'Behavior' => $report->behavior_status,
                'Mood' => $report->mood_status,
            ] as $label => $value)
                <tr>
                    <td>{{ $label }}</td>
                    <td>{{ $value ?: '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($report->activities_summary)
        <h2>Activities Summary</h2>
        <div class="notes">{{ $report->activities_summary }}</div>
    @endif

    @if ($report->teacher_notes)
        <h2>Teacher Notes</h2>
        <div class="notes">{{ $report->teacher_notes }}</div>
    @endif

    @if ($report->health_notes)
        <h2>Health Notes</h2>
        <div class="notes">{{ $report->health_notes }}</div>
    @endif

    @if ($report->recommendations)
        <h2>Recommendations</h2>
        <div class="notes">{{ $report->recommendations }}</div>
    @endif

    <div class="footer">
        <strong>Teatrino Nursery</strong><br>
        @if ($whatsappNumber)
            WhatsApp: {{ $whatsappNumber }}
        @endif
        <br>
        Generated on {{ now()->format('M j, Y') }}
    </div>
</body>
</html>
