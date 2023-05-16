<?php

namespace App\Enum;

use ObiPlus\ObiPlus\Enums\Enum;

/**
 * @method static self aplus()
 * @method static self aminus()
 * @method static self bplus()
 * @method static self bminus()
 * @method static self abplus()
 * @method static self abminus()
 * @method static self oplus()
 * @method static self ominus()
 */
final class BloodGroupEnum extends Enum
{
    protected static function values(): array
    {
        return [
            '0+' => 0,
            '0-' => 1,
            'A+' => 2,
            'A-' => 3,
            'B+' => 5,
            'B-' => 5,
            'AB+' => 6,
            'AB-' => 7,
        ];
    }

    protected static function labels(): array
    {
        return [
            '0+' => '0+',
            '0-' => '0-',
            'A+' => 'A+',
            'A-' => 'A-',
            'B+' => 'B+',
            'B-' => 'B-',
            'AB+' => 'AB+',
            'AB-' => 'AB-',
        ];
    }
}
