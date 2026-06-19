<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class ChildPayment extends Model
{
    protected $fillable = [
        'child_id',
        'parent_id',
        'month',
        'year',
        'amount',
        'currency',
        'status',
        'due_date',
        'paid_at',
        'payment_method',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'month' => 'integer',
            'year' => 'integer',
            'amount' => 'decimal:2',
            'status' => PaymentStatus::class,
            'due_date' => 'date',
            'paid_at' => 'datetime',
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

    public function getPeriodLabelAttribute(): string
    {
        return Carbon::createFromDate($this->year, $this->month, 1)->format('F Y');
    }

    public function isUnpaid(): bool
    {
        return in_array($this->status, [PaymentStatus::Pending, PaymentStatus::Overdue], true);
    }

    public function markAsPaid(?string $paymentMethod = null): void
    {
        $this->update([
            'status' => PaymentStatus::Paid,
            'paid_at' => now(),
            'payment_method' => $paymentMethod ?? $this->payment_method,
        ]);
    }

    public function markAsOverdue(): void
    {
        $this->update([
            'status' => PaymentStatus::Overdue,
        ]);
    }

    public function scopeForPeriod(Builder $query, int $month, int $year): Builder
    {
        return $query->where('month', $month)->where('year', $year);
    }

    public function scopeCurrentMonth(Builder $query): Builder
    {
        return $query->forPeriod(now()->month, now()->year);
    }

    public function scopeUnpaid(Builder $query): Builder
    {
        return $query->whereIn('status', PaymentStatus::unpaidValues());
    }
}
