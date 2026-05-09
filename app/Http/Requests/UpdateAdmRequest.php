<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $admId = $this->route('id');

        return [
            'name' => 'nullable|string',
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users', 'email')->ignore($admId)
            ],
            'password' => 'nullable|string|min:8',
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Nome completo do administrador.',
                'example' => 'João Campos (Moderador)',
            ],
            'email' => [
                'description' => 'Endereço de e-mail único para login.',
                'example' => 'admin.joao@empresa.com',
            ],
            'password' => [
                'description' => 'Nova senha de acesso. Envie apenas se desejar alterar.',
                'example' => 'Senha@2026',
            ],
        ];
    }
}
