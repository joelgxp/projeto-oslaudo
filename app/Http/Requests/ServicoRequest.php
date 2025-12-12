<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServicoRequest extends FormRequest
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
        return [
            'cliente_id' => [
                'required',
                'exists:clientes,id',
                function ($attribute, $value, $fail) {
                    $cliente = \App\Models\Cliente::find($value);
                    if ($cliente && $cliente->empresa_id !== auth()->user()->empresa_id) {
                        $fail('O cliente selecionado não pertence à sua empresa.');
                    }
                },
            ],
            'tecnico_id' => [
                'nullable',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $tecnico = \App\Models\User::find($value);
                        if ($tecnico && ($tecnico->empresa_id !== auth()->user()->empresa_id || $tecnico->role !== 'technician')) {
                            $fail('O técnico selecionado é inválido.');
                        }
                    }
                },
            ],
            'tipo_servico' => 'required|string|max:255|min:3',
            'data_agendada' => 'nullable|date|after_or_equal:today',
            'hora_inicio' => 'nullable|date_format:H:i',
            'endereco_servico' => 'nullable|string|max:500',
            'descricao_servico' => 'nullable|string|max:1000',
            'observacoes' => 'nullable|string|max:1000',
            'status' => 'required|in:agendado,em_progresso,concluido,cancelado',
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
            'cliente_id.required' => 'Selecione um cliente.',
            'cliente_id.exists' => 'O cliente selecionado não existe.',
            'tipo_servico.required' => 'O tipo de serviço é obrigatório.',
            'tipo_servico.min' => 'O tipo de serviço deve ter pelo menos 3 caracteres.',
            'data_agendada.after_or_equal' => 'A data agendada não pode ser no passado.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'Status inválido.',
        ];
    }
}
