<?php

declare(strict_types=1);

namespace App\Domain\User\Repositories\Caching;

use App\Repositories\BaseCachingRepository;
use App\Domain\User\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Cache\Repository as CacheRepository;
use App\Domain\User\Models\User;

final class CachingUserRepository extends BaseCachingRepository implements UserRepositoryInterface
{
    public function __construct(
        protected UserRepositoryInterface $repository,
        CacheRepository $cache,
        protected User $model
    ) {
        parent::__construct($cache);
    }

    public function index(array $filters = [])
    {
        // Cache list by page and filters
        $page = request()->get('page', 1);
        $key = "users.list." . md5(json_encode($filters)) . ".page.{$page}";
        $tags = [$this->model->getCacheTag()];

        return $this->remember($key, 60, $tags, function () use ($filters) {
            return $this->repository->index($filters);
        });
    }

    public function show(int $id)
    {
        $key = "users.{$id}";
        $tags = [$this->model->getCacheTag(), "users:{$id}"];

        return $this->remember($key, 60, $tags, function () use ($id) {
            return $this->repository->show($id);
        });
    }

    public function findByEmail(string $email)
    {
        return $this->repository->findByEmail($email);
    }

    public function store(array $data)
    {
        return $this->repository->store($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function destroy(int $id)
    {
        return $this->repository->destroy($id);
    }
}
