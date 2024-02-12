<?php

namespace Tests\Unit\Support;

use App\Support\Helpers;
use Carbon\CarbonImmutable;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    public function test_format_date_time_function_returns_formatted_date(): void
    {
        $date_1 = CarbonImmutable::createFromFormat('d-m-Y H:i:s', '23-01-2024 14:52:13');

        $this->assertEquals('23/01/2024 14:52', Helpers::formatDateTime($date_1));
    }
}
