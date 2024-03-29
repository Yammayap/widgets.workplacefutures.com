<?php

namespace App\Support;

use Carbon\CarbonImmutable;

class Helpers
{
    /**
     * @param CarbonImmutable $datetime
     * @return string
     */
    public static function formatDateTime(CarbonImmutable $datetime): string
    {
        return $datetime->setTimezone('Europe/London')->format('d/m/Y H:i');
    }
}
