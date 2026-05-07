<?php

namespace Tests\Feature\Admin;

use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertOk();
    }

    public function test_authenticated_user_is_redirected_from_login(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.login'));

        $response->assertRedirect();
    }

    public function test_login_with_valid_credentials_redirects_to_home(): void
    {
        $user = User::factory()->create(['password' => 'password']);

        $response = $this->post(route('admin.login'), [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.home'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_invalid_password_returns_error(): void
    {
        $user = User::factory()->create(['password' => 'password']);

        $response = $this->post(route('admin.login'), [
            'email'    => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_with_nonexistent_email_returns_error(): void
    {
        $response = $this->post(route('admin.login'), [
            'email'    => 'naoexiste@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_requires_email(): void
    {
        $response = $this->post(route('admin.login'), [
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_login_requires_password(): void
    {
        $response = $this->post(route('admin.login'), [
            'email' => 'admin@example.com',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_logout_unauthenticates_user_and_redirects_to_login(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}
