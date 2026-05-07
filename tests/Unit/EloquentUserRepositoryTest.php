<?php

namespace Tests\Unit;

use App\Domain\User\Models\User;
use App\Domain\User\Repositories\Eloquent\EloquentUserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class EloquentUserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private EloquentUserRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentUserRepository();
    }

    public function test_index_returns_paginator(): void
    {
        User::factory(3)->create();

        $result = $this->repository->index([]);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertCount(3, $result->items());
    }

    public function test_index_filters_by_search_on_name(): void
    {
        User::factory()->create(['name' => 'Carlos Silva']);
        User::factory()->create(['name' => 'Maria Souza']);

        $result = $this->repository->index(['search' => 'Carlos']);

        $this->assertCount(1, $result->items());
        $this->assertEquals('Carlos Silva', $result->items()[0]->name);
    }

    public function test_index_filters_by_search_on_email(): void
    {
        User::factory()->create(['email' => 'carlos@example.com']);
        User::factory()->create(['email' => 'maria@example.com']);

        $result = $this->repository->index(['search' => 'carlos@']);

        $this->assertCount(1, $result->items());
        $this->assertEquals('carlos@example.com', $result->items()[0]->email);
    }

    public function test_index_filters_by_role(): void
    {
        User::factory(2)->create(['role' => 'admin']);
        User::factory(3)->create(['role' => 'student']);

        $result = $this->repository->index(['role' => 'admin']);

        $this->assertCount(2, $result->items());
    }

    public function test_index_role_and_search_filters_are_combined(): void
    {
        User::factory()->create(['name' => 'Carlos Admin', 'role' => 'admin']);
        User::factory()->create(['name' => 'Carlos Student', 'role' => 'student']);

        $result = $this->repository->index(['role' => 'admin', 'search' => 'Carlos']);

        $this->assertCount(1, $result->items());
        $this->assertEquals('admin', $result->items()[0]->role);
    }

    public function test_index_returns_ordered_by_name(): void
    {
        User::factory()->create(['name' => 'Zélia']);
        User::factory()->create(['name' => 'Ana']);
        User::factory()->create(['name' => 'Marcos']);

        $result = $this->repository->index([]);
        $names = array_column($result->items(), 'name');

        $this->assertEquals(['Ana', 'Marcos', 'Zélia'], $names);
    }

    public function test_index_respects_per_page_filter(): void
    {
        User::factory(10)->create();

        $result = $this->repository->index(['per_page' => 3]);

        $this->assertCount(3, $result->items());
        $this->assertEquals(10, $result->total());
    }

    public function test_store_creates_user_with_hashed_password(): void
    {
        $data = [
            'name' => 'Novo Usuário',
            'email' => 'novo@example.com',
            'password' => 'secret123',
            'role' => 'student',
        ];

        $user = $this->repository->store($data);

        $this->assertDatabaseHas('users', ['email' => 'novo@example.com']);
        $this->assertNotEquals('secret123', $user->password);
    }

    public function test_show_returns_user_by_id(): void
    {
        $created = User::factory()->create();

        $user = $this->repository->show($created->id);

        $this->assertEquals($created->id, $user->id);
    }

    public function test_show_throws_when_user_not_found(): void
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->repository->show(999);
    }

    public function test_update_changes_user_data(): void
    {
        $user = User::factory()->create(['name' => 'Nome Antigo']);

        $updated = $this->repository->update($user->id, ['name' => 'Nome Novo']);

        $this->assertEquals('Nome Novo', $updated->name);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Nome Novo']);
    }

    public function test_destroy_removes_user(): void
    {
        $user = User::factory()->create();

        $this->repository->destroy($user->id);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_find_by_email_returns_user(): void
    {
        User::factory()->create(['email' => 'alvo@example.com']);

        $user = $this->repository->findByEmail('alvo@example.com');

        $this->assertEquals('alvo@example.com', $user->email);
    }

    public function test_find_by_email_returns_null_when_not_found(): void
    {
        $user = $this->repository->findByEmail('naoexiste@example.com');

        $this->assertNull($user);
    }
}
