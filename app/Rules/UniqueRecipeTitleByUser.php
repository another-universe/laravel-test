<?php

declare(strict_types=1);

namespace App\Rules;

use App\Kernel\Validation\Rule;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use LogicException;
use ValueError;

final class UniqueRecipeTitleByUser extends Rule
{
    private ?int $user = null;

    private ?int $ignore = null;

    /**
     * Validate attribute.
     *
     * @throws LogicException
     * @throws ValueError
     */
    public function validate(string $attribute, mixed $value, array $parameters, Validator $validator): bool
    {
        $user = $parameters['user'] ?? null;

        if ($user === null) {
            throw new LogicException("The 'user' parameter is required.");
        }

        $user = \filter_var($user, \FILTER_VALIDATE_INT);

        if ($user === false || $user < 1) {
            throw new ValueError("The 'user' parameter must be positive integer.");
        }

        $ignore = $parameters['ignore'] ?? null;

        if ($ignore !== null) {
            $ignore = \filter_var($ignore, \FILTER_VALIDATE_INT);

            if ($ignore === false || $ignore < 1) {
                throw new ValueError("The 'ignore' parameter must be positive integer.");
            }
        }

        $query = $this->createQuery($value, $user, $ignore);

        return $query->doesntExist();
    }

    /**
     * Create query builder.
     */
    private function createQuery(string $title, int $user, ?int $ignore): Builder
    {
        $query = Recipe::whereUserId($user)->whereTitle($title);

        if ($ignore !== null) {
            $query->whereKeyNot($ignore);
        }

        return $query;
    }

    /**
     * set "user" parameter.
     */
    public function user(int|User $user): self
    {
        if ($user instanceof User) {
            $user = $user->getId();
        }

        $this->user = $user;

        return $this;
    }

    /**
     * Set "ignore" parameter.
     */
    public function ignore(int|Recipe $ignore): self
    {
        if ($ignore instanceof Recipe) {
            $ignore = $ignore->getId();
        }

        $this->ignore = $ignore;

        return $this;
    }

    /**
     * Get rule parameters.
     */
    protected function getParameters(): array
    {
        return [
            'user' => $this->user,
            'ignore' => $this->ignore,
        ];
    }
}
