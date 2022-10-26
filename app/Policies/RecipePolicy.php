<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

final class RecipePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Recipe $recipe): Response
    {
        if ($recipe->getUserId() === $user->getId()) {
            return $this->allow();
        }

        return $this->deny();
    }
}
