<?php

declare(strict_types=1);

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string getDefaultDriver()
 * @method static \App\Contracts\RecipeSharing\Driver driver(?string $driver = null)
 * @method static array getSupportedDrivers()
 * @method static bool isSupportedDriver(string $driver)
 * @method static array getDrivers()
 * @method static \App\Contracts\RecipeSharing\Factory forgetDrivers()
 * @method static \App\Contracts\RecipeSharing\Factory forgetDriver(string $driver)
 *
 * @see \App\Services\RecipeSharing\Manager
 * @see \App\Contracts\RecipeSharing\Factory
 * @see \App\Contracts\RecipeSharing\Driver
 */
final class RecipeSharing extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'recipe.sharing';
    }
}
