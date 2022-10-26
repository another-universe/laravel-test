<?php

declare(strict_types=1);

namespace App\Kernel\Eloquent\Concerns;

use DateTimeInterface;
use Illuminate\Support\Facades\Date;

trait HasOverrites
{
    /**
     * Prepare a date for array / JSON serialization.
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return Date::instance($date)->toISOString(true);
    }

    /**
     * Get the format for database stored dates.
     */
    public function getDateFormat(): string
    {
        return \defined('MODEL_DATE_FORMAT') ? MODEL_DATE_FORMAT : parent::getDateFormat();
    }
}
