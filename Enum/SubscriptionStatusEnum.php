<?php

namespace App\Enum;

use ObiPlus\ObiPlus\Enums\Enum;

/**
 * @method static self active()
 * @method static self passive()
 * @method static self stopped()
 * @method static self waitingApproval()
 * @method static self waitingPayment()
 * @method static self paymentDeclined()
 * @method static self waitingAssignment()
 * @method static self completed()
 * @method static self transferDeclined()
 */
final class SubscriptionStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'active' => 0,
            'passive' => 1,
            'stopped' => 2,
            'waitingApproval' => 3,
            'waitingPayment' => 4,
            'paymentDeclined' => 5,
            'waitingAssignment' => 6,
            'completed' => 7,
            'transferDeclined' => 8,
        ];
    }

    protected static function labels(): array
    {
        return [
            'active' => 'Aktif',
            'passive' => 'Pasif',
            'stopped' => 'Durduruldu',
            'waitingApproval' => 'Onay bekliyor',
            'waitingPayment' => 'Ödeme bekliyor',
            'paymentDeclined' => 'Ödeme başarısız',
            'waitingAssignment' => 'Atama bekleniyor',
            'completed' => 'Tamamlandı',
            'transferDeclined' => 'Havale reddedildi',
        ];
    }
}
