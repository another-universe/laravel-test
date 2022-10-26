<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

final class LoginRequest extends FormRequest
{
    /**
     * The route to redirect to if validation fails.
     *
     * @var string|null
     */
    protected $redirectRoute = 'login';

    /**
     * The User instance.
     */
    private ?User $authenticatable = null;

    /**
     * Fields to be validated.
     */
    private array $validatableFields = [
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
            'email' => [
                'bail', 'required', 'string', 'email', 'validate_email',
            ],
            'password' => [
                'bail', 'required', 'string', 'validate_password',
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
                'email' => 'Invalid :attribute format.',
                'validate_email' => 'This :attribute is not registered.',
                'validate_password' => 'Invalid :attribute.',
            ];
        }

        $messages = \__('login/validation.messages');

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

        $attributes = \__('login/validation.attributes');

        if (\is_array($attributes)) {
            return $attributes;
        }

        return [];
    }

    /**
     * get the authenticatable user.
     */
    public function getAuthenticatableUser(): User
    {
        return $this->authenticatable;
    }

    /**
     * Determine if the user wants to set a "remember me" cookie.
     */
    public function shouldRemember(): bool
    {
        return $this->boolean('remember', false);
    }

    /**
     * Configure validator.
     */
    protected function withValidator(Validator $validator): void
    {
        $validator->addExtension('validate_email', $this->validateEmail(...));
        $validator->addExtension('validate_password', $this->validatePassword(...));
    }

    /**
     * Validate email.
     */
    private function validateEmail(string $attribute, string $value, array $parameters, Validator $validator): bool
    {
        $this->authenticatable = User::whereEmail($value)->first();

        return $this->authenticatable !== null;
    }

    /**
     * Validate password.
     */
    private function validatePassword(string $attribute, string $value, array $parameters, Validator $validator): bool
    {
        if ($this->authenticatable === null) {
            return true;
        }

        return Hash::check($value, $this->authenticatable->getPassword());
    }
}
