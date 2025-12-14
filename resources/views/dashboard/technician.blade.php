@extends('layouts.app')

@section('page-title', 'Dashboard - Técnico')

@section('content')
@php
    $servicosPendentes = \App\Models\Servico::where('tecnico_id', $user->id)
        ->whereIn('status', ['agendado', 'em_progresso'])
        ->count();
    $servicosConcluidos = \App\Models\Servico::where('tecnico_id', $user->id)
        ->where('status', 'concluido')
        ->count();
    
    $meusServicos = \App\Models\Servico::where('tecnico_id', $user->id)
        ->with(['cliente'])
        ->orderBy('data_agendada', 'asc')
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();
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
    <h1 style="font-size: 1.875rem; font-weight: 700; margin: 0 0 0.5rem 0;">Bem-vindo, {{ $user->name }}!</h1>
    <p style="font-size: 1rem; opacity: 0.9; margin: 0;">Gerencie seus serviços e execuções</p>
</div>

<div class="stats-grid">
    <div class="stat-box">
        <div class="stat-box-header">
            <h3 class="stat-box-title">Serviços Pendentes</h3>
            <div class="stat-box-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                ⏳
            </div>
        </div>
        <p class="stat-box-value">{{ $servicosPendentes }}</p>
        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color); font-size: 0.75rem; color: var(--text-secondary);">
            Requerem sua atenção
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-box-header">
            <h3 class="stat-box-title">Serviços Concluídos</h3>
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

<div style="margin-bottom: 2rem;">
    <div class="section-header">
        <h2 class="section-title">Meus Serviços</h2>
        <a href="{{ route('servicos.index') }}" class="btn btn-secondary" style="font-size: 0.875rem; padding: 0.5rem 1rem;">Ver Todos</a>
    </div>
    <div class="data-table">
        <div class="data-table-header">
            <div class="data-table-title">Serviços Atribuídos</div>
        </div>
        @if($meusServicos->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Tipo de Serviço</th>
                        <th>Data Agendada</th>
                        <th>Status</th>
                        <th style="text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($meusServicos as $servico)
                        <tr>
                            <td>
                                <a href="{{ route('servicos.show', $servico) }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">
                                    {{ $servico->cliente->nome }}
                                </a>
                            </td>
                            <td>{{ $servico->tipo_servico }}</td>
                            <td>{{ $servico->data_agendada ? $servico->data_agendada->format('d/m/Y') : '-' }}</td>
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
        @else
            <div style="text-align: center; padding: 3rem 2rem; color: var(--text-secondary);">
                <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;">📋</div>
                <p>Nenhum serviço atribuído ainda.</p>
            </div>
        @endif
    </div>
</div>
@endsection
