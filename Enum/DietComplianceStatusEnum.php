<?php

namespace App\Enum;

use ObiPlus\ObiPlus\Enums\Enum;

/**
 * @method static self edema_and_bloating()
 * @method static self constipation()
 * @method static self before_menstruation()
 * @method static self after_menstruation()
 */
final class DietComplianceStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'edema_and_bloating' => 0,
            'constipation' => 1,
            'before_menstruation' => 2,
            'after_menstruation' => 3,
        ];
    }

    protected static function labels(): array
    {
        return [
            'edema_and_bloating+' => 'Edema And Bloatings',
            'constipation-' => 'Constipation',
            'before_menstruation+' => 'Before Menstruation',
            'after_menstruation-' => 'After Menstruation'
        ];
    }
}
