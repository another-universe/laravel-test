<?php

declare(strict_types=1);

namespace App\Rules;

use App\Kernel\Validation\Rule;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use ValueError;

final class UniqueUserNickName extends Rule
{
    private ?int $ignore = null;

    /**
     * Validate attribute.
     *
     * @throws ValueError
     */
    public function validate(string $attribute, mixed $value, array $parameters, Validator $validator): bool
    {
        $ignore = $parameters['ignore'] ?? null;

        if ($ignore !== null) {
            $ignore = \filter_var($ignore, \FILTER_VALIDATE_INT);

            if ($ignore === false || $ignore < 1) {
                throw new ValueError("The 'ignore' parameter must be a positive number.");
            }
        }

        return $this->createQuery($value, $ignore)->doesntExist();
    }

    /**
     * Create query builder.
     */
    private function createQuery(string $nickName, ?int $ignore): Builder
    {
        $query = User::whereNickName($nickName);

        if ($ignore !== null) {
            $query->whereKeyNot($ignore);
        }

        return $query;
    }

    /**
     * Set "ignore" parameter.
     */
    public function ignore(int|User $ignore): self
    {
        if ($ignore instanceof User) {
            $ignore = $ignore->getId();
        }

        $this->ignore = $ignore;

        return $this;
    }

    /**
     * get rule parameters.
     */
    protected function getParameters(): array
    {
        return [
            'ignore' => $this->ignore,
        ];
    }
}
