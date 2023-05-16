<?php

namespace App\Enum;

use ObiPlus\ObiPlus\Enums\Enum;

/**
 * @method static self never_exercised()
 * @method static self exercised_one_two()
 * @method static self exercised_three_four()
 * @method static self did_it_five_times()
 */
final class WeeklyExerciseStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'never_exercised' => 0,
            'exercised_one_two' => 1,
            'exercised_three_four' => 2,
            'did_it_five_times' => 3,
        ];
    }

    protected static function labels(): array
    {
        return [
            'never_exercised+' => 'I Have Never Exercised',
            'exercised_one_two-' => 'I Have Exercised One Or Two Times',
            'exercised_three_four+' => 'I Have Exercised Three Or Four Times',
            'did_it_five_times-' => 'I Did It More Than Five Times'
        ];
    }
}
