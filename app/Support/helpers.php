<?php

declare(strict_types=1);

if (! function_exists('___')) {
    function ___(string $key, Countable|int|array $number, array $replace = [], ?string $locale = null): string
    {
        return app('translator')->choice($key, $number, $replace, $locale);
    }
}
