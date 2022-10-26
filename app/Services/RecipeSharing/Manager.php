<?php

declare(strict_types=1);

namespace App\Services\RecipeSharing;

use App\Contracts\RecipeSharing\Driver;
use App\Contracts\RecipeSharing\Factory;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use LogicException;

final class Manager implements Factory
{
    private Repository $config;

    private array $drivers = [];

    /**
     * Create a new Manager instance.
     */
    public function __construct(private Container $container)
    {
        $this->config = $this->container['config'];
    }

    /**
     * Get the default driver name.
     *
     * @throws LogicException
     */
    public function getDefaultDriver(): string
    {
        return $this->retrieveFromConfig('default') ?? throw new LogicException('Default driver not defined.');
    }

    /**
     * Get a driver instance.
     */
    public function driver(?string $driver = null): Driver
    {
        $driver = $driver ?: $this->getDefaultDriver();

        return $this->drivers[$driver] ??= $this->createDriver($driver);
    }

    /**
     * Get all of the supported drivers.
     */
    public function getSupportedDrivers(): array
    {
        return \collect($this->retrieveFromConfig('drivers', []))
            ->map(static fn ($driver, $key) => $driver['name'] ?? $key)
            ->all();
    }

    /**
     * Determine if driver is supported.
     */
    public function isSupportedDriver(string $driver): bool
    {
        return \is_array($this->retrieveFromConfig('drivers.'.$driver));
    }

    /**
     * Get all of the created drivers.
     */
    public function getDrivers(): array
    {
        return $this->drivers;
    }

    /**
     * Forget all of the created drivers instances.
     */
    public function forgetDrivers(): self
    {
        $this->drivers = [];

        return $this;
    }

    /**
     * Forget of the created driver instance.
     */
    public function forgetDriver(string $driver): self
    {
        unset($this->drivers[$driver]);

        return $this;
    }

    /**
     * Create a new driver instance.
     *
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    private function createDriver(string $driver): Driver
    {
        $config = $this->retrieveFromConfig('drivers.'.$driver);

        if (! \is_array($config)) {
            throw new InvalidArgumentException('The '.$driver.' driver is not supported.');
        }

        $class = Arr::pull($config, 'class');

        if (! \is_string($class)) {
            throw new LogicException("The 'class' configuration parameter is not defined for the {$driver} driver.");
        }

        $driver = $this->container->make($class);

        return $driver->setConfig($config);
    }

    /**
     * Retrieve data from config by key.
     */
    private function retrieveFromConfig(?string $key = null, mixed $default = null): mixed
    {
        $key = $key === null ? 'recipe_sharing' : "recipe_sharing.{$key}";

        return $this->config->get($key, $default);
    }

    /**
     * Dynamically call the default driver instance.
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->driver(null)->{$method}(...$parameters);
    }
}
