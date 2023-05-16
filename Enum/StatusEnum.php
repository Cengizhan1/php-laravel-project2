<?php

namespace App\Enum;

use ObiPlus\ObiPlus\Enums\Enum;

/**
 * @method static self active()
 * @method static self passive()
 * @method static self no_package()
 */
final class StatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'active' => 0,
            'passive' => 1,
            'no_package' => 2,
        ];
    }

    protected static function labels(): array
    {
        return [
            'active' => 'Aktif',
            'passive' => 'Pasif',
            'no_package' => 'Paket yok',
        ];
    }
}
