@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700;">Detalhes do Cliente</h1>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #2563eb;">Informações Pessoais</h2>
            <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                <p style="margin-bottom: 0.75rem;"><strong>Nome:</strong> {{ $cliente->nome }}</p>
                <p style="margin-bottom: 0.75rem;"><strong>Email:</strong> {{ $cliente->email ?? '-' }}</p>
                <p style="margin-bottom: 0.75rem;"><strong>Telefone:</strong> {{ $cliente->telefone ?? '-' }}</p>
                @if($cliente->tipo_documento && $cliente->numero_documento)
                    <p style="margin-bottom: 0.75rem;"><strong>{{ strtoupper($cliente->tipo_documento) }}:</strong> {{ $cliente->numero_documento }}</p>
                @endif
                @if($cliente->data_criacao)
                    <p style="margin-bottom: 0.75rem;"><strong>Data de Cadastro:</strong> {{ $cliente->data_criacao->format('d/m/Y') }}</p>
                @endif
            </div>
        </div>

        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #2563eb;">Endereço</h2>
            <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                <p style="margin-bottom: 0.75rem;">
                    @if($cliente->endereco)
                        {{ $cliente->endereco }}
                        @if($cliente->numero), {{ $cliente->numero }}@endif
                        @if($cliente->complemento) - {{ $cliente->complemento }}@endif
                    @else
                        -
                    @endif
                </p>
                <p style="margin-bottom: 0.75rem;">
                    @if($cliente->cidade)
                        {{ $cliente->cidade }}
                        @if($cliente->estado), {{ $cliente->estado }}@endif
                    @else
                        -
                    @endif
                </p>
                @if($cliente->cep)
                    <p style="margin-bottom: 0.75rem;"><strong>CEP:</strong> {{ $cliente->cep }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Histórico de Serviços -->
    <div style="margin-top: 3rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #2563eb;">Histórico de Serviços</h2>
        @if($cliente->servicos->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                            <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Tipo</th>
                            <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Data Agendada</th>
                            <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cliente->servicos as $servico)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 0.75rem;">{{ $servico->tipo_servico }}</td>
                                <td style="padding: 0.75rem;">{{ $servico->data_agendada ? $servico->data_agendada->format('d/m/Y') : '-' }}</td>
                                <td style="padding: 0.75rem;">
                                    @php
                                        $statusColors = [
                                            'agendado' => '#3b82f6',
                                            'em_progresso' => '#f59e0b',
                                            'concluido' => '#10b981',
                                            'cancelado' => '#ef4444'
                                        ];
                                        $statusLabels = [
                                            'agendado' => 'Agendado',
                                            'em_progresso' => 'Em Progresso',
                                            'concluido' => 'Concluído',
                                            'cancelado' => 'Cancelado'
                                        ];
                                    @endphp
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 0.25rem; background-color: {{ $statusColors[$servico->status] ?? '#6b7280' }}; color: white; font-size: 0.875rem;">
                                        {{ $statusLabels[$servico->status] ?? $servico->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem; text-align: center; color: #6b7280;">
                <p>Nenhum serviço registrado para este cliente.</p>
            </div>
        @endif
    </div>
</div>
@endsection

