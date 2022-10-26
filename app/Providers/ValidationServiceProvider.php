<?php

declare(strict_types=1);

namespace App\Providers;

use App\Rules\MobilePhone;
use App\Rules\Telegram;
use App\Rules\UniqueRecipeTitleByUser;
use App\Rules\UniqueUserEmail;
use App\Rules\UniqueUserNickName;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\ServiceProvider;

final class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->resolving('validator', static function (Factory $factory) {
            $factory->extend('unique_user_nick_name', UniqueUserNickName::class);

            $factory->extend('unique_user_email', UniqueUserEmail::class);

            $factory->extend('unique_recipe_title_by_user', UniqueRecipeTitleByUser::class);

            $factory->extend('telegram', Telegram::class);

            $factory->extend('mobile_phone', MobilePhone::class);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
