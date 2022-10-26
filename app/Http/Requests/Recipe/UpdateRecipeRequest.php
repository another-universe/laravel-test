<?php

declare(strict_types=1);

namespace App\Http\Requests\Recipe;

use App\Rules\UniqueRecipeTitleByUser;

final class UpdateRecipeRequest extends CreateOrUpdateRequest
{
    /**
     * The route to redirect to if validation fails.
     *
     * @var string|null
     */
    protected $redirectRoute = 'recipes.edit';

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = match ($this->method()) {
            'PUT' => [
                'title' => ['required'],
                'short_description' => ['present'],
                'text' => ['required'],
            ],
            'PATCH' => [
                'title' => ['filled'],
                'text' => ['filled'],
            ],
        };

        return \array_merge_recursive($rules, parent::rules());
    }

    /**
     * Get unique rule.
     */
    protected function getUniqueRule(): UniqueRecipeTitleByUser
    {
        return parent::getUniqueRule()->ignore($this->route('recipe'));
    }
}
