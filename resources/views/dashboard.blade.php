@extends('layouts.app')

@section('content')
<div class="card">
    <h1 style="margin-bottom: 1.5rem; font-size: 2rem; font-weight: 700;">Dashboard</h1>
    
    <p style="font-size: 1.125rem; color: #6b7280; margin-bottom: 2rem;">
        Bem-vindo, <strong>{{ Auth::user()->name }}</strong>! Você está logado no OSLaudo.
    </p>

    <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem; margin-top: 2rem;">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">Próximos Passos</h2>
        <ul style="list-style: none; padding: 0;">
            <li style="padding: 0.5rem 0; color: #374151;">✓ Sistema de autenticação configurado</li>
            <li style="padding: 0.5rem 0; color: #374151;">→ Criar estrutura de banco de dados (Models e Migrations)</li>
            <li style="padding: 0.5rem 0; color: #374151;">→ Implementar funcionalidades do sistema de laudos</li>
        </ul>
    </div>
</div>
@endsection

