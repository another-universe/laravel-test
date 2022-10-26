<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \app('db.connection')->transaction(function () {
            $this->call([
                UserSeeder::class,
                RecipeSeeder::class,
            ]);
        });
    }
}
