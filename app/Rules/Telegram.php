<?php

declare(strict_types=1);

namespace App\Rules;

use App\Kernel\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;

final class Telegram extends Rule
{
    /**
     * Validate attribute.
     */
    public function validate(string $attribute, mixed $value, array $parameters, Validator $validator): bool
    {
        $userNamePattern = '~^(?!.*?__)@[a-z]{1}[a-z\\d\\_]{3,33}[a-z]{1}$~iu';

        if (\preg_match($userNamePattern, $value) === 1) {
            return true;
        }

        $phoneRuleInstance = \app(MobilePhone::class);

        return $phoneRuleInstance->validate($attribute, $value, [], $validator);
    }
}
