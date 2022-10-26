<?php

declare(strict_types=1);

namespace App\Events\Recipe;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class RecipeWasAddedToFavorites
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly Recipe $recipe,
        public readonly User $user,
    ) {
    }
}
