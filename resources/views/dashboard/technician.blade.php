@extends('layouts.app')

@section('page-title', 'Dashboard - Técnico')

@section('content')
@php
    // Serviços de hoje
    $servicosHoje = \App\Models\Servico::where('tecnico_id', $user->id)
        ->whereDate('data_agendada', today())
        ->whereIn('status', ['agendado', 'em_progresso'])
        ->with(['cliente'])
        ->orderBy('hora_inicio', 'asc')
        ->get();
    
    // Estatísticas
    $servicosPendentes = \App\Models\Servico::where('tecnico_id', $user->id)
        ->whereIn('status', ['agendado', 'em_progresso'])
        ->count();
    $servicosEmProgresso = \App\Models\Servico::where('tecnico_id', $user->id)
        ->where('status', 'em_progresso')
        ->count();
    $servicosConcluidos = \App\Models\Servico::where('tecnico_id', $user->id)
        ->where('status', 'concluido')
        ->count();
    
    // Próximos serviços (próximos 7 dias)
    $proximosServicos = \App\Models\Servico::where('tecnico_id', $user->id)
        ->whereIn('status', ['agendado', 'em_progresso'])
        ->whereDate('data_agendada', '>=', today())
        ->whereDate('data_agendada', '<=', today()->addDays(7))
        ->with(['cliente'])
        ->orderBy('data_agendada', 'asc')
        ->orderBy('hora_inicio', 'asc')
        ->limit(10)
        ->get();
    
    // Serviço atual (em progresso)
    $servicoAtual = \App\Models\Servico::where('tecnico_id', $user->id)
        ->where('status', 'em_progresso')
        ->with(['cliente', 'execucao'])
        ->first();
@endphp

<style>
    .dashboard-welcome {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: white;
        padding: 2rem;
        border-radius: 0.75rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 768px) {
        .dashboard-welcome {
            padding: 1.5rem;
        }

        .dashboard-welcome h1 {
            font-size: 1.5rem !important;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .stat-box {
            padding: 1.25rem;
        }

        .stat-box-value {
            font-size: 1.75rem;
        }

        .data-table {
            overflow-x: auto;
        }

        table {
            min-width: 600px;
            font-size: 0.8125rem;
        }

        th, td {
            padding: 0.5rem;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .btn {
            width: 100%;
        }
    }

    .stat-box {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
    }

    .stat-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .stat-box-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .stat-box-title {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-secondary);
        margin: 0;
    }

    .stat-box-icon {
        width: 40px;
        height: 40px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .stat-box-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        line-height: 1;
    }

    .data-table {
        background: white;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--border-color);
    }

    .data-table-header {
        background: var(--bg-light);
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .data-table-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }
</style>

<div class="dashboard-welcome">
    <h1 style="font-size: 1.875rem; font-weight: 700; margin: 0 0 0.5rem 0;">🔧 Meus Serviços - {{ $user->name }}</h1>
    <p style="font-size: 1rem; opacity: 0.9; margin: 0;">{{ $servicosHoje->count() }} serviço(s) agendado(s) para hoje</p>
</div>

<!-- Cards de Status -->
<div class="stats-grid">
    <div class="stat-box">
        <div class="stat-box-header">
            <h3 class="stat-box-title">📅 Hoje</h3>
            <div class="stat-box-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                📅
            </div>
        </div>
        <p class="stat-box-value">{{ $servicosHoje->count() }}</p>
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color); font-size: 0.75rem; color: var(--text-secondary);">
            Serviços de hoje
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-box-header">
            <h3 class="stat-box-title">🔄 Em Progresso</h3>
            <div class="stat-box-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                🔄
            </div>
        </div>
        <p class="stat-box-value">{{ $servicosEmProgresso }}</p>
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color); font-size: 0.75rem; color: var(--text-secondary);">
            Em execução
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-box-header">
            <h3 class="stat-box-title">✅ Concluídos</h3>
            <div class="stat-box-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                ✅
            </div>
        </div>
        <p class="stat-box-value">{{ $servicosConcluidos }}</p>
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color); font-size: 0.75rem; color: var(--text-secondary);">
            Total executados
        </div>
    </div>
</div>

<!-- Serviço Atual (se houver) -->
@if($servicoAtual)
<div style="margin-bottom: 2rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 600; margin: 0 0 0.5rem 0;">⏱️ Serviço em Andamento</h2>
            <p style="font-size: 0.875rem; opacity: 0.9; margin: 0;">{{ $servicoAtual->tipo_servico }} - {{ $servicoAtual->cliente->nome }}</p>
        </div>
        <a href="{{ route('servicos.executar', $servicoAtual) }}" class="btn" style="background: white; color: #10b981; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 600;">Continuar</a>
    </div>
    @if($servicoAtual->endereco_servico)
        <p style="font-size: 0.875rem; opacity: 0.9; margin: 0;">📍 {{ $servicoAtual->endereco_servico }}</p>
    @endif
