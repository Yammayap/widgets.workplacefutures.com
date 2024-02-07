<?php

use App\Enums\Widget;

return [
    'widget' => Widget::SPACE_CALCULATOR,

    'raw-space-standards' => [
        'tight' => [
            0 => 10,
            1 => 2.6,
            2 => 2.5,
        ],
        'average' => [
            0 => 12,
            1 => 2.8,
            2 => 2.9,
        ],
        'spacious' => [
            0 => 18,
            1 => 3.4,
            2 => 3.3,
        ],
    ],
];
