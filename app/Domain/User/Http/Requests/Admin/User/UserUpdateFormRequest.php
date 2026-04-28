<?php

namespace App\Domain\User\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Support\FormRequest\HasValidatedData;
use Illuminate\Validation\Rule;

class UserUpdateFormRequest extends FormRequest
{
    use HasValidatedData;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => [
                'sometimes', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users')->ignore($this->route('id'))
            ],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
            'role' => ['sometimes', 'string', Rule::in(['admin', 'teacher', 'student'])],
        ];
    }
}
