<?php

namespace Tests\Feature;

use App\Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserDomainTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_authenticate()
    {
        $user = User::factory()->create([
            'password' => 'password',
        ]);

        $response = $this->postJson(route('api.v1.auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['access_token', 'token_type', 'user']);
    }

    public function test_can_refresh_token()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson(route('api.v1.auth.refresh'));

        $response->assertOk()
            ->assertJsonStructure(['access_token', 'token_type', 'user']);

        // Check if old token is invalid (optional, depending on implementation)
        // In my implementation, I delete currentAccessToken()
        // But verifying that here requires database check or another request.
        $this->assertDatabaseMissing('personal_access_tokens', [
            'token' => hash('sha256', explode('|', $token)[1]),
        ]);
    }

    public function test_admin_can_list_users()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory(5)->create();

        $response = $this->actingAs($admin)
            ->getJson(route('api.v1.admin.users.index'));

        $response->assertOk()
            ->assertJsonCount(6, 'data') // 5 created + 1 admin
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'email', 'role']
                ],
                'meta'
            ]);
    }

    public function test_admin_can_create_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $data = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'student',
        ];

        $response = $this->actingAs($admin)
            ->postJson(route('api.v1.admin.users.store'), $data);

        $response->assertCreated()
            ->assertJsonFragment(['name' => 'New User', 'email' => 'newuser@example.com']);

        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);
    }

    public function test_admin_can_update_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $data = [
            'name' => 'Updated Name',
        ];

        $response = $this->actingAs($admin)
            ->putJson(route('api.v1.admin.users.update', $user->id), $data);

        $response->assertOk()
            ->assertJsonFragment(['name' => 'Updated Name']);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated Name']);
    }

    public function test_admin_can_delete_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)
            ->deleteJson(route('api.v1.admin.users.destroy', $user->id));

        $response->assertOk();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
