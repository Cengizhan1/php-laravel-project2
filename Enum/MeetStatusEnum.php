<?php

namespace App\Enum;

use ObiPlus\ObiPlus\Enums\Enum;

/**
 * @method static self active()
 * @method static self completed()
 * @method static self pendingAssignment()
 */
final class MeetStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'active' => 0,
            'completed' => 1,
            'pendingAssignment' => 2,
        ];
    }

    protected static function labels(): array
    {
        return [
            'active' => 'Aktif',
            'completed' => 'Tamamlandı',
            'pendingAssignment' => 'Atama Bekleyen',
        ];
    }
}
