<?php

declare(strict_types=1);

namespace App\Jobs\Recipe;

use App\Contracts\RecipeSharing\Factory;
use App\DataTransferObjects\Recipe\ShareRecipeData;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Traits\Localizable;

final class ShareRecipeJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Localizable;

    public $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private User $user,
        private Recipe $recipe,
        private ShareRecipeData $data,
        private ?string $locale = null,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(Factory $manager, UrlGenerator $urlGenerator): void
    {
        $this->withLocale($this->locale, function () use ($manager, $urlGenerator) {
            $sender = $this->data->sender ?? "{$this->user->getNickName()} <{$this->user->getEmail()}>";

            $url = $urlGenerator->route('recipes.show', [
                'recipe' => $this->recipe,
                'utm_source' => $this->data->channel,
            ]);

            $manager
                ->driver($this->data->channel)
                ->send($sender, $this->data->recipient, $this->recipe, $url);

            \rescue(function () {
                Recipe::withoutTimestamps(fn () => $this->recipe->increment('times_shared'));
            });
        });
    }

    /**
     * The unique id for job.
     */
    public function uniqueId(): string
    {
        $payload = "{$this->user->getId()},{$this->recipe->getId()},{$this->data->recipient},{$this->data->channel}";

        return \hash('md5', self::class.':'.$payload);
    }
}
