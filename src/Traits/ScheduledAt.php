<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Traits;

use Carbon\Carbon;

trait ScheduledAt
{
    protected function calculateNextScheduledAt(Carbon $timestamp, int $delayInSeconds): Carbon
    {
        return Carbon::parse($timestamp)->addSeconds($delayInSeconds);
    }
}
