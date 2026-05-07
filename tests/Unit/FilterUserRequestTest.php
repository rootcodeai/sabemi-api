<?php

namespace Tests\Unit;

use App\Domain\User\Http\Requests\Admin\User\FilterUserRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class FilterUserRequestTest extends TestCase
{
    private function validate(array $data): \Illuminate\Validation\Validator
    {
        $request = new FilterUserRequest();
        return Validator::make($data, $request->rules());
    }

    public function test_all_fields_are_optional(): void
    {
        $validator = $this->validate([]);

        $this->assertFalse($validator->fails());
    }

    public function test_valid_search_passes(): void
    {
        $validator = $this->validate(['search' => 'Carlos']);

        $this->assertFalse($validator->fails());
    }

    public function test_search_exceeding_max_length_fails(): void
    {
        $validator = $this->validate(['search' => str_repeat('a', 256)]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('search', $validator->errors()->toArray());
    }

    public function test_valid_roles_pass(): void
    {
        foreach (['admin', 'teacher', 'student'] as $role) {
            $validator = $this->validate(['role' => $role]);
            $this->assertFalse($validator->fails(), "Role '{$role}' should be valid");
        }
    }

    public function test_invalid_role_fails(): void
    {
        $validator = $this->validate(['role' => 'superadmin']);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('role', $validator->errors()->toArray());
    }

    public function test_valid_per_page_passes(): void
    {
        $validator = $this->validate(['per_page' => 50]);

        $this->assertFalse($validator->fails());
    }

    public function test_per_page_above_100_fails(): void
    {
        $validator = $this->validate(['per_page' => 101]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('per_page', $validator->errors()->toArray());
    }

    public function test_per_page_zero_fails(): void
    {
        $validator = $this->validate(['per_page' => 0]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('per_page', $validator->errors()->toArray());
    }

    public function test_page_must_be_integer(): void
    {
        $validator = $this->validate(['page' => 'abc']);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('page', $validator->errors()->toArray());
    }

    public function test_page_minimum_is_one(): void
    {
        $validator = $this->validate(['page' => 0]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('page', $validator->errors()->toArray());
    }
}
