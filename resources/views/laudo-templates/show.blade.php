@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700;">Template: {{ $laudoTemplate->nome_template }}</h1>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('laudo-templates.edit', $laudoTemplate) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('laudo-templates.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem;">
        <p><strong>Tipo de Serviço:</strong> {{ $laudoTemplate->tipo_servico }}</p>
        <p><strong>Status:</strong> 
            @if($laudoTemplate->ativo)
                <span style="padding: 0.25rem 0.75rem; border-radius: 0.25rem; background-color: #10b981; color: white; font-size: 0.875rem;">Ativo</span>
            @else
                <span style="padding: 0.25rem 0.75rem; border-radius: 0.25rem; background-color: #6b7280; color: white; font-size: 0.875rem;">Inativo</span>
            @endif
        </p>
        <p><strong>Criado por:</strong> {{ $laudoTemplate->criador->name }}</p>
        <p><strong>Data de Criação:</strong> {{ $laudoTemplate->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div style="background-color: white; padding: 2rem; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
        <h2 style="margin-bottom: 1rem;">Preview do Template</h2>
        <div style="border: 1px solid #d1d5db; padding: 1rem; background-color: #f9fafb; border-radius: 0.5rem; max-height: 600px; overflow-y: auto;">
            {!! $laudoTemplate->conteudo_html !!}
        </div>
    </div>

    @if($laudoTemplate->laudos->count() > 0)
        <div style="margin-top: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem;">Laudos Gerados com Este Template</h2>
            <p style="color: #6b7280;">Total: {{ $laudoTemplate->laudos->count() }} laudo(s)</p>
        </div>
    @endif
</div>
@endsection

