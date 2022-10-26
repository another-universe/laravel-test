<?php

declare(strict_types=1);

namespace App\Services\RecipeSharing\Drivers;

use App\Contracts\RecipeSharing\Driver;
use App\Models\Recipe;

final class TelegramDriver implements Driver
{
    private array $config = [];

    public function send(string $sender, string $recipient, Recipe $recipe, string $url): void
    {
        // Do some stuff...
    }

    public function setConfig(array $config): self
    {
        $this->config = $config;

        return $this;
    }
}
