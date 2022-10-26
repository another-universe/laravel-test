<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

final class RecipeResource extends JsonResource
{
    /**
     * Create a new resource instance.
     */
    public function __construct(Recipe $resource)
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
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'short_description' => $this->getShortDescription(),
            'text' => $this->getText(),
            'created_at' => $this->getCreatedAt(),
            'in_favorites' => $this->getInFavorites(),
            'times_shared' => $this->getTimesShared(),
            'author' => $this->whenLoaded('user', function () {
                if ($this->wasRecentlyCreated) {
                    return new MissingValue();
                }

                return [
                    'id' => $this->getUser()->getId(),
                    'nick_name' => $this->getUser()->getNickName(),
                ];
            }),
        ];
    }
}
