<?php

namespace App\Enum;

use ObiPlus\ObiPlus\Enums\Enum;

/**
 * @method static self piece()
 * @method static self kilo()
 * @method static self liter()
 * @method static self glass()
 * @method static self grams()
 */
final class UnitEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'piece' => 0,
            'kilo' => 1,
            'liter' => 2,
            'glass' => 3,
            'grams' => 4,
        ];
    }

    protected static function labels(): array
    {
        return [
            'piece' => 'Adet',
            'kilo' => 'Kilo',
            'liter' => 'litre',
            'glass' => 'bardak',
            'grams' => 'gram',
        ];
    }
}
