<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

final class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->resolving('blade.compiler', static function (BladeCompiler $blade) {
            $blade->directive('js', fn ($expression) => "<?php echo e(Illuminate\\Support\\Js::from({$expression})); ?>");
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Paginator::defaultView('pagination.pagination');
        Paginator::defaultSimpleView('pagination.simple-pagination');
    }
}
