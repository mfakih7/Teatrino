<?php

namespace Database\Seeders;

use App\Enums\PaymentStatus;
use App\Models\Child;
use App\Models\ChildPayment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $children = Child::query()->with('parent')->get();

        if ($children->isEmpty()) {
            return;
        }

        $periods = [
            ['month' => now()->month, 'year' => now()->year],
            ['month' => now()->subMonth()->month, 'year' => now()->subMonth()->year],
        ];

        $statuses = [
            PaymentStatus::Paid,
            PaymentStatus::Pending,
            PaymentStatus::Overdue,
            PaymentStatus::Paid,
            PaymentStatus::Pending,
        ];

        $index = 0;

        foreach ($children as $child) {
            foreach ($periods as $period) {
                $status = $statuses[$index % count($statuses)];
                $index++;

                $dueDate = Carbon::createFromDate($period['year'], $period['month'], 5);
                $paidAt = $status === PaymentStatus::Paid ? $dueDate->copy()->addDays(2) : null;

                ChildPayment::query()->updateOrCreate(
                    [
                        'child_id' => $child->id,
                        'month' => $period['month'],
                        'year' => $period['year'],
                    ],
                    [
                        'parent_id' => $child->parent_id,
                        'amount' => 150.00,
                        'currency' => 'USD',
                        'status' => $status,
                        'due_date' => $dueDate,
                        'paid_at' => $paidAt,
                        'payment_method' => $status === PaymentStatus::Paid ? 'cash' : null,
                        'notes' => $status === PaymentStatus::Overdue
                            ? 'Reminder sent — payment overdue.'
                            : null,
                    ]
                );
            }
        }
    }
}
