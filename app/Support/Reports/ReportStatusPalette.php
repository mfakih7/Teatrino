<?php

namespace App\Support\Reports;

class ReportStatusPalette
{
    /**
     * @return array{label: string, bg: string, color: string, border: string, dot: string}
     */
    public static function for(?string $status): array
    {
        $label = filled($status) ? $status : '—';
        $normalized = strtolower(trim((string) $status));

        return match (true) {
            in_array($normalized, ['excellent', 'outstanding', 'great'], true) => [
                'label' => $label,
                'bg' => '#E8F8F5',
                'color' => '#1B7F74',
                'border' => '#2EC4B6',
                'dot' => '#2EC4B6',
            ],
            in_array($normalized, ['good', 'happy', 'well', 'positive'], true) => [
                'label' => $label,
                'bg' => '#EAF4FF',
                'color' => '#1F5F99',
                'border' => '#5B9BD5',
                'dot' => '#5B9BD5',
            ],
            in_array($normalized, ['fair', 'average', 'ok', 'moderate'], true) => [
                'label' => $label,
                'bg' => '#FFF4E5',
                'color' => '#B35C00',
                'border' => '#F4A261',
                'dot' => '#F4A261',
            ],
            str_contains($normalized, 'attention')
                || in_array($normalized, ['poor', 'low', 'concern', 'needs help'], true) => [
                'label' => $label,
                'bg' => '#FDECEC',
                'color' => '#B42318',
                'border' => '#E76F51',
                'dot' => '#E76F51',
            ],
            default => [
                'label' => $label,
                'bg' => '#F4F5F6',
                'color' => '#636E72',
                'border' => '#DFE6E9',
                'dot' => '#B2BEC3',
            ],
        };
    }

    /**
     * @return array<string, string>
     */
    public static function areaIcons(): array
    {
        return [
            'Eating' => 'E',
            'Sleeping' => 'S',
            'Learning' => 'L',
            'Playing' => 'P',
            'Behavior' => 'B',
            'Mood' => 'M',
        ];
    }

    /**
     * @return array<string, array{icon: string, title: string, accent: string, bg: string}>
     */
    public static function sections(): array
    {
        return [
            'activities_summary' => [
                'icon' => 'A',
                'title' => 'Activities Summary',
                'accent' => '#2EC4B6',
                'bg' => '#F0FBFA',
            ],
            'teacher_notes' => [
                'icon' => 'T',
                'title' => 'Teacher Notes',
                'accent' => '#E76F51',
                'bg' => '#FFF5F2',
            ],
            'health_notes' => [
                'icon' => 'H',
                'title' => 'Health Notes',
                'accent' => '#5B9BD5',
                'bg' => '#F2F8FF',
            ],
            'recommendations' => [
                'icon' => 'R',
                'title' => 'Recommendations',
                'accent' => '#FFD166',
                'bg' => '#FFFBF0',
            ],
        ];
    }
}
