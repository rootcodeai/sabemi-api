<?php

declare(strict_types=1);

namespace App\Domain\User\Services;

use App\Domain\User\Repositories\Contracts\UserRepositoryInterface;

final class UserService
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {}

    public function index(array $filters = [])
    {
        return $this->repository->index($filters);
    }

    public function store(array $data)
    {
        return $this->repository->store($data);
    }

    public function show(int $id)
    {
        return $this->repository->show($id);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function destroy(int $id)
    {
        return $this->repository->destroy($id);
    }

    public function findByEmail(string $email)
    {
        return $this->repository->findByEmail($email);
    }
}
