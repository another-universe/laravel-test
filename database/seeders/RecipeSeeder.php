<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;

final class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 200;
        $users = User::pluck('id');
        $dates = $this->dates($count);
        $faker = \fake('en_US');

        for ($i = 0; $i < $count; ++$i) {
            $recipe = new Recipe();
            $recipe->forceFill([
                'title' => $faker->unique()->sentence(5),
                'short_description' => $faker->optional(0.7)->realText(200),
                'text' => $faker->realText(1000),
                'created_at' => $date = \array_pop($dates),
                'updated_at' => $date,
            ]);
            $recipe->user()->associate($users->shuffle()->random());
            Recipe::withoutTimestamps(static fn () => $recipe->save());
        }
    }

    private function dates(int $count): array
    {
        $dates = [];

        for ($i = 0; $i < $count; ++$i) {
            $seconds = (\random_int(20, 40) * 60) - \random_int(0, 60);
            $dates[] = (\end($dates) ?: \now())->subSeconds($seconds);
        }

        return $dates;
    }
}
