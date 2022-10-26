<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Recipe;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Attributes\MapTo;
use Spatie\DataTransferObject\Attributes\Strict;
use Spatie\DataTransferObject\DataTransferObject;

#[Strict]
final class CreateRecipeData extends DataTransferObject
{
    public readonly string $title;

    #[MapFrom('short_description')]
    #[MapTo('short_description')]
    public readonly ?string $shortDescription;

    public readonly string $text;

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            ...$request->validated(),
        );
    }
}
