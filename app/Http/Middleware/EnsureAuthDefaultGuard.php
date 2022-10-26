<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

final class EnsureAuthDefaultGuard
{
    /**
     * Create a new middleware instance.
     */
    public function __construct(private Repository $config)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @throws RuntimeException
     */
    public function handle(Request $request, Closure $next, string $guard): Response
    {
        if (! \array_key_exists($guard, $this->config->get('auth.guards'))) {
            throw new RuntimeException('Auth guard '.$guard.' is not defined.');
        }

        $this->config->set('auth.defaults.guard', $guard);

        return $next($request);
    }
}
