@extends('layouts.app')

@section('page-title', 'Dashboard - Cliente')

@section('content')
<div class="dashboard-welcome" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: white; padding: 2rem; border-radius: 0.75rem; margin-bottom: 2rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <h1 style="font-size: 1.875rem; font-weight: 700; margin: 0 0 0.5rem 0;">Bem-vindo, {{ $user->name }}!</h1>
    <p style="font-size: 1rem; opacity: 0.9; margin: 0;">Área do cliente</p>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title" style="font-size: 1.25rem;">Informações</h2>
    </div>
    <p style="color: var(--text-secondary);">Área do cliente em desenvolvimento. Em breve você poderá visualizar seus laudos e documentos aqui.</p>
</div>
@endsection
