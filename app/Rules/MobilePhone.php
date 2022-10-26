<?php

declare(strict_types=1);

namespace App\Rules;

use App\Kernel\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Propaganistas\LaravelPhone\Validation\Phone;

final class MobilePhone extends Rule
{
    /**
     * Validate attribute.
     */
    public function validate(string $attribute, mixed $value, array $parameters, Validator $validator): bool
    {
        $phoneRuleInstance = \app(Phone::class);

        return $phoneRuleInstance->validate($attribute, $value, [1, 'AUTO'], $validator);
    }
}
