<?php

declare(strict_types=1);

namespace App\Actions\Recipe;

use App\Events\Recipe\RecipeWasAddedToFavorites;
use App\Models\Recipe;
use App\Models\User;
use App\Support\Actions\HasDispatchingEvents;

final class AddRecipeToFavoritesAction
{
    use HasDispatchingEvents;

    /**
     * Execute action.
     */
    public function execute(User $user, Recipe $recipe): void
    {
        \app('db.connection')->transaction(function () use ($user, $recipe) {
            if (! $user->hasRecipeInFavorites($recipe)) {
                $user->favoriteRecipes()->attach($recipe);
                Recipe::withoutTimestamps(static fn () => $recipe->increment('in_favorites'));

                $event = new RecipeWasAddedToFavorites($recipe, $user);
                $this->dispatchEvent($event);
            }
        });
    }
}
