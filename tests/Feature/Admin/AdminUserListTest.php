<?php

namespace Tests\Feature\Admin;

use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserListTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get(route('admin.users.index'));

        $response->assertRedirect(route('admin.login'));
    }

    public function test_authenticated_user_can_access_users_list(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertOk();
        $response->assertViewIs('admin.users.index');
    }

    public function test_users_list_shows_all_users(): void
    {
        $user = User::factory()->create();
        User::factory(4)->create();

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertOk();
        $response->assertViewHas('users');

        $users = $response->viewData('users');
        $this->assertEquals(5, $users->total());
    }

    public function test_search_filters_by_name(): void
    {
        $user = User::factory()->create();
        User::factory()->create(['name' => 'Carlos Teste']);
        User::factory()->create(['name' => 'Maria Outra']);

        $response = $this->actingAs($user)
            ->get(route('admin.users.index', ['search' => 'Carlos']));

        $response->assertOk();

        $users = $response->viewData('users');
        $this->assertEquals(1, $users->total());
        $this->assertEquals('Carlos Teste', $users->items()[0]->name);
    }

    public function test_search_filters_by_email(): void
    {
        $user = User::factory()->create();
        User::factory()->create(['email' => 'alvo@sabemi.com.br']);
        User::factory()->create(['email' => 'outro@example.com']);

        $response = $this->actingAs($user)
            ->get(route('admin.users.index', ['search' => 'sabemi']));

        $response->assertOk();

        $users = $response->viewData('users');
        $this->assertEquals(1, $users->total());
    }

    public function test_empty_search_returns_all_users(): void
    {
        $user = User::factory()->create();
        User::factory(4)->create();

        $response = $this->actingAs($user)
            ->get(route('admin.users.index', ['search' => '']));

        $response->assertOk();

        $users = $response->viewData('users');
        $this->assertEquals(5, $users->total());
    }

    public function test_invalid_role_filter_returns_validation_error(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('admin.users.index', ['role' => 'superadmin']));

        $response->assertSessionHasErrors('role');
    }
}
