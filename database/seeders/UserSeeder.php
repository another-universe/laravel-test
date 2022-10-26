<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('12345678');
        $i = 0;

        do {
            ++$i;

            (new User())
                ->forceFill([
                    'nick_name' => 'User'.$i,
                    'email' => 'user'.$i.'@example.com',
                    'password' => $password,
                ])
                ->save();
        } while ($i < 20);
    }
}
