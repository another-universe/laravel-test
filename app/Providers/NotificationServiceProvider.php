<?php

declare(strict_types=1);

namespace App\Providers;

use App\Kernel\Notifications\Channels\TelegramChannel;
use App\Kernel\Notifications\Channels\ViberChannel;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;

final class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->resolving(ChannelManager::class, static function ($manager) {
            $manager->extend('telegram', function () {
                return new TelegramChannel();
            });

            $manager->extend('viber', function () {
                return new ViberChannel();
            });
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
