<?php

namespace App\Enum;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self face_2_face()
 * @method static self online()
 * @method static self other()
 */
final class DietsFace2FaceEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'face_2_face' => 0,
            'online' => 1,
            'other' => 2,
        ];
    }

    protected static function labels(): array
    {
        return [
            'face_2_face' => 'Yüzyüze',
            'online' => 'Online',
            'other' => 'Diğer',

        ];
    }
}
