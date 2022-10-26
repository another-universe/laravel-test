<?php

declare(strict_types=1);

namespace App\Actions\Recipe;

use App\DataTransferObjects\Recipe\ShareRecipeData;
use App\Jobs\Recipe\ShareRecipeJob;
use App\Models\Recipe;
use App\Models\User;

final class ShareRecipeAction
{
    private ?string $locale = null;

    /**
     * Execute action.
     */
    public function execute(User $user, Recipe $recipe, ShareRecipeData $data): void
    {
        ShareRecipeJob::dispatch($user, $recipe, $data, $this->locale);
    }

    /**
     * Use specific locale or current locale.
     */
    public function withLocale(?string $locale = null): self
    {
        if (\func_num_args() === 0) {
            $locale = \app()->getLocale();
        }

        $this->locale = $locale;

        return $this;
    }
}
