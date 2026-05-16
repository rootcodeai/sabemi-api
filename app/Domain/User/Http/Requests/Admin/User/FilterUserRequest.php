<?php

namespace App\Domain\User\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Support\FormRequest\HasValidatedData;

class FilterUserRequest extends FormRequest
{
    use HasValidatedData;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'in:admin,teacher,student'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'search.max'       => 'O campo de busca não pode ter mais de :max caracteres.',
            'role.in'          => 'O perfil selecionado é inválido.',
            'page.integer'     => 'A página deve ser um número inteiro.',
            'page.min'         => 'A página deve ser no mínimo :min.',
            'per_page.integer' => 'A quantidade por página deve ser um número inteiro.',
            'per_page.min'     => 'A quantidade por página deve ser no mínimo :min.',
            'per_page.max'     => 'A quantidade por página não pode ser maior que :max.',
        ];
    }

    public function getFilters(): array
    {
        return $this->validated();
    }
}
