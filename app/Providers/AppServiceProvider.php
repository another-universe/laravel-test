<?php

declare(strict_types=1);

namespace App\Providers;

use App\Support\Carbon\DateTimeSerializer;
use App\Support\Http\RequestMixin;
use App\Support\Routing\RouterMixin;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(NotificationServiceProvider::class);
        $this->app->register(ValidationServiceProvider::class);
        $this->app->register(ViewServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Date::useClass(CarbonImmutable::class);
        Date::serializeUsing(new DateTimeSerializer());

        Request::mixin(new RequestMixin());

        Route::mixin(new RouterMixin());
    }
}
