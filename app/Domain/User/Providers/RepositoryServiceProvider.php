<?php

namespace App\Domain\User\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\User\Repositories\Contracts\UserRepositoryInterface;
use App\Domain\User\Repositories\Eloquent\EloquentUserRepository;
use App\Domain\User\Repositories\Caching\CachingUserRepository;
use App\Domain\User\Models\User;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, function ($app) {
            $repository = $app->make(EloquentUserRepository::class);

            return new CachingUserRepository(
                $repository,
                $app['cache.store'],
                $app->make(User::class)
            );
        });
    }
}
