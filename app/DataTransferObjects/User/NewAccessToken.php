<?php

declare(strict_types=1);

namespace App\DataTransferObjects\User;

use Spatie\DataTransferObject\Attributes\Strict;
use Spatie\DataTransferObject\DataTransferObject;

#[Strict]
final class NewAccessToken extends DataTransferObject
{
    public readonly string $token;

    public readonly string $type;

    public readonly ?int $expiresAt;
}
