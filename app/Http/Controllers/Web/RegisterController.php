<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Actions\User\CreateUserAction;
use App\DataTransferObjects\User\CreateUserData;
use App\Http\Requests\User\RegisterRequest;
use App\Kernel\Routing\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

final class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    /**
     * Show register page.
     */
    public function showRegisterPage(): Response
    {
        return \response()->view('register.register-page');
    }

    /**
     * Handle register attempt.
     */
    public function handle(RegisterRequest $request): RedirectResponse
    {
        $data = CreateUserData::fromRequest($request);

        \app(CreateUserAction::class)
            ->onCreated(static fn (User $user) => \auth()->login($user, false))
            ->execute($data);

        return \redirect()->route('home');
    }
}
