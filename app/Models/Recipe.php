<?php

declare(strict_types=1);

namespace App\Models;

use App\Kernel\Eloquent\Model;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Recipe
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $title
 * @property string|null $short_description
 * @property string $text
 * @property int $in_favorites
 * @property int $times_shared
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe query()
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereInFavorites($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereTimesShared($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereUserId($value)
 * @mixin \Eloquent
 */
final class Recipe extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recipes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'short_description',
        'text',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 30;

    /* | Getters and setters. | */

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->short_description = $shortDescription;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getInFavorites(): int
    {
        return $this->in_favorites;
    }

    public function getTimesShared(): int
    {
        return $this->times_shared;
    }

    public function getCreatedAt(): CarbonInterface
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): CarbonInterface
    {
        return $this->updated_at;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    /* | Accessors and mutators. | */

    public function getInFavoritesAttribute(?int $value): int
    {
        return $value ?? 0;
    }

    public function getTimesSharedAttribute(?int $value): int
    {
        return $value ?? 0;
    }

    /* | Relationships. | */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
