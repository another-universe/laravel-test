<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\User\LogoutUserAction;
use App\Kernel\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class LogoutController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Revoke current access token.
     */
    public function revokeCurrentAccessToken(Request $request): Response
    {
        \app(LogoutUserAction::class)
            ->revokeCurrentAccessToken()
            ->execute($request->user());

        return \response()->noContent();
    }
}
