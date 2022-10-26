<?php

declare(strict_types=1);

namespace App\Kernel\Eloquent;

use App\Kernel\Eloquent\Concerns\HasOverrites;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;

abstract class AuthenticatableModel extends User
{
    use HasOverrites;
    use HasFactory;
}
