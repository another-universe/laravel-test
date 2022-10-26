<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use LogicException;

final class LogoutUserAction
{
    private ?Closure $handler = null;

    /**
     * Execute action.
     *
     * @throws LogicException
     */
    public function execute(User $user): void
    {
        if ($this->handler === null) {
            throw new LogicException('Unauthentication method not specified.');
        }

        \call_user_func($this->handler, $user);
    }

    /**
     * Logout current device.
     */
    public function logoutCurrentDevice(): self
    {
        $this->handler = static function (): void {
            Auth::logoutCurrentDevice();
        };

        return $this;
    }

    /**
     * Revoke current access token.
     */
    public function revokeCurrentAccessToken(): self
    {
        $this->handler = static function (User $user): void {
            $user->currentAccessToken()->delete();
        };

        return $this;
    }
}
