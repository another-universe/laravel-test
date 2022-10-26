<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

final class RegisterRequest extends FormRequest
{
    /**
     * The route to redirect to if validation fails.
     *
     * @var string|null
     */
    protected $redirectRoute = 'register';

    /**
     * Fields to be validated.
     */
    private array $validatableFields = [
        'nick_name',
        'email',
        'password',
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
            'nick_name' => [
                'bail', 'required', 'string', 'max:50', 'unique_user_nick_name',
            ],
            'email' => [
                'bail', 'required', 'string', 'email', 'unique_user_email',
            ],
            'password' => [
                'bail', 'required', 'string', 'min:6',
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
                'string' => 'The value of the :attribute field must be a string.',
                'min' => 'The :attribute field must be at least :min characters long.',
                'max' => 'The :attribute field can be up to :max characters long.',
                'email' => 'Invalid :attribute format.',
                'unique_user_email' => 'User with this :attribute already exists.',
                'unique_user_nick_name' => 'User with this :attribute already exists.',
            ];
        }

        $messages = \__('register/validation.messages');

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

        $attributes = \__('register/validation.attributes');

        if (\is_array($attributes)) {
            return $attributes;
        }

        return [];
    }
}
