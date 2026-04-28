<?php

namespace App\Domain\User\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function index(array $filters = []);
    public function store(array $data);
    public function show(int $id);
    public function update(int $id, array $data);
    public function destroy(int $id);
    public function findByEmail(string $email);
}
