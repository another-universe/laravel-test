<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\User\LoginUserAction;
use App\DataTransferObjects\User\LoginUserData;
use App\DataTransferObjects\User\NewAccessToken;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\AccessTokenResource;
use App\Kernel\Routing\Controller;
use Illuminate\Http\JsonResponse;

final class LoginController extends Controller
{
    /**
     * Handle login attempt.
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $data = LoginUserData::fromRequest($request);

        /** @var NewAccessToken */
        $token = \app(LoginUserAction::class)
            ->viaToken($request->userAgent() ?: 'UNKNOWN')
            ->execute($data);

        return AccessTokenResource::make($token)->response();
    }
}
