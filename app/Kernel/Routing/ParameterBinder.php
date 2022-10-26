<?php

declare(strict_types=1);

namespace App\Kernel\Routing;

use Illuminate\Routing\Route;

abstract class ParameterBinder
{
    public static function bind(string $value, Route $route): mixed
    {
        return \app(static::class)->resolve($value, $route);
    }

    abstract protected function resolve(string $value, Route $route): mixed;
}
