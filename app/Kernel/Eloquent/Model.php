<?php

declare(strict_types=1);

namespace App\Kernel\Eloquent;

use App\Kernel\Eloquent\Concerns\HasOverrites;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    use HasOverrites;
    use HasFactory;
}
