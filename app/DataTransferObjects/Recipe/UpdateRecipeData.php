<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Recipe;

use App\Support\DataTransferObjects\MayHaveMissingValues;
use App\Support\DataTransferObjects\MissingValue;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Attributes\MapTo;
use Spatie\DataTransferObject\Attributes\Strict;
use Spatie\DataTransferObject\DataTransferObject;

#[Strict]
final class UpdateRecipeData extends DataTransferObject
{
    use MayHaveMissingValues;

    public readonly string|MissingValue $title;

    #[MapFrom('short_description')]
    #[MapTo('short_description')]
    public readonly string|null|MissingValue $shortDescription;

    public readonly string|MissingValue $text;

    public static function fromRequest(FormRequest $request): self
    {
        $data = self::ensureMissingValues($request->validated());

        return new self(...$data);
    }
}
