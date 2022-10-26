<?php

declare(strict_types=1);

namespace App\Http\Requests\Recipe;

use App\Enums\Recipe\RecipeSharingChannel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

final class ShareRecipeRequest extends FormRequest
{
    /**
     * fields to be validated.
     */
    private array $validatableFields = [
        'channel',
        'sender',
        'recipient',
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
        $rules = [
            'channel' => [
                'bail', 'required', 'string', Rule::in(Arr::pluck(RecipeSharingChannel::cases(), 'value')),
            ],
            'sender' => [
                'bail', 'nullable', 'string', 'max:255',
            ],
            'recipient' => [
                'bail', 'required', 'string',
            ],
        ];

        $dynamicRule = match ($this->input('channel')) {
            'mail' => 'email',
            'telegram' => 'telegram',
            'viber' => 'mobile_phone',
            default => null,
        };

        if ($dynamicRule !== null) {
            $rules['recipient'][] = $dynamicRule;
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        if ($this->api()) {
            return [
                'required' => 'The :attribute field is required.',
                'string' => 'The value of the :attribute field must be a string.',
                'max' => 'The value of the :attribute field can be up to :max characters long.',
                'in' => 'The :attribute field has an invalid value. Supported values: :values.',
                '*' => 'The :attribute field has an invalid value.',
            ];
        }

        $messages = \__('recipe/share_validation.messages');

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

        $attributes = \__('recipe/share_validation.attributes');

        if (\is_array($attributes)) {
            return $attributes;
        }

        return [];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $channel = $this->input('channel');

        if (\is_string($channel)) {
            $this->merge(['channel' => Str::lower($channel)]);
        }
    }
}
