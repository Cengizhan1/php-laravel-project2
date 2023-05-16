<?php

namespace App\Enum;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self edema_and_bloating()
 * @method static self constipation()
 * @method static self before_menstruation()
 * @method static self after_menstruation()
 */
final class PermissionEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'home' => 0,
            'customers' => 1,
            'diet_detox' => 2,
            'calendar' => 3,
            'message' => 4,
            'package' => 5,
            'finance' => 6,
            'team' => 7,
            'callcenter' => 8,
            'settings' => 9,
        ];
    }

    protected static function labels(): array
    {
        return [
            'home' => 'Home',
            'customers' => 'Customers',
            'diet_detox' => 'Diet & Detox',
            'calendar' => 'Calendar',
            'message' => 'Message',
            'package' => 'Package',
            'finance' => 'Finance',
            'team' => 'Team',
            'callcenter' => 'Callcenter',
            'settings' => 'Settings',

        ];
    }
}
