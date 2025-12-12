@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700;">Relatório de Serviços</h1>
        <a href="{{ route('relatorios.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    <!-- Filtros -->
    <form method="GET" action="{{ route('relatorios.servicos') }}" style="margin-bottom: 2rem; padding: 1.5rem; background-color: #f9fafb; border-radius: 0.5rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Status</label>
                <select name="status" class="form-input">
                    <option value="">Todos</option>
                    <option value="agendado" {{ request('status') === 'agendado' ? 'selected' : '' }}>Agendado</option>
                    <option value="em_progresso" {{ request('status') === 'em_progresso' ? 'selected' : '' }}>Em Progresso</option>
                    <option value="concluido" {{ request('status') === 'concluido' ? 'selected' : '' }}>Concluído</option>
                    <option value="cancelado" {{ request('status') === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Data Início</label>
                <input type="date" name="data_inicio" class="form-input" value="{{ request('data_inicio') }}">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Data Fim</label>
                <input type="date" name="data_fim" class="form-input" value="{{ request('data_fim') }}">
            </div>
        </div>
        <div style="margin-top: 1rem;">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="{{ route('relatorios.servicos') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </form>

    <!-- Tabela de Serviços -->
    @if($servicos->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Cliente</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Tipo</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Técnico</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Data</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Status</th>
                        <th style="padding: 0.75rem; text-align: center; font-weight: 600;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicos as $servico)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 0.75rem;">{{ $servico->cliente->nome }}</td>
                            <td style="padding: 0.75rem;">{{ $servico->tipo_servico }}</td>
                            <td style="padding: 0.75rem;">{{ $servico->tecnico->name ?? '-' }}</td>
                            <td style="padding: 0.75rem;">{{ $servico->created_at->format('d/m/Y') }}</td>
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
                            <td style="padding: 0.75rem; text-align: center;">
                                <a href="{{ route('servicos.show', $servico) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Ver</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 2rem; padding: 1rem; background-color: #f9fafb; border-radius: 0.5rem;">
            <p><strong>Total de Serviços:</strong> {{ $servicos->count() }}</p>
        </div>
    @else
        <div style="text-align: center; padding: 3rem; color: #6b7280;">
            <p style="font-size: 1.125rem;">Nenhum serviço encontrado com os filtros aplicados.</p>
        </div>
    @endif
</div>
@endsection

