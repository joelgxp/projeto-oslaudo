@extends('layouts.app')

@section('page-title', 'Configurar')

@section('content')
<div class="card">
    <h1 style="margin-bottom: 1.5rem; font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">Configurações do Sistema</h1>

    <!-- Tabs -->
    <div style="border-bottom: 2px solid var(--border-color); margin-bottom: 1.5rem;">
        <div style="display: flex; gap: 0;">
            <a href="{{ route('configuracoes.sistema') }}" style="padding: 0.75rem 1.25rem; border-bottom: 3px solid #fb923c; color: var(--text-primary); font-weight: 600; text-decoration: none; font-size: 0.8125rem;">Gerais</a>
            <a href="{{ route('configuracoes.ordem-servico') }}" style="padding: 0.75rem 1.25rem; border-bottom: 3px solid transparent; color: var(--text-secondary); text-decoration: none; font-size: 0.8125rem; transition: color 0.2s ease;">Ordem de Serviço</a>
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

    <!-- Formulário Gerais -->
    <form method="POST" action="{{ route('configuracoes.sistema') }}">
        @csrf

        <div style="display: grid; gap: 1.5rem;">
            <!-- Nome do Sistema -->
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 1.25rem; align-items: start;">
                <label for="nome_sistema" style="font-weight: 500; color: var(--text-primary); padding-top: 0.625rem; font-size: 0.8125rem;">
                    Nome do Sistema
                </label>
                <div style="flex: 1;">
                    <input 
                        type="text" 
                        id="nome_sistema" 
                        name="nome_sistema" 
                        value="{{ old('nome_sistema', $configuracoes['nome_sistema'] ?? 'OSLaudos') }}"
                        class="form-input"
                        style="width: 100%; max-width: 400px;"
                    >
                    <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.375rem;">Nome do sistema</p>
                </div>
            </div>

            <!-- Tema do Sistema -->
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 1.25rem; align-items: start;">
                <label for="tema_sistema" style="font-weight: 500; color: var(--text-primary); padding-top: 0.625rem; font-size: 0.8125rem;">
                    Tema do Sistema
                </label>
                <div style="flex: 1;">
                    <select 
                        id="tema_sistema" 
                        name="tema_sistema" 
                        class="form-select"
                        style="width: 100%; max-width: 400px;"
                    >
                        <option value="claro" {{ old('tema_sistema', $configuracoes['tema_sistema'] ?? 'claro') === 'claro' ? 'selected' : '' }}>Claro</option>
                        <option value="escuro" {{ old('tema_sistema', $configuracoes['tema_sistema'] ?? 'claro') === 'escuro' ? 'selected' : '' }}>Escuro</option>
                    </select>
                    <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.375rem;">Selecione o tema que deseja usar no sistema</p>
                </div>
            </div>

            <!-- Registros por Página -->
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 1.25rem; align-items: start;">
                <label for="registros_pagina" style="font-weight: 500; color: var(--text-primary); padding-top: 0.625rem; font-size: 0.8125rem;">
                    Registros por Página
                </label>
                <div style="flex: 1;">
                    <select 
                        id="registros_pagina" 
                        name="registros_pagina" 
                        class="form-select"
                        style="width: 100%; max-width: 400px;"
                    >
                        <option value="10" {{ old('registros_pagina', $configuracoes['registros_pagina'] ?? '10') === '10' ? 'selected' : '' }}>10</option>
                        <option value="25" {{ old('registros_pagina', $configuracoes['registros_pagina'] ?? '10') === '25' ? 'selected' : '' }}>25</option>
                        <option value="50" {{ old('registros_pagina', $configuracoes['registros_pagina'] ?? '10') === '50' ? 'selected' : '' }}>50</option>
                        <option value="100" {{ old('registros_pagina', $configuracoes['registros_pagina'] ?? '10') === '100' ? 'selected' : '' }}>100</option>
                    </select>
                    <p style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.375rem;">Selecione quantos registros deseja exibir nas listas</p>
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

