<?php

declare(strict_types=1);

namespace App\Http\RouteParameterBinders;

use App\Kernel\Routing\ParameterBinder;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Route;

final class RecipeBinder extends ParameterBinder
{
    /**
     * @throws ModelNotFoundException
     */
    protected function resolve(string $value, Route $route): Recipe
    {
        return Recipe::findOrFail($value);
    }
}
