<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $clienteId = $this->route('cliente')?->id;

        return [
            'nome' => 'required|string|max:255|min:3',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('clientes', 'email')->ignore($clienteId)->where(function ($query) {
                    return $query->where('empresa_id', auth()->user()->empresa_id);
                }),
            ],
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'estado' => 'nullable|string|size:2|regex:/^[A-Z]{2}$/',
            'cep' => 'nullable|string|max:10|regex:/^\d{5}-?\d{3}$/',
            'tipo_documento' => 'nullable|in:cpf,cnpj',
            'numero_documento' => [
                'nullable',
                'string',
                'max:20',
                function ($attribute, $value, $fail) {
                    if ($this->tipo_documento && $value) {
                        $documento = preg_replace('/[^0-9]/', '', $value);
                        if ($this->tipo_documento === 'cpf' && strlen($documento) !== 11) {
                            $fail('CPF deve ter 11 dígitos.');
                        }
                        if ($this->tipo_documento === 'cnpj' && strlen($documento) !== 14) {
                            $fail('CNPJ deve ter 14 dígitos.');
                        }
                    }
                },
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do cliente é obrigatório.',
            'nome.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'email.email' => 'O email deve ser um endereço válido.',
            'email.unique' => 'Este email já está cadastrado para outro cliente.',
            'estado.size' => 'O estado deve ter 2 caracteres (UF).',
            'estado.regex' => 'O estado deve conter apenas letras maiúsculas.',
            'cep.regex' => 'O CEP deve estar no formato 00000-000 ou 00000000.',
        ];
    }
}
