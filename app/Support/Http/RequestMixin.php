<?php

declare(strict_types=1);

namespace App\Support\Http;

use Closure;

final class RequestMixin
{
    public function api(): Closure
    {
        return function (): bool {
            return $this->is(['api/*']);
        };
    }
}
