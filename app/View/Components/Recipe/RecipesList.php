<?php

declare(strict_types=1);

namespace App\View\Components\Recipe;

use App\Models\Recipe;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\Component;

final class RecipesList extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        private CursorPaginator|Paginator $paginator,
        private bool $group = true,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return \view('components.recipe.recipes-list');
    }

    /**
     * Get collection of recipes.
     */
    public function recipeCollection(): Collection
    {
        $collection = $this->paginator->getCollection();

        if ($this->group === false) {
            return $collection;
        }

        $currentYear = \now()->format('Y');

        return $collection
            ->groupBy(static function (Recipe $recipe) use ($currentYear) {
                $date = $recipe->getCreatedAt();
                $groupKey = $date->translatedFormat('l j F');
                $year = $date->format('Y');

                if ($year !== $currentYear) {
                    $groupKey .= ' '.$year;
                }

                return Str::ucfirst($groupKey);
            });
    }

    /**
     * Compute description for recipe.
     */
    public function description(Recipe $recipe): string
    {
        $description = $recipe->getShortDescription();

        if ($description !== null) {
            return $description;
        }

        $description = Str::substr($recipe->getText(), 0, 255);

        if (Str::length($description) < 255) {
            return $description;
        }

        return Str::beforeLast($description, ' ').'...';
    }

    /**
     * An indicator of whether grouping is in use.
     */
    public function isGrouped(): bool
    {
        return $this->group;
    }

    /**
     * Pagination links.
     */
    public function paginationLinks(): View
    {
        return $this->paginator->links();
    }
}
