@extends('layouts.app')

@section('page-title', 'Configurar')

@section('content')
<div class="card">
    <h1 style="margin-bottom: 2rem; font-size: 1.75rem; font-weight: 700; color: var(--text-primary);">Configurações</h1>
    
    <p style="color: var(--text-secondary); margin-bottom: 2rem;">Selecione uma opção de configuração:</p>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
        <a href="{{ route('configuracoes.sistema') }}" class="card" style="text-decoration: none; padding: 1.5rem; transition: transform 0.2s ease;">
            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-primary);">Sistema</h3>
            <p style="color: var(--text-secondary); font-size: 0.875rem;">Configurações gerais do sistema</p>
        </a>
        
        <a href="{{ route('configuracoes.usuarios') }}" class="card" style="text-decoration: none; padding: 1.5rem; transition: transform 0.2s ease;">
            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-primary);">Usuários</h3>
            <p style="color: var(--text-secondary); font-size: 0.875rem;">Gerenciar usuários do sistema</p>
        </a>
        
        <a href="{{ route('configuracoes.emitente') }}" class="card" style="text-decoration: none; padding: 1.5rem; transition: transform 0.2s ease;">
            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-primary);">Emitente</h3>
            <p style="color: var(--text-secondary); font-size: 0.875rem;">Dados do emitente</p>
        </a>
        
        <a href="{{ route('configuracoes.permissoes') }}" class="card" style="text-decoration: none; padding: 1.5rem; transition: transform 0.2s ease;">
            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-primary);">Permissões</h3>
            <p style="color: var(--text-secondary); font-size: 0.875rem;">Gerenciar permissões</p>
        </a>
        
        <a href="{{ route('configuracoes.auditoria') }}" class="card" style="text-decoration: none; padding: 1.5rem; transition: transform 0.2s ease;">
            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-primary);">Auditoria</h3>
            <p style="color: var(--text-secondary); font-size: 0.875rem;">Logs e auditoria do sistema</p>
        </a>
        
        <a href="{{ route('configuracoes.emails') }}" class="card" style="text-decoration: none; padding: 1.5rem; transition: transform 0.2s ease;">
            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-primary);">E-mails</h3>
            <p style="color: var(--text-secondary); font-size: 0.875rem;">Configurações de e-mail</p>
        </a>
        
        <a href="{{ route('configuracoes.backup') }}" class="card" style="text-decoration: none; padding: 1.5rem; transition: transform 0.2s ease;">
            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-primary);">Backup</h3>
            <p style="color: var(--text-secondary); font-size: 0.875rem;">Backup e restauração</p>
        </a>
    </div>
</div>
@endsection


