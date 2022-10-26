<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Actions\User\LoginUserAction;
use App\DataTransferObjects\User\LoginUserData;
use App\Http\Requests\User\LoginRequest;
use App\Kernel\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

final class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    /**
     * Show login page.
     */
    public function showLoginPage(): Response
    {
        return \response()->view('login.login-page');
    }

    /**
     * Handle login attempt.
     */
    public function handle(LoginRequest $request): RedirectResponse
    {
        $data = LoginUserData::fromRequest($request);

        \app(LoginUserAction::class)
            ->viaSession($request->shouldRemember())
            ->execute($data);

        return \redirect()->intended();
    }
}