</div>
@endif

<!-- Serviços de Hoje -->
@if($servicosHoje->count() > 0)
<div style="margin-bottom: 2rem;">
    <div class="section-header">
        <h2 class="section-title">📅 Serviços de Hoje</h2>
    </div>
    <div style="display: grid; gap: 1rem;">
        @foreach($servicosHoje as $servico)
        <div style="background: white; border-radius: 0.75rem; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border: 1px solid var(--border-color);">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                <div style="flex: 1;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; margin: 0 0 0.5rem 0; color: var(--text-primary);">
                        {{ $servico->tipo_servico }} - {{ $servico->cliente->nome }}
                    </h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.875rem; color: var(--text-secondary);">
                        @if($servico->hora_inicio)
                            <span>🕐 {{ $servico->hora_inicio->format('H:i') }}</span>
                        @endif
                        @if($servico->endereco_servico)
                            <span>📍 {{ Str::limit($servico->endereco_servico, 40) }}</span>
                        @endif
                        @if($servico->cliente->telefone)
                            <span>📱 {{ $servico->cliente->telefone }}</span>
                        @endif
                    </div>
                </div>
                <span class="badge" style="background: {{ $servico->status === 'agendado' ? '#dbeafe' : '#fef3c7' }}; color: {{ $servico->status === 'agendado' ? '#3b82f6' : '#f59e0b' }}; padding: 0.25rem 0.75rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 600;">
                    {{ $servico->status === 'agendado' ? 'Agendado' : 'Em Progresso' }}
                </span>
            </div>
            @if($servico->descricao_servico)
                <p style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 1rem;">{{ Str::limit($servico->descricao_servico, 100) }}</p>
            @endif
            <div style="display: flex; gap: 0.75rem;">
                <a href="{{ route('servicos.show', $servico) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">📌 Detalhes</a>
                <a href="{{ route('servicos.executar', $servico) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem; flex: 1;">▶️ {{ $servico->status === 'agendado' ? 'Iniciar Serviço' : 'Continuar' }}</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Próximos Serviços (Próximos 7 dias) -->
@if($proximosServicos->count() > 0)
<div style="margin-bottom: 2rem;">
    <div class="section-header">
        <h2 class="section-title">📋 Próximos Serviços</h2>
        <a href="{{ route('servicos.index') }}" class="btn btn-secondary" style="font-size: 0.875rem; padding: 0.5rem 1rem;">Ver Todos</a>
    </div>
    <div class="data-table">
        <div class="data-table-header">
            <div class="data-table-title">Serviços dos Próximos 7 Dias</div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Tipo</th>
                    <th>Data/Hora</th>
                    <th>Status</th>
                    <th style="text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proximosServicos as $servico)
                    <tr>
                        <td>
                            <a href="{{ route('servicos.show', $servico) }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">
                                {{ $servico->cliente->nome }}
                            </a>
                        </td>
                        <td>{{ $servico->tipo_servico }}</td>
                        <td>
                            {{ $servico->data_agendada ? $servico->data_agendada->format('d/m/Y') : '-' }}
                            @if($servico->hora_inicio)
                                <br><small style="color: var(--text-secondary);">🕐 {{ $servico->hora_inicio->format('H:i') }}</small>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusConfig = [
                                    'agendado' => ['color' => '#3b82f6', 'label' => 'Agendado', 'bg' => '#dbeafe'],
                                    'em_progresso' => ['color' => '#f59e0b', 'label' => 'Em Progresso', 'bg' => '#fef3c7'],
                                    'concluido' => ['color' => '#10b981', 'label' => 'Concluído', 'bg' => '#d1fae5'],
                                    'cancelado' => ['color' => '#ef4444', 'label' => 'Cancelado', 'bg' => '#fee2e2']
                                ];
                                $status = $statusConfig[$servico->status] ?? ['color' => '#6b7280', 'label' => $servico->status, 'bg' => '#f3f4f6'];
                            @endphp
                            <span class="badge" style="background: {{ $status['bg'] }}; color: {{ $status['color'] }};">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            @if($servico->status === 'agendado' || $servico->status === 'em_progresso')
                                <a href="{{ route('servicos.executar', $servico) }}" class="btn btn-primary" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">Executar</a>
                            @else
                                <a href="{{ route('servicos.show', $servico) }}" class="btn btn-secondary" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">Ver</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div style="text-align: center; padding: 3rem 2rem; color: var(--text-secondary); background: white; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
    <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;">📋</div>
    <p style="font-size: 1.125rem; margin-bottom: 0.5rem;">Nenhum serviço agendado</p>
    <p style="font-size: 0.875rem; opacity: 0.8;">Você não tem serviços agendados para os próximos 7 dias.</p>
</div>
@endif
@endsection
