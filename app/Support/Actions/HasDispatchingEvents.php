<?php

declare(strict_types=1);

namespace App\Support\Actions;

trait HasDispatchingEvents
{
    protected bool $quietly = false;

    /**
     * Dispatch an event.
     */
    protected function dispatchEvent(mixed ...$parameters): ?array
    {
        if ($this->quietly) {
            return null;
        }

        return \event(...$parameters);
    }

    /**
     * Prevent the action from sending events.
     */
    public function quietly(): static
    {
        $this->quietly = true;

        return $this;
    }
}
