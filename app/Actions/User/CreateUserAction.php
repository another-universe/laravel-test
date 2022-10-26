<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\DataTransferObjects\User\CreateUserData;
use App\Models\User;
use App\Support\Actions\HasDispatchingEvents;
use Closure;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Hashing\Hasher;

final class CreateUserAction
{
    use HasDispatchingEvents;

    private ?Closure $onCreatedCallback = null;

    /**
     * Create a new action instance.
     */
    public function __construct(private Hasher $hasher)
    {
    }

    /**
     * Execute action.
     */
    public function execute(CreateUserData $data): mixed
    {
        return \app('db.connection')->transaction(function () use ($data) {
            $user = new User();
            $user
                ->setNickName($data->nickName)
                ->setEmail($data->email)
                ->setPassword($this->hasher->make($data->password))
                ->save();

            $result = \with($user, $this->onCreatedCallback);

            $event = new Registered($user);
            $this->dispatchEvent($event);

            return $result;
        });
    }

    /**
     * Set a callback to be executed after the user is created.
     */
    public function onCreated(Closure $callback): self
    {
        $this->onCreatedCallback = $callback;

        return $this;
    }
}
