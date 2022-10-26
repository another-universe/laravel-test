<?php

declare(strict_types=1);

namespace App\Kernel\Validation;

use Closure;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Str;

abstract class Rule implements InvokableRule, ValidatorAwareRule
{
    protected ?Validator $validator = null;

    protected ?string $message = null;

    /**
     * We should be able to use each rule both by creating an object: ['attribute_name' => [(new MyRule())->setParamName($value)]]]
     * So and use the rule as a string: ['attribute_name' => ['my_rule:param=value']]
     * To do this, we prohibit passing any data to the rule through the constructor.
     */
    final public function __construct()
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  Closure  $fail
     */
    public function __invoke($attribute, $value, $fail): void
    {
        $parameters = $this->getParameters();

        if ($this->validate($attribute, $value, $parameters, $this->validator) === false) {
            $message = $this->getMessage();
            $fail($message);
        }
    }

    /**
     * Set the current validator.
     *
     * @param  Validator  $validator
     */
    public function setValidator($validator): static
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Validate attribute.
     */
    abstract public function validate(string $attribute, mixed $value, array $parameters, Validator $validator): bool;

    /**
     * Set message for validation rule.
     */
    public function message(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message.
     */
    protected function getMessage(): string
    {
        if ($this->message === null) {
            $message = 'validation.'.$this->getRuleName();

            return $this->validator->getTranslator()->get($message);
        }

        $message = $this->validator->customMessages[$this->message] ?? null;

        if ($message === null) {
            $message = $this->validator->getTranslator()->get($this->message);
        }

        return $message;
    }

    /**
     * Get name of validation rule.
     */
    protected function getRuleName(): string
    {
        return Str::snake(\class_basename($this), '_');
    }

    /**
     * Get rule parameters.
     */
    protected function getParameters(): array
    {
        return [];
    }
}
