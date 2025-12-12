@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700;">Laudo #{{ $laudo->id }}</h1>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('laudos.download', $laudo) }}" class="btn btn-primary">Baixar PDF</a>
            @if($laudo->status === 'rascunho')
                <form method="POST" action="{{ route('laudos.enviar-assinatura', $laudo) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="background-color: #10b981;">Enviar para Assinatura</button>
                </form>
            @endif
            <a href="{{ route('servicos.show', $laudo->servico) }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem;">
        <p><strong>Cliente:</strong> {{ $laudo->cliente->nome }}</p>
        <p><strong>Serviço:</strong> {{ $laudo->servico->tipo_servico }}</p>
        <p><strong>Status:</strong> 
            @php
                $statusColors = [
                    'rascunho' => '#6b7280',
                    'enviado' => '#3b82f6',
                    'assinado' => '#10b981',
                    'arquivado' => '#ef4444'
                ];
                $statusLabels = [
                    'rascunho' => 'Rascunho',
                    'enviado' => 'Enviado',
                    'assinado' => 'Assinado',
                    'arquivado' => 'Arquivado'
                ];
            @endphp
            <span style="padding: 0.25rem 0.75rem; border-radius: 0.25rem; background-color: {{ $statusColors[$laudo->status] ?? '#6b7280' }}; color: white; font-size: 0.875rem;">
                {{ $statusLabels[$laudo->status] ?? $laudo->status }}
            </span>
        </p>
        @if($laudo->link_assinatura_unico)
            <p style="margin-top: 1rem;"><strong>Link de Assinatura:</strong></p>
            <p style="word-break: break-all; background-color: white; padding: 0.5rem; border-radius: 0.25rem;">
                {{ route('assinatura.show', $laudo->link_assinatura_unico) }}
            </p>
        @endif
    </div>

    @if($laudo->conteudo_html)
        <div style="background-color: white; padding: 2rem; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
            {!! $laudo->conteudo_html !!}
        </div>
    @endif
</div>
@endsection

