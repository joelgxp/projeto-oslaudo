@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700;">Relatório de Laudos</h1>
        <a href="{{ route('relatorios.index') }}" class="btn btn-secondary">Voltar</a>
    </div>

    <!-- Filtros -->
    <form method="GET" action="{{ route('relatorios.laudos') }}" style="margin-bottom: 2rem; padding: 1.5rem; background-color: #f9fafb; border-radius: 0.5rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Status</label>
                <select name="status" class="form-input">
                    <option value="">Todos</option>
                    <option value="rascunho" {{ request('status') === 'rascunho' ? 'selected' : '' }}>Rascunho</option>
                    <option value="enviado" {{ request('status') === 'enviado' ? 'selected' : '' }}>Enviado</option>
                    <option value="assinado" {{ request('status') === 'assinado' ? 'selected' : '' }}>Assinado</option>
                    <option value="arquivado" {{ request('status') === 'arquivado' ? 'selected' : '' }}>Arquivado</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Assinado</label>
                <select name="assinado" class="form-input">
                    <option value="">Todos</option>
                    <option value="1" {{ request('assinado') === '1' ? 'selected' : '' }}>Sim</option>
                    <option value="0" {{ request('assinado') === '0' ? 'selected' : '' }}>Não</option>
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
            <a href="{{ route('relatorios.laudos') }}" class="btn btn-secondary">Limpar</a>
        </div>
    </form>

    <!-- Tabela de Laudos -->
    @if($laudos->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Cliente</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Serviço</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Data Criação</th>
                        <th style="padding: 0.75rem; text-align: left; font-weight: 600;">Status</th>
                        <th style="padding: 0.75rem; text-align: center; font-weight: 600;">Assinado</th>
                        <th style="padding: 0.75rem; text-align: center; font-weight: 600;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laudos as $laudo)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 0.75rem;">{{ $laudo->cliente->nome }}</td>
                            <td style="padding: 0.75rem;">{{ $laudo->servico->tipo_servico }}</td>
                            <td style="padding: 0.75rem;">{{ $laudo->created_at->format('d/m/Y H:i') }}</td>
                            <td style="padding: 0.75rem;">
                                @php
                                    $statusColors = [
                                        'rascunho' => '#6b7280',
                                        'enviado' => '#3b82f6',
                                        'assinado' => '#10b981',
                                        'arquivado' => '#ef4444'
                                    ];
                                    $statusLabels = [
                                        'rascunho' => 'Rascunho',
                                        'enviado' => 'Enviado',
                                        'assinado' => 'Assinado',
                                        'arquivado' => 'Arquivado'
                                    ];
                                @endphp
                                <span style="padding: 0.25rem 0.75rem; border-radius: 0.25rem; background-color: {{ $statusColors[$laudo->status] ?? '#6b7280' }}; color: white; font-size: 0.875rem;">
                                    {{ $statusLabels[$laudo->status] ?? $laudo->status }}
                                </span>
                            </td>
                            <td style="padding: 0.75rem; text-align: center;">
                                @if($laudo->assinado)
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 0.25rem; background-color: #10b981; color: white; font-size: 0.875rem;">Sim</span>
                                @else
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 0.25rem; background-color: #6b7280; color: white; font-size: 0.875rem;">Não</span>
                                @endif
                            </td>
                            <td style="padding: 0.75rem; text-align: center;">
                                <a href="{{ route('laudos.show', $laudo) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Ver</a>
                                <a href="{{ route('laudos.download', $laudo) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Baixar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 2rem; padding: 1rem; background-color: #f9fafb; border-radius: 0.5rem;">
            <p><strong>Total de Laudos:</strong> {{ $laudos->count() }}</p>
            <p><strong>Laudos Assinados:</strong> {{ $laudos->where('assinado', true)->count() }}</p>
            <p><strong>Laudos Pendentes:</strong> {{ $laudos->where('assinado', false)->count() }}</p>
        </div>
    @else
        <div style="text-align: center; padding: 3rem; color: #6b7280;">
            <p style="font-size: 1.125rem;">Nenhum laudo encontrado com os filtros aplicados.</p>
        </div>
    @endif
</div>
@endsection

