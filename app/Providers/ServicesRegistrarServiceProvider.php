<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\RecipeSharing\Factory as RecipeSharingFactory;
use App\Services\RecipeSharing\Manager as RecipeSharingManager;
use Illuminate\Support\ServiceProvider;

final class ServicesRegistrarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('recipe.sharing', static function ($app) {
            return new RecipeSharingManager($app);
        });
        $this->app->alias('recipe.sharing', RecipeSharingFactory::class);
        $this->app->alias('recipe.sharing', RecipeSharingManager::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
