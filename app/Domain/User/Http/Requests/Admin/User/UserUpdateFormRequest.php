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
            'name'     => ['sometimes', 'string', 'max:255'],
            'email'    => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->route('id'))],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
            'role'     => ['sometimes', 'string', Rule::in(['admin', 'teacher', 'student'])],
        ];
    }

    public function messages(): array
    {
        return [
            'name.max'           => 'O nome não pode ter mais de :max caracteres.',
            'email.email'        => 'Informe um endereço de e-mail válido.',
            'email.max'          => 'O e-mail não pode ter mais de :max caracteres.',
            'email.unique'       => 'Este e-mail já está em uso.',
            'password.min'       => 'A senha deve ter pelo menos :min caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
            'role.in'            => 'O perfil selecionado é inválido.',
        ];
    }
}
