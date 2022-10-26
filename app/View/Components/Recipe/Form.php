<?php

declare(strict_types=1);

namespace App\View\Components\Recipe;

use App\Models\Recipe;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

final class Form extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $actionUrl,
        public ?Recipe $recipe,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return \view('components.recipe.form');
    }
}
