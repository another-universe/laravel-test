<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\User\Exceptions\BlockedUserException;
use App\DataTransferObjects\User\LoginUserData;
use App\DataTransferObjects\User\NewAccessToken;
use Closure;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use LogicException;

final class LoginUserAction
{
    private ?Closure $handler = null;

    /**
     * Execute action.
     *
     * @throws LogicException
     */
    public function execute(LoginUserData $data): mixed
    {
        if ($this->handler === null) {
            throw new LogicException('Authentication method not specified.');
        }

        return (new Pipeline())
            ->send($data)
            ->through([
                $this->canBeAuthenticated(...),
                $this->passwordNeedsRehash(...),
            ])
            ->then($this->handler);
    }

    /**
     * Authenticate the user with a session.
     */
    public function viaSession(bool $remember = false): self
    {
        $this->handler = static function (LoginUserData $payload) use ($remember): bool {
            Auth::login($payload->user, $remember);

            return true;
        };

        return $this;
    }

    /**
     * Authenticate the user with a token.
     */
    public function viaToken(string $tokenName): self
    {
        $this->handler = static function (LoginUserData $payload) use ($tokenName): NewAccessToken {
            $token = $payload->user->createToken($tokenName);
            $expires = Config::get('sanctum.expiration');

            if ($expires !== null) {
                $expires = $token->accessToken->created_at->addMinutes($expires)->getTimestamp();
            }

            return new NewAccessToken(
                token: $token->plainTextToken,
                type: 'Bearer',
                expiresAt: $expires,
            );
        };

        return $this;
    }

    /**
     * Determine if the given user can be authenticated.
     *
     * @throws BlockedUserException
     */
    private function canBeAuthenticated(LoginUserData $payload, Closure $next): mixed
    {
        if ($payload->user->isBlocked()) {
            throw new BlockedUserException('User is blocked.');
        }

        return $next($payload);
    }

    /**
     * Rehash the password if necessary.
     */
    private function passwordNeedsRehash(LoginUserData $payload, Closure $next): mixed
    {
        $result = $next($payload);

        if (Hash::needsRehash($payload->user->getPassword())) {
            \rescue(static function () use ($payload) {
                $password = Hash::make($payload->rawPassword);
                $payload->user->setPassword($password)->save();
            });
        }

        return $result;
    }
}
