@extends('layouts.app')

@section('content')
<div class="card">
    <h1 style="margin-bottom: 1.5rem; font-size: 2rem; font-weight: 700;">Dashboard - Técnico</h1>
    
    <p style="font-size: 1.125rem; color: #6b7280; margin-bottom: 2rem;">
        Bem-vindo, <strong>{{ $user->name }}</strong>!
    </p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
        <div style="background-color: #fef3c7; padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid #f59e0b;">
            <h3 style="font-size: 0.875rem; color: #92400e; margin-bottom: 0.5rem;">Serviços Pendentes</h3>
            <p style="font-size: 2rem; font-weight: 700; color: #92400e;">{{ \App\Models\Servico::where('tecnico_id', $user->id)->whereIn('status', ['agendado', 'em_progresso'])->count() }}</p>
        </div>
        <div style="background-color: #d1fae5; padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid #10b981;">
            <h3 style="font-size: 0.875rem; color: #065f46; margin-bottom: 0.5rem;">Serviços Concluídos</h3>
            <p style="font-size: 2rem; font-weight: 700; color: #065f46;">{{ \App\Models\Servico::where('tecnico_id', $user->id)->where('status', 'concluido')->count() }}</p>
        </div>
    </div>
</div>
@endsection

