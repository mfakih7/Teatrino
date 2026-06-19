<?php

namespace App\Filament\Resources\ChildWeeklyReports\Pages;

use App\Filament\Resources\ChildWeeklyReports\ChildWeeklyReportResource;
use App\Models\Child;
use App\Models\ChildWeeklyReport;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateChildWeeklyReport extends CreateRecord
{
    protected static string $resource = ChildWeeklyReportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! empty($data['child_id']) && empty($data['parent_id'])) {
            $data['parent_id'] = Child::query()->find($data['child_id'])?->parent_id;
        }

        $this->ensureUniquePeriod($data);

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function ensureUniquePeriod(array $data, ?int $ignoreId = null): void
    {
        $exists = ChildWeeklyReport::query()
            ->where('child_id', $data['child_id'] ?? null)
            ->whereDate('week_start_date', $data['week_start_date'] ?? null)
            ->whereDate('week_end_date', $data['week_end_date'] ?? null)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'child_id' => 'A weekly report for this child and week range already exists.',
            ]);
        }
    }
}
