<?php

declare(strict_types=1);

namespace App\Http\Controllers\Concerns\Recipe;

trait AuthorizesRequests
{
    /**
     * {@inheritdoc}
     */
    public function resourceAbilityMap(): array
    {
        return [
            'edit' => 'update',
            'update' => 'update',
        ];
    }
}
