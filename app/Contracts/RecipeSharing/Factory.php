<?php

declare(strict_types=1);

namespace App\Contracts\RecipeSharing;

interface Factory
{
    /**
     * Get the default driver name.
     */
    public function getDefaultDriver(): string;

    /**
     * Get a driver instance.
     */
    public function driver(?string $driver = null): Driver;

    /**
     * Get all of the supported drivers.
     */
    public function getSupportedDrivers(): array;

    /**
     * Determine if driver is supported.
     */
    public function isSupportedDriver(string $driver): bool;
}
