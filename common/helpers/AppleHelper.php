<?php

namespace common\helpers;

use appleapp\models\Apple;
use common\models\Apple as AppleRecord;

abstract class AppleHelper
{
    const colors = ['green', 'yellow', 'red', 'orange', 'pink'];

    const states = [
        Apple::STATE_ON_TREE => 'На дереве',
        Apple::STATE_ON_GROUND => 'На земле',
        Apple::STATE_ROTTEN => 'испортилось',
        Apple::STATE_EATEN => 'Съедено',
    ];

    public static function generateRandomApple()
    {
        $apple = new Apple(static::colors[mt_rand(0, count(static::colors)-1)]);
        return $apple;
    }

    public static function getStateText($state)
    {
        return !empty(static::states[$state])
            ? static::states[$state]
            : 'Unknown';
    }
}