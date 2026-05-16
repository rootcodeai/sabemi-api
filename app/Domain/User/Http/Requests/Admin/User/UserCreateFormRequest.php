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
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'string', Rule::in(['admin', 'teacher', 'student'])],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'O campo nome é obrigatório.',
            'name.max'          => 'O nome não pode ter mais de :max caracteres.',
            'email.required'    => 'O campo e-mail é obrigatório.',
            'email.email'       => 'Informe um endereço de e-mail válido.',
            'email.max'         => 'O e-mail não pode ter mais de :max caracteres.',
            'email.unique'      => 'Este e-mail já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min'      => 'A senha deve ter pelo menos :min caracteres.',
            'password.confirmed' => 'A confirmação da senha não confere.',
            'role.required'     => 'O campo perfil é obrigatório.',
            'role.in'           => 'O perfil selecionado é inválido.',
        ];
    }
}
