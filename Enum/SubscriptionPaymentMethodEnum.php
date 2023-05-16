<?php

namespace App\Enum;

use ObiPlus\ObiPlus\Enums\Enum;

/**
 * @method static self online()
 * @method static self cash()
 * @method static self transfer()
 */
final class SubscriptionPaymentMethodEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'online' => 0,
            'cash' => 1,
            'transfer' => 2,
        ];
    }

    protected static function labels(): array
    {
        return [
            'online' => 'Online',
            'cash' => 'Nakit',
            'transfer' => 'Havale',
        ];
    }
}
