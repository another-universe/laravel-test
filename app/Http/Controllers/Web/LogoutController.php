<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Actions\User\LogoutUserAction;
use App\Kernel\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
     * Logout current device.
     */
    public function logoutCurrentDevice(Request $request): RedirectResponse
    {
        \app(LogoutUserAction::class)
            ->logoutCurrentDevice()
            ->execute($request->user());

        return \redirect()->route('home');
    }
}
