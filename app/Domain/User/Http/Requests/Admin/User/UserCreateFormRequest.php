<?php

namespace App\Domain\User\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Support\FormRequest\HasValidatedData;
use Illuminate\Validation\Rule;

class UserCreateFormRequest extends FormRequest
{
    use HasValidatedData;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', Rule::in(['admin', 'teacher', 'student'])],
        ];
    }
}
