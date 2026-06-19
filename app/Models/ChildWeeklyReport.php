<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ChildWeeklyReport extends Model
{
    protected $fillable = [
        'child_id',
        'parent_id',
        'week_start_date',
        'week_end_date',
        'eating_status',
        'sleeping_status',
        'learning_status',
        'playing_status',
        'behavior_status',
        'mood_status',
        'teacher_notes',
        'health_notes',
        'activities_summary',
        'recommendations',
        'pdf_path',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'week_start_date' => 'date',
            'week_end_date' => 'date',
            'sent_at' => 'datetime',
        ];
    }

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(NurseryParent::class, 'parent_id');
    }

    public function getWeekRangeLabelAttribute(): string
    {
        return sprintf(
            '%s – %s',
            $this->week_start_date->format('M j, Y'),
            $this->week_end_date->format('M j, Y')
        );
    }

    public function getPdfUrlAttribute(): ?string
    {
        if (! $this->pdf_path) {
            return null;
        }

        return Storage::disk('public')->url($this->pdf_path);
    }

    public function hasPdf(): bool
    {
        return filled($this->pdf_path)
            && Storage::disk('public')->exists($this->pdf_path);
    }

    public function scopeCurrentWeek(Builder $query): Builder
    {
        $start = now()->startOfWeek()->toDateString();
        $end = now()->endOfWeek()->toDateString();

        return $query
            ->whereDate('week_start_date', '>=', $start)
            ->whereDate('week_end_date', '<=', $end);
    }

    public function scopeMissingPdf(Builder $query): Builder
    {
        return $query->whereNull('pdf_path');
    }

    protected static function booted(): void
    {
        static::deleting(function (self $report): void {
            if ($report->pdf_path && Storage::disk('public')->exists($report->pdf_path)) {
                Storage::disk('public')->delete($report->pdf_path);
            }
        });
    }
}
