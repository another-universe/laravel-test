<?php

declare(strict_types=1);

namespace App\Actions\Recipe;

use App\DataTransferObjects\Recipe\CreateRecipeData;
use App\Events\Recipe\RecipeWasCreated;
use App\Models\Recipe;
use App\Models\User;
use App\Support\Actions\HasDispatchingEvents;

final class CreateRecipeAction
{
    use HasDispatchingEvents;

    /**
     * Execute action.
     */
    public function execute(?User $user, CreateRecipeData $data): Recipe
    {
        return \app('db.connection')->transaction(function () use ($data) {
            $recipe = new Recipe();
            $recipe->fill($data->toArray());

            if ($user !== null) {
                $recipe->user()->associate($user);
            }

            $recipe->save();

            $event = new RecipeWasCreated($recipe);
            $this->dispatchEvent($event);

            return $recipe;
        });
    }
}
