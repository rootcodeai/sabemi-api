<?php

namespace App\Domain\User\Observers;

use App\Domain\User\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        $user->invalidateCache();
    }

    public function updated(User $user): void
    {
        $user->invalidateCache();
    }

    public function deleted(User $user): void
    {
        $user->invalidateCache();
    }
}
