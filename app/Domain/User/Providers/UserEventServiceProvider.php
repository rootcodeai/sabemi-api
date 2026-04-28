<?php

namespace App\Domain\User\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Domain\User\Models\User;
use App\Domain\User\Observers\UserObserver;

class UserEventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();
        User::observe(UserObserver::class);
    }
}
