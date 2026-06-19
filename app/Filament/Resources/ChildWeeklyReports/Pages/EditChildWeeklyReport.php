<?php

namespace App\Filament\Resources\ChildWeeklyReports\Pages;

use App\Filament\Resources\ChildWeeklyReports\ChildWeeklyReportResource;
use App\Models\ChildWeeklyReport;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditChildWeeklyReport extends EditRecord
{
    protected static string $resource = ChildWeeklyReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->ensureUniquePeriod($data, $this->record->getKey());

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
