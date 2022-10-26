<?php

declare(strict_types=1);

namespace App\Jobs\Recipe;

use App\DataTransferObjects\Recipe\ShareRecipeData;
use App\Models\Recipe;
use App\Models\User;
use App\Notifications\Recipe\ShareRecipeNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

final class ShareRecipeJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

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
    public function handle(): void
    {
        $sender = $this->data->sender ?? "{$this->user->getNickName()} <{$this->user->getEmail()}>";

        $url = \route('recipes.show', [
            'recipe' => $this->recipe,
            'utm_source' => $this->data->channel->value,
        ]);

        $notification = new ShareRecipeNotification($sender, $this->recipe, $url);

        Notification::route(
            $this->data->channel->value,
            $this->data->recipient
        )
            ->notifyNow($notification->locale($this->locale));

        \rescue(function () {
            Recipe::withoutTimestamps(fn () => $this->recipe->increment('times_shared'));
        });
    }

    /**
     * The unique id for job.
     */
    public function uniqueId(): string
    {
        $payload = "{$this->user->getId()},{$this->recipe->getId()},{$this->data->recipient},{$this->data->channel->value}";

        return \hash('md5', self::class.':'.$payload);
    }
}
