<?php

declare(strict_types=1);

namespace App\DataTransferObjects\User;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Attributes\MapTo;
use Spatie\DataTransferObject\Attributes\Strict;
use Spatie\DataTransferObject\DataTransferObject;

#[Strict]
final class CreateUserData extends DataTransferObject
{
    #[MapFrom('nick_name')]
    #[MapTo('nick_name')]
    public readonly string $nickName;

    public readonly string $email;

    public readonly string $password;

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            ...$request->validated()
        );
    }
}
