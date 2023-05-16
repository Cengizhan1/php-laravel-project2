<?php

namespace App\Enum;

use ObiPlus\ObiPlus\Enums\Enum;

/**
 * @method static self followed_completely()
 * @method static self quit_two_or_less()
 * @method static self quit_more_than_two()
 * @method static self did_not_follow()
 */
final class ExtraCasesEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'followed_completely' => 0,
            'quit_two_or_less' => 1,
            'quit_more_than_two' => 2,
            'did_not_follow' => 3,
        ];
    }

    protected static function labels(): array
    {
        return [
            'followed_completely+' => 'I Followed The Diet Completely',
            'quit_two_or_less-' => 'I Quit Two Or Less Diet Programs',
            'quit_more_than_two+' => 'I Quit More Than Two Diet Programs',
            'did_not_follow-' => 'I Didn\'t Follow The Diet',
        ];
    }
}
