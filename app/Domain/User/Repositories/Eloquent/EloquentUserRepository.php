<?php

declare(strict_types=1);

namespace App\Domain\User\Repositories\Eloquent;

use App\Domain\User\Repositories\Contracts\UserRepositoryInterface;
use App\Domain\User\Models\User;

final class EloquentUserRepository implements UserRepositoryInterface
{
    public function index(array $filters = [])
    {
        $query = User::query();
        
        if (isset($filters['role'])) {
            $query->where('role', $filters['role']);
        }
        
        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                  ->orWhere('email', 'like', "%{$filters['search']}%");
            });
        }

        return $query->orderBy('name')->paginate($filters['per_page'] ?? 15);
    }

    public function store(array $data)
    {
        return User::create($data);
    }

    public function show(int $id)
    {
        return User::findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user->fresh();
    }

    public function destroy(int $id)
    {
        $user = User::findOrFail($id);
        return $user->delete();
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}
