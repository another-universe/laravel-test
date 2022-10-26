<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\User\CreateUserAction;
use App\DataTransferObjects\User\CreateUserData;
use App\Http\Requests\User\RegisterRequest;
use App\Kernel\Routing\Controller;
use Illuminate\Http\JsonResponse;

final class RegisterController extends Controller
{
    /**
     * Handle register attempt.
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $data = CreateUserData::fromRequest($request);

        \app(CreateUserAction::class)
            ->execute($data);

        return \response()->json(['message' => 'User was created.'], 201);
    }
}
