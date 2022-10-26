<?php

declare(strict_types=1);

namespace App\Support\Carbon;

use Carbon\CarbonInterface;

final class DateTimeSerializer
{
    /**
     * The date & time format.
     */
    public static ?string $format = null;

    /**
     * Handle the serialization of the DateTimeInterface instance.
     */
    public function __invoke(CarbonInterface $dateTime): string
    {
        if (self::$format) {
            return $dateTime->format(self::$format);
        }

        return $dateTime->toISOString(true);
    }
}
