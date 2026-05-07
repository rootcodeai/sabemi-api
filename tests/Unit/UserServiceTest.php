<?php

namespace Tests\Unit;

use App\Domain\User\Repositories\Contracts\UserRepositoryInterface;
use App\Domain\User\Services\UserService;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserRepositoryInterface $repository;
    private UserService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(UserRepositoryInterface::class);
        $this->service = new UserService($this->repository);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_index_delegates_to_repository(): void
    {
        $filters = ['search' => 'João'];
        $paginator = new LengthAwarePaginator([], 0, 15);

        $this->repository
            ->shouldReceive('index')
            ->once()
            ->with($filters)
            ->andReturn($paginator);

        $result = $this->service->index($filters);

        $this->assertSame($paginator, $result);
    }

    public function test_index_passes_empty_filters_by_default(): void
    {
        $paginator = new LengthAwarePaginator([], 0, 15);

        $this->repository
            ->shouldReceive('index')
            ->once()
            ->with([])
            ->andReturn($paginator);

        $result = $this->service->index();

        $this->assertSame($paginator, $result);
    }

    public function test_store_delegates_to_repository(): void
    {
        $data = ['name' => 'João', 'email' => 'joao@example.com', 'password' => 'secret'];
        $user = (object) $data;

        $this->repository
            ->shouldReceive('store')
            ->once()
            ->with($data)
            ->andReturn($user);

        $result = $this->service->store($data);

        $this->assertSame($user, $result);
    }

    public function test_show_delegates_to_repository(): void
    {
        $user = (object) ['id' => 1, 'name' => 'João'];

        $this->repository
            ->shouldReceive('show')
            ->once()
            ->with(1)
            ->andReturn($user);

        $result = $this->service->show(1);

        $this->assertSame($user, $result);
    }

    public function test_update_delegates_to_repository(): void
    {
        $data = ['name' => 'Novo Nome'];
        $user = (object) ['id' => 1, 'name' => 'Novo Nome'];

        $this->repository
            ->shouldReceive('update')
            ->once()
            ->with(1, $data)
            ->andReturn($user);

        $result = $this->service->update(1, $data);

        $this->assertSame($user, $result);
    }

    public function test_destroy_delegates_to_repository(): void
    {
        $this->repository
            ->shouldReceive('destroy')
            ->once()
            ->with(1)
            ->andReturn(true);

        $result = $this->service->destroy(1);

        $this->assertTrue($result);
    }
}
