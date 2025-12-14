@extends('layouts.app')

@section('page-title', 'Configurar')

@section('content')
<div class="card">
    <h1 style="margin-bottom: 1.5rem; font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">Configurações do Sistema</h1>

    <!-- Tabs -->
    <div style="border-bottom: 2px solid var(--border-color); margin-bottom: 1.5rem;">
        <div style="display: flex; gap: 0;">
            <a href="{{ route('configuracoes.sistema') }}" style="padding: 0.75rem 1.25rem; border-bottom: 3px solid transparent; color: var(--text-secondary); text-decoration: none; font-size: 0.8125rem; transition: color 0.2s ease;">Gerais</a>
            <a href="{{ route('configuracoes.ordem-servico') }}" style="padding: 0.75rem 1.25rem; border-bottom: 3px solid #fb923c; color: var(--text-primary); font-weight: 600; text-decoration: none; font-size: 0.8125rem;">Ordem de Serviço</a>
            <a href="#" style="padding: 0.75rem 1.25rem; border-bottom: 3px solid transparent; color: var(--text-secondary); text-decoration: none; font-size: 0.8125rem; transition: color 0.2s ease;">Notificações</a>
            <a href="#" style="padding: 0.75rem 1.25rem; border-bottom: 3px solid transparent; color: var(--text-secondary); text-decoration: none; font-size: 0.8125rem; transition: color 0.2s ease;">Atualizações</a>
            <a href="{{ route('configuracoes.emails') }}" style="padding: 0.75rem 1.25rem; border-bottom: 3px solid transparent; color: var(--text-secondary); text-decoration: none; font-size: 0.8125rem; transition: color 0.2s ease;">E-mail</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error" style="margin-bottom: 1.5rem;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Formulário Ordem de Serviço -->
    <form method="POST" action="{{ route('configuracoes.ordem-servico') }}">
        @csrf

        <div style="display: grid; gap: 1.5rem;">
            <!-- Permitir Técnico Criar OS -->
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 1.25rem; align-items: start;">
                <label style="font-weight: 500; color: var(--text-primary); padding-top: 0.625rem; font-size: 0.8125rem;">
                    Permissões de Técnicos
                </label>
                <div style="flex: 1;">
                    <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                        <input 
                            type="checkbox" 
                            id="tecnico_criar_os" 
                            name="tecnico_criar_os" 
                            value="1"
                            {{ old('tecnico_criar_os', $configuracoes['tecnico_criar_os'] ?? false) ? 'checked' : '' }}
                            style="width: 18px; height: 18px; cursor: pointer;"
                        >
                        <span style="font-size: 0.875rem; color: var(--text-primary);">
                            Permitir técnicos criarem Ordens de Serviço
                        </span>
                    </label>
                    <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.375rem;">
                        Quando habilitado, técnicos poderão criar novas Ordens de Serviço. Por padrão, apenas administradores podem criar OS.
                    </p>
                </div>
            </div>

            <!-- Status Padrão de Nova OS -->
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 1.25rem; align-items: start;">
                <label for="status_padrao_os" style="font-weight: 500; color: var(--text-primary); padding-top: 0.625rem; font-size: 0.8125rem;">
                    Status Padrão
                </label>
                <div style="flex: 1;">
                    <select 
                        id="status_padrao_os" 
                        name="status_padrao_os" 
                        class="form-select"
                        style="width: 100%; max-width: 400px;"
                    >
                        <option value="agendado" {{ old('status_padrao_os', $configuracoes['status_padrao_os'] ?? 'agendado') === 'agendado' ? 'selected' : '' }}>Agendado</option>
                        <option value="em_progresso" {{ old('status_padrao_os', $configuracoes['status_padrao_os'] ?? 'agendado') === 'em_progresso' ? 'selected' : '' }}>Em Progresso</option>
                    </select>
                    <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.375rem;">Status padrão ao criar uma nova Ordem de Serviço</p>
                </div>
            </div>

            <!-- Notificações de OS -->
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 1.25rem; align-items: start;">
                <label style="font-weight: 500; color: var(--text-primary); padding-top: 0.625rem; font-size: 0.8125rem;">
                    Notificações
                </label>
                <div style="flex: 1;">
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                            <input 
                                type="checkbox" 
                                id="notificar_tecnico_nova_os" 
                                name="notificar_tecnico_nova_os" 
                                value="1"
                                {{ old('notificar_tecnico_nova_os', $configuracoes['notificar_tecnico_nova_os'] ?? false) ? 'checked' : '' }}
                                style="width: 18px; height: 18px; cursor: pointer;"
                            >
                            <span style="font-size: 0.875rem; color: var(--text-primary);">
                                Notificar técnico quando nova OS for atribuída
                            </span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                            <input 
                                type="checkbox" 
                                id="notificar_admin_conclusao" 
                                name="notificar_admin_conclusao" 
                                value="1"
                                {{ old('notificar_admin_conclusao', $configuracoes['notificar_admin_conclusao'] ?? false) ? 'checked' : '' }}
                                style="width: 18px; height: 18px; cursor: pointer;"
                            >
                            <span style="font-size: 0.875rem; color: var(--text-primary);">
                                Notificar administrador quando OS for concluída
                            </span>
                        </label>
                    </div>
                    <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.375rem;">Configure as notificações relacionadas a Ordens de Serviço</p>
                </div>
            </div>

            <!-- Validações -->
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 1.25rem; align-items: start;">
                <label style="font-weight: 500; color: var(--text-primary); padding-top: 0.625rem; font-size: 0.8125rem;">
                    Validações
                </label>
                <div style="flex: 1;">
                    <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                        <input 
                            type="checkbox" 
                            id="exigir_assinatura_obrigatoria" 
                            name="exigir_assinatura_obrigatoria" 
                            value="1"
                            {{ old('exigir_assinatura_obrigatoria', $configuracoes['exigir_assinatura_obrigatoria'] ?? true) ? 'checked' : '' }}
                            style="width: 18px; height: 18px; cursor: pointer;"
                        >
                        <span style="font-size: 0.875rem; color: var(--text-primary);">
                            Exigir assinatura obrigatória para concluir OS
                        </span>
                    </label>
                    <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.375rem;">Quando habilitado, a OS só pode ser concluída após assinatura do técnico</p>
                </div>
            </div>
        </div>

        <!-- Botão Salvar -->
        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
            <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
                Salvar Alterações
            </button>
        </div>
    </form>
</div>
@endsection

