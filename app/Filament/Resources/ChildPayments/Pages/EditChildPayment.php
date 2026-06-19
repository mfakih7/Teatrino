<?php

namespace App\Filament\Resources\ChildPayments\Pages;

use App\Filament\Resources\ChildPayments\ChildPaymentResource;
use App\Models\ChildPayment;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditChildPayment extends EditRecord
{
    protected static string $resource = ChildPaymentResource::class;

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
        $exists = ChildPayment::query()
            ->where('child_id', $data['child_id'] ?? null)
            ->where('month', $data['month'] ?? null)
            ->where('year', $data['year'] ?? null)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'child_id' => 'A payment for this child already exists for the selected month and year.',
            ]);
        }
    }
}
