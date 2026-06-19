<?php

namespace App\Filament\Resources\ChildPayments\Pages;

use App\Filament\Resources\ChildPayments\ChildPaymentResource;
use App\Models\Child;
use App\Models\ChildPayment;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateChildPayment extends CreateRecord
{
    protected static string $resource = ChildPaymentResource::class;

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
