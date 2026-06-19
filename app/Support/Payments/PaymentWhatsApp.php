<?php

namespace App\Support\Payments;

use App\Models\ChildPayment;

class PaymentWhatsApp
{
    public static function reminderUrl(ChildPayment $payment): ?string
    {
        $parent = $payment->parent;

        if (! $parent) {
            return null;
        }

        $number = $parent->whatsapp_number ?: $parent->phone_number;

        if (! $number) {
            return null;
        }

        $message = sprintf(
            'Hello %s, this is Teatrino Nursery. Kindly note that the payment for %s for %s is still pending. Amount: %s %s. Thank you.',
            $parent->full_name,
            $payment->child?->full_name ?? 'your child',
            $payment->period_label,
            number_format((float) $payment->amount, 2),
            $payment->currency
        );

        return 'https://wa.me/'.preg_replace('/\D+/', '', $number).'?text='.urlencode($message);
    }
}
