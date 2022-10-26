<?php

declare(strict_types=1);

use App\Services\RecipeSharing\Drivers\MailDriver;
use App\Services\RecipeSharing\Drivers\TelegramDriver;
use App\Services\RecipeSharing\Drivers\ViberDriver;

return [
    'default' => 'mail',

    'drivers' => [
        'mail' => [
            'class' => MailDriver::class,
            'name' => 'email',
            // Something else...
        ],

        'telegram' => [
            'class' => TelegramDriver::class,
            'name' => 'telegram',
            // Something else...
        ],

        'viber' => [
            'class' => ViberDriver::class,
            'name' => 'viber',
            // Something else...
        ],
    ],
];
