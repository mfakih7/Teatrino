<?php

namespace App\Filament\Support;

class ReportStatusOptions
{
    /**
     * @return array<string, string>
     */
    public static function all(): array
    {
        return [
            'Excellent' => 'Excellent',
            'Good' => 'Good',
            'Fair' => 'Fair',
            'Needs attention' => 'Needs attention',
        ];
    }
}
