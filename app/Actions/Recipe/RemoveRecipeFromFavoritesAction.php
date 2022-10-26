<?php

declare(strict_types=1);

namespace App\Actions\Recipe;

use App\Events\Recipe\RecipeWasRemovedFromFavorites;
use App\Models\Recipe;
use App\Models\User;
use App\Support\Actions\HasDispatchingEvents;

final class RemoveRecipeFromFavoritesAction
{
    use HasDispatchingEvents;

    /**
     * Execute action.
     */
    public function execute(User $user, Recipe $recipe): void
    {
        \app('db.connection')->transaction(function () use ($user, $recipe) {
            if ($user->favoriteRecipes()->detach($recipe) > 0) {
                Recipe::withoutTimestamps(static fn () => $recipe->decrement('in_favorites'));

                $event = new RecipeWasRemovedFromFavorites($recipe, $user);
                $this->dispatchEvent($event);
            }
        });
    }
}
