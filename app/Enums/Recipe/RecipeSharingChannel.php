<?php

declare(strict_types=1);

namespace App\Enums\Recipe;

enum RecipeSharingChannel: string
{
    case mail = 'mail';
    case telegram = 'telegram';
    case viber = 'viber';

    public function displayableName(): string
    {
        if ($this === self::mail) {
            return 'email';
        }

        return $this->name;
    }
}
