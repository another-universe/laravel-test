<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

final class PageHeader extends Component
{
    private ?User $user;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->user = \auth()->user();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        if ($this->user === null) {
            return $this->renderGuestView();
        }

        return $this->renderUserView();
    }

    private function renderGuestView(): View
    {
        return \view('components.page-header.guest');
    }

    private function renderUserView(): View
    {
        return \view('components.page-header.user');
    }
}
