<?php

declare(strict_types=1);

namespace App\View\Components\Recipe;

use App\Contracts\RecipeSharing\Factory;
use App\Models\Recipe;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

final class ShareModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Recipe $recipe,
        public string $modalId,
        public Factory $recipeSharing,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return \view('components.recipe.share-modal');
    }
}
