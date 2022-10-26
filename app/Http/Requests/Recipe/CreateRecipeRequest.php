<?php

declare(strict_types=1);

namespace App\Http\Requests\Recipe;

final class CreateRecipeRequest extends CreateOrUpdateRequest
{
    /**
     * The route to redirect to if validation fails.
     *
     * @var string|null
     */
    protected $redirectRoute = 'recipes.create';

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'title' => ['required'],
            'short_description' => ['present'],
            'text' => ['required'],
        ];

        return \array_merge_recursive($rules, parent::rules());
    }
}
