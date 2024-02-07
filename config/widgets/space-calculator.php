<?php

use App\Enums\Widget;

return [
    'widget' => Widget::SPACE_CALCULATOR,

    'workstyle-parameters' => [
        \App\Enums\Widgets\SpaceCalculator\Workstyle::SERVICE_DELIVERY->value => [
            'hybrid-working' => [
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::OFFICE->value => 61.92,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::ONE_DAY->value => 55.73,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::TWO_DAYS->value => 50.16,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::THREE_DAYS->value => 40.13,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::FOUR_DAYS->value => 32.1,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::HOME->value => 20.31,
            ],
            'workstations' => [
                'private-offices' => 9.3,
                'use-of-touchdown' => 15.87,
            ],
            'area-adjuster' => 103,
        ],
        \App\Enums\Widgets\SpaceCalculator\Workstyle::CREATIVE->value => [
            'hybrid-working' => [
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::OFFICE->value => 69.62,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::ONE_DAY->value => 62.65,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::TWO_DAYS->value => 56.39,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::THREE_DAYS->value => 45.11,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::FOUR_DAYS->value => 36.09,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::HOME->value => 22.84,
            ],
            'workstations' => [
                'private-offices' => 3.2,
                'use-of-touchdown' => 20.39,
            ],
            'area-adjuster' => 98.4,
        ],
        \App\Enums\Widgets\SpaceCalculator\Workstyle::FINANCIAL->value => [
            'hybrid-working' => [
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::OFFICE->value => 77.31,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::ONE_DAY->value => 69.58,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::TWO_DAYS->value => 62.62,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::THREE_DAYS->value => 50.1,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::FOUR_DAYS->value => 40.08,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::HOME->value => 25.36,
            ],
            'workstations' => [
                'private-offices' => 4.6,
                'use-of-touchdown' => 5.38,
            ],
            'area-adjuster' => 102,
        ],
        \App\Enums\Widgets\SpaceCalculator\Workstyle::GENERAL->value => [
            'hybrid-working' => [
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::OFFICE->value => 81.15,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::ONE_DAY->value => 73.04,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::TWO_DAYS->value => 65.73,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::THREE_DAYS->value => 52.59,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::FOUR_DAYS->value => 42.07,
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::HOME->value => 26.62,
            ],
            'workstations' => [
                'private-offices' => 2.1,
                'use-of-touchdown' => 10.43,
            ],
            'area-adjuster' => 100,
        ],
        \App\Enums\Widgets\SpaceCalculator\Workstyle::TECHNOLOGY->value => [
            'hybrid-working' => [
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::OFFICE->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::ONE_DAY->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::TWO_DAYS->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::THREE_DAYS->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::FOUR_DAYS->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::HOME->value => '',
            ],
            'workstations' => [
                'private-offices' => '',
                'use-of-touchdown' => '',
            ],
            'area-adjuster' => '',
        ],
        \App\Enums\Widgets\SpaceCalculator\Workstyle::LAW->value => [
            'hybrid-working' => [
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::OFFICE->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::ONE_DAY->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::TWO_DAYS->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::THREE_DAYS->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::FOUR_DAYS->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::HOME->value => '',
            ],
            'workstations' => [
                'private-offices' => '',
                'use-of-touchdown' => '',
            ],
            'area-adjuster' => '',
        ],
        \App\Enums\Widgets\SpaceCalculator\Workstyle::PROCESS_DRIVEN->value => [
            'hybrid-working' => [
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::OFFICE->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::ONE_DAY->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::TWO_DAYS->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::THREE_DAYS->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::FOUR_DAYS->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::HOME->value => '',
            ],
            'workstations' => [
                'private-offices' => '',
                'use-of-touchdown' => '',
            ],
            'area-adjuster' => '',
        ],
        \App\Enums\Widgets\SpaceCalculator\Workstyle::PUBLIC_SECTOR->value => [
            'hybrid-working' => [
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::OFFICE->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::ONE_DAY->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::TWO_DAYS->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::THREE_DAYS->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::FOUR_DAYS->value => '',
                \App\Enums\Widgets\SpaceCalculator\HybridWorking::HOME->value => '',
            ],
            'workstations' => [
                'private-offices' => '',
                'use-of-touchdown' => '',
            ],
            'area-adjuster' => '',
        ],
    ],
];
