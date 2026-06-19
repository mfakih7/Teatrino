<?php

namespace Database\Seeders;

use App\Models\Child;
use App\Models\ChildWeeklyReport;
use App\Support\Reports\WeeklyReportPdfGenerator;
use Illuminate\Database\Seeder;

class WeeklyReportSeeder extends Seeder
{
    public function run(): void
    {
        $children = Child::query()->with('parent')->get();

        if ($children->isEmpty()) {
            return;
        }

        $weekStart = now()->startOfWeek()->toDateString();
        $weekEnd = now()->endOfWeek()->toDateString();
        $generator = app(WeeklyReportPdfGenerator::class);

        foreach ($children as $index => $child) {
            $report = ChildWeeklyReport::query()->updateOrCreate(
                [
                    'child_id' => $child->id,
                    'week_start_date' => $weekStart,
                    'week_end_date' => $weekEnd,
                ],
                [
                    'parent_id' => $child->parent_id,
                    'eating_status' => 'Good',
                    'sleeping_status' => 'Good',
                    'learning_status' => 'Excellent',
                    'playing_status' => 'Excellent',
                    'behavior_status' => 'Good',
                    'mood_status' => 'Happy',
                    'teacher_notes' => 'A joyful week with creative play and gentle routines.',
                    'health_notes' => $child->allergies ? 'Allergies noted: '.$child->allergies : null,
                    'activities_summary' => 'Art time, outdoor play, story circle, and music movement.',
                    'recommendations' => 'Continue reading together at home before bedtime.',
                ]
            );

            if ($index % 2 === 0) {
                $generator->generate($report);
            }
        }
    }
}
