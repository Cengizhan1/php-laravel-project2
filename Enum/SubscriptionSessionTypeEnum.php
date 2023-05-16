<?php

namespace App\Enum;

use ObiPlus\ObiPlus\Enums\Enum;

/**
 * @method static self faceToFace()
 * @method static self onlineDiet()
 * @method static self onlyDiet()
 */
final class SubscriptionSessionTypeEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'faceToFace' => 0,
            'onlineDiet' => 1,
            'onlyDiet' => 2,
        ];
    }

    protected static function labels(): array
    {
        return [
            'faceToFace' => 'Face to Face',
            'onlineDiet' => 'Online Diet',
            'onlyDiet' => 'Just Diet',
        ];
    }
}
