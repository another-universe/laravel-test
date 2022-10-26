<?php

declare(strict_types=1);

namespace App\DataTransferObjects\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\Attributes\Strict;
use Spatie\DataTransferObject\DataTransferObject;

#[Strict]
final class LoginUserData extends DataTransferObject
{
    public readonly User $user;

    public readonly string $rawPassword;

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            user: $request->getAuthenticatableUser(),
            rawPassword: $request->input('password'),
        );
    }
}
