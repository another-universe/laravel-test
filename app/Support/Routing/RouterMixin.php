<?php

declare(strict_types=1);

namespace App\Support\Routing;

use Closure;

final class RouterMixin
{
    public function useBinder(): Closure
    {
        return function (string $parameter, string $class, ?string $pattern = null): void {
            $this->bind($parameter, [$class, 'bind']);

            if ($pattern !== null) {
                $this->pattern($parameter, $pattern);
            }
        };
    }
}
