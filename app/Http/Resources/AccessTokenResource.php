<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\DataTransferObjects\User\NewAccessToken;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class AccessTokenResource extends JsonResource
{
    /**
     * Create a new resource instance.
     */
    public function __construct(NewAccessToken $resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     */
    public function toArray($request): array
    {
        return [
            'access_token' => $this->token,
            'type' => $this->type,
            'expires_at' => $this->whenNotNull($this->expiresAt),
        ];
    }
}
