@extends('layouts.app')

@section('page-title', 'Dashboard - Administrador')

@section('content')
@php
    $totalClientes = \App\Models\Cliente::where('empresa_id', $user->empresa_id)->count();
    $totalServicos = \App\Models\Servico::where('empresa_id', $user->empresa_id)->count();
    $servicosAgendados = \App\Models\Servico::where('empresa_id', $user->empresa_id)->where('status', 'agendado')->count();
    $servicosProgresso = \App\Models\Servico::where('empresa_id', $user->empresa_id)->where('status', 'em_progresso')->count();
    $servicosConcluidos = \App\Models\Servico::where('empresa_id', $user->empresa_id)->where('status', 'concluido')->count();
    $totalLaudos = \App\Models\Laudo::whereHas('servico', function($q) use ($user) { $q->where('empresa_id', $user->empresa_id); })->count();
    $laudosAssinados = \App\Models\Laudo::whereHas('servico', function($q) use ($user) { $q->where('empresa_id', $user->empresa_id); })->where('assinado', true)->count();
    
    $servicosRecentes = \App\Models\Servico::where('empresa_id', $user->empresa_id)
        ->with(['cliente', 'tecnico'])
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();
    
    $clientesRecentes = \App\Models\Cliente::where('empresa_id', $user->empresa_id)
        ->orderBy('created_at', 'desc')
        ->limit(5)
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

    .dashboard-welcome h1 {
        font-size: 1.875rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .dashboard-welcome p {
        font-size: 1rem;
        opacity: 0.9;
        margin: 0;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
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
        background: var(--primary-color);
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

    .stat-box-footer {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .dashboard-section {
        margin-bottom: 2rem;
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

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 2rem;
    }

    .quick-action-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--border-color);
        text-decoration: none;
        color: var(--text-primary);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .quick-action-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-color: var(--primary-color);
    }

    .quick-action-icon {
        width: 48px;
        height: 48px;
        border-radius: 0.5rem;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .quick-action-content {
        flex: 1;
    }

    .quick-action-title {
        font-size: 0.875rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
    }

    .quick-action-desc {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin: 0;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-secondary);
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
</style>

<!-- Welcome Section -->
<div class="dashboard-welcome">
    <h1>Bem-vindo, {{ $user->name }}!</h1>
    <p>Gerencie seus clientes, serviços e laudos de forma eficiente</p>
</div>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-box">
        <div class="stat-box-header">
            <h3 class="stat-box-title">Total de Clientes</h3>
            <div class="stat-box-icon" style="background: rgba(30, 64, 175, 0.1); color: #1e40af;">
                👥
            </div>
        </div>
        <p class="stat-box-value">{{ $totalClientes }}</p>
        <div class="stat-box-footer">
            <a href="{{ route('clientes.index') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">Ver todos →</a>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-box-header">
            <h3 class="stat-box-title">Serviços Agendados</h3>
            <div class="stat-box-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                📅
            </div>
        </div>
        <p class="stat-box-value">{{ $servicosAgendados }}</p>
        <div class="stat-box-footer">
            <a href="{{ route('servicos.index', ['status' => 'agendado']) }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">Ver todos →</a>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-box-header">
            <h3 class="stat-box-title">Em Progresso</h3>
            <div class="stat-box-icon" style="background: rgba(100, 116, 139, 0.1); color: #64748b;">
                ⚙️
            </div>
        </div>
        <p class="stat-box-value">{{ $servicosProgresso }}</p>
        <div class="stat-box-footer">
            <a href="{{ route('servicos.index', ['status' => 'em_progresso']) }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">Ver todos →</a>
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
        <div class="stat-box-footer">
            <a href="{{ route('servicos.index', ['status' => 'concluido']) }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">Ver todos →</a>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-box-header">
            <h3 class="stat-box-title">Laudos Gerados</h3>
            <div class="stat-box-icon" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
                📄
            </div>
        </div>
        <p class="stat-box-value">{{ $totalLaudos }}</p>
        <div class="stat-box-footer">
            Total de laudos criados
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-box-header">
            <h3 class="stat-box-title">Laudos Assinados</h3>
            <div class="stat-box-icon" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                ✍️
            </div>
        </div>
        <p class="stat-box-value">{{ $laudosAssinados }}</p>
        <div class="stat-box-footer">
            @if($totalLaudos > 0)
                {{ number_format(($laudosAssinados / $totalLaudos) * 100, 1) }}% do total
            @else
                Nenhum laudo ainda
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="dashboard-section">
    <div class="section-header">
        <h2 class="section-title">Ações Rápidas</h2>
    </div>
    <div class="quick-actions">
        <a href="{{ route('clientes.create') }}" class="quick-action-card">
            <div class="quick-action-icon">➕</div>
            <div class="quick-action-content">
                <h3 class="quick-action-title">Novo Cliente</h3>
                <p class="quick-action-desc">Cadastrar novo cliente no sistema</p>
            </div>
        </a>
        <a href="{{ route('servicos.create') }}" class="quick-action-card">
            <div class="quick-action-icon">📋</div>
            <div class="quick-action-content">
                <h3 class="quick-action-title">Nova Ordem de Serviço</h3>
                <p class="quick-action-desc">Criar nova ordem de serviço</p>
            </div>
        </a>
        <a href="{{ route('laudo-templates.create') }}" class="quick-action-card">
            <div class="quick-action-icon">📝</div>
            <div class="quick-action-content">
                <h3 class="quick-action-title">Novo Template</h3>
                <p class="quick-action-desc">Criar template de laudo</p>
            </div>
        </a>
        <a href="{{ route('relatorios.index') }}" class="quick-action-card">
            <div class="quick-action-icon">📊</div>
            <div class="quick-action-content">
                <h3 class="quick-action-title">Relatórios</h3>
                <p class="quick-action-desc">Visualizar relatórios e estatísticas</p>
            </div>
        </a>
    </div>
</div>

<!-- Recent Services -->
<div class="dashboard-section">
    <div class="section-header">
        <h2 class="section-title">Serviços Recentes</h2>
        <a href="{{ route('servicos.index') }}" class="btn btn-secondary" style="font-size: 0.875rem; padding: 0.5rem 1rem;">Ver Todos</a>
    </div>
    <div class="data-table">
        <div class="data-table-header">
            <div class="data-table-title">Últimas Ordens de Serviço</div>
        </div>
        @if($servicosRecentes->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Tipo de Serviço</th>
                        <th>Técnico</th>
                        <th>Status</th>
                        <th>Data</th>
                        <th style="text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicosRecentes as $servico)
                        <tr>
                            <td>
                                <a href="{{ route('servicos.show', $servico) }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">
                                    {{ $servico->cliente->nome }}
                                </a>
                            </td>
                            <td>{{ $servico->tipo_servico }}</td>
                            <td>{{ $servico->tecnico->name ?? '-' }}</td>
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
                            <td>{{ $servico->created_at->format('d/m/Y') }}</td>
                            <td style="text-align: center;">
                                <a href="{{ route('servicos.show', $servico) }}" class="btn btn-secondary" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">Ver</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <p>Nenhum serviço cadastrado ainda.</p>
                <a href="{{ route('servicos.create') }}" class="btn btn-primary" style="margin-top: 1rem;">Criar Primeiro Serviço</a>
            </div>
        @endif
    </div>
</div>

<!-- Recent Clients -->
@if($clientesRecentes->count() > 0)
<div class="dashboard-section">
    <div class="section-header">
        <h2 class="section-title">Clientes Recentes</h2>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary" style="font-size: 0.875rem; padding: 0.5rem 1rem;">Ver Todos</a>
    </div>
    <div class="data-table">
        <div class="data-table-header">
            <div class="data-table-title">Últimos Clientes Cadastrados</div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Cidade/UF</th>
                    <th style="text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientesRecentes as $cliente)
                    <tr>
                        <td>
                            <a href="{{ route('clientes.show', $cliente) }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">
                                {{ $cliente->nome }}
                            </a>
                        </td>
                        <td>{{ $cliente->email ?? '-' }}</td>
                        <td>{{ $cliente->telefone ?? '-' }}</td>
                        <td>{{ $cliente->cidade ?? '-' }}{{ $cliente->estado ? '/' . $cliente->estado : '' }}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-secondary" style="padding: 0.375rem 0.75rem; font-size: 0.75rem;">Ver</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Help Section -->
<div class="card" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 1px solid var(--border-color);">
    <div class="card-header" style="border-bottom: 1px solid var(--border-color);">
        <h2 class="card-title" style="font-size: 1.25rem;">Como começar?</h2>
    </div>
    <div style="padding-top: 1rem;">
        <ol style="list-style: decimal; padding-left: 1.5rem; color: var(--text-primary); line-height: 2;">
            <li style="margin-bottom: 0.75rem;">Cadastre seus <a href="{{ route('clientes.create') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">primeiros clientes</a> no sistema</li>
            <li style="margin-bottom: 0.75rem;">Crie uma <a href="{{ route('servicos.create') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">Ordem de Serviço</a> vinculada a um cliente</li>
            <li style="margin-bottom: 0.75rem;">Atribua um técnico e agende o serviço</li>
            <li style="margin-bottom: 0.75rem;">O técnico executa o serviço preenchendo o checklist e anexando fotos</li>
            <li style="margin-bottom: 0.75rem;">Gere o laudo PDF automaticamente após a conclusão</li>
            <li>Envie o laudo para assinatura digital do cliente</li>
        </ol>
    </div>
</div>
@endsection
