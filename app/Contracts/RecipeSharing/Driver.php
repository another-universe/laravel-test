<?php

declare(strict_types=1);

namespace App\Contracts\RecipeSharing;

use App\Models\Recipe;

interface Driver
{
    public function send(string $sender, string $recipient, Recipe $recipe, string $url);

    public function setConfig(array $config): Driver;
}
