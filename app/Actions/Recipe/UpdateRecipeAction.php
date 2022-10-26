<?php

declare(strict_types=1);

namespace App\Actions\Recipe;

use App\DataTransferObjects\Recipe\UpdateRecipeData;
use App\Events\Recipe\RecipeWasUpdated;
use App\Models\Recipe;
use App\Support\Actions\HasDispatchingEvents;
use App\Support\DataTransferObjects\MissingValue;

final class UpdateRecipeAction
{
    use HasDispatchingEvents;

    /**
     * Execute action.
     */
    public function execute(Recipe $recipe, UpdateRecipeData $data): Recipe
    {
        return \app('db.connection')->transaction(function () use ($recipe, $data) {
            $fillable = \collect($data->toArray())
                ->reject(static fn ($value) => $value instanceof MissingValue)
                ->all();

            $recipe->fill($fillable)->save();

            if ($recipe->wasChanged()) {
                $event = new RecipeWasUpdated($recipe);
                $this->dispatchEvent($event);
            }

            return $recipe;
        });
    }
}
