<?php

namespace App\Enum;

use ObiPlus\ObiPlus\Enums\Enum;

/**
 * @method static self diet()
 * @method static self detox()
 * @method static self faceToFaceDiet()
 */
final class SubscriptionPackageTypeEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'diet' => 0,
            'detox' => 1,
            'faceToFaceDiet' => 2,
        ];
    }

    protected static function labels(): array
    {
        return [
            'diet' => 'Diet',
            'detox' => 'Detox',
            'faceToFaceDiet' => 'Yüz Yüze Diet',
        ];
    }
}
