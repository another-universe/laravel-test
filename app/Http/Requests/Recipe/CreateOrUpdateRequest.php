<?php

declare(strict_types=1);

namespace App\Http\Requests\Recipe;

use App\Rules\UniqueRecipeTitleByUser;
use Illuminate\Foundation\Http\FormRequest;

abstract class CreateOrUpdateRequest extends FormRequest
{
    /**
     * Fields to be validated.
     */
    protected array $validatableFields = [
        'title',
        'short_description',
        'text',
    ];

    /**
     * Get data to be validated from the request.
     */
    public function validationData(): array
    {
        return $this->only($this->validatableFields);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => [
                'bail', 'string', 'max:150', $this->getUniqueRule(),
            ],
            'short_description' => [
                'bail', 'nullable', 'string', 'max:255',
            ],
            'text' => [
                'bail', 'string', 'max:10000',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        if ($this->api()) {
            return [
                'required' => 'The :attribute field is required.',
                'filled' => 'The :attribute field must not be empty if it is present in the request.',
                'present' => 'The :attribute field must be present in the request, but may be empty.',
                'string' => 'The value of the :attribute field must be a string.',
                'max' => 'The value of the :attribute field can be up to :max characters long.',
                'title_not_unique' => 'You have already added a recipe with this title.',
            ];
        }

        $messages = \__('recipe/create_or_update_validation.messages');

        if (\is_array($messages)) {
            return $messages;
        }

        return [];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        if ($this->api()) {
            return \array_combine($this->validatableFields, $this->validatableFields);
        }

        $attributes = \__('recipe/create_or_update_validation.attributes');

        if (\is_array($attributes)) {
            return $attributes;
        }

        return [];
    }

    /**
     * Get unique rule.
     */
    protected function getUniqueRule(): UniqueRecipeTitleByUser
    {
        return (new UniqueRecipeTitleByUser())
            ->user($this->user())
            ->message('title_not_unique');
    }
}
