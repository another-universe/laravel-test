<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Recipe;

use App\Enums\Recipe\RecipeSharingChannel;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\Strict;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

#[Strict]
final class ShareRecipeData extends DataTransferObject
{
    #[CastWith(EnumCaster::class, RecipeSharingChannel::class)]
    public readonly RecipeSharingChannel $channel;

    public readonly ?string $sender;

    public readonly string $recipient;

    public static function fromRequest(FormRequest $request): self
    {
        $data = $request->validated() + ['sender' => null];

        return new self(...$data);
    }
}
