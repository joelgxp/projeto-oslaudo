@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700;">Detalhes da Ordem de Serviço</h1>
        <div style="display: flex; gap: 1rem;">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('servicos.edit', $servico) }}" class="btn btn-primary">Editar</a>
            @endif
            @if(auth()->user()->isTechnician() && $servico->status !== 'concluido' && $servico->tecnico_id === auth()->id())
                <a href="{{ route('servicos.executar', $servico) }}" class="btn btn-primary" style="background-color: #10b981;">Executar</a>
            @endif
            <a href="{{ route('servicos.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #2563eb;">Informações do Serviço</h2>
            <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                <p style="margin-bottom: 0.75rem;"><strong>Tipo:</strong> {{ $servico->tipo_servico }}</p>
                <p style="margin-bottom: 0.75rem;"><strong>Status:</strong> 
                    @php
                        $statusColors = [
                            'agendado' => '#3b82f6',
                            'em_progresso' => '#f59e0b',
                            'concluido' => '#10b981',
                            'cancelado' => '#ef4444'
                        ];
                        $statusLabels = [
                            'agendado' => 'Agendado',
                            'em_progresso' => 'Em Progresso',
                            'concluido' => 'Concluído',
                            'cancelado' => 'Cancelado'
                        ];
                    @endphp
                    <span style="padding: 0.25rem 0.75rem; border-radius: 0.25rem; background-color: {{ $statusColors[$servico->status] ?? '#6b7280' }}; color: white; font-size: 0.875rem;">
                        {{ $statusLabels[$servico->status] ?? $servico->status }}
                    </span>
                </p>
                <p style="margin-bottom: 0.75rem;"><strong>Data Agendada:</strong> {{ $servico->data_agendada ? $servico->data_agendada->format('d/m/Y') : '-' }}</p>
                <p style="margin-bottom: 0.75rem;"><strong>Data Execução:</strong> {{ $servico->data_execucao ? $servico->data_execucao->format('d/m/Y') : '-' }}</p>
                @if($servico->hora_inicio)
                    <p style="margin-bottom: 0.75rem;"><strong>Hora Início:</strong> {{ $servico->hora_inicio->format('H:i') }}</p>
                @endif
            </div>
        </div>

        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #2563eb;">Cliente</h2>
            <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                <p style="margin-bottom: 0.75rem;"><strong>Nome:</strong> {{ $servico->cliente->nome }}</p>
                <p style="margin-bottom: 0.75rem;"><strong>Email:</strong> {{ $servico->cliente->email ?? '-' }}</p>
                <p style="margin-bottom: 0.75rem;"><strong>Telefone:</strong> {{ $servico->cliente->telefone ?? '-' }}</p>
            </div>
        </div>

        @if($servico->tecnico)
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #2563eb;">Técnico</h2>
                <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                    <p style="margin-bottom: 0.75rem;"><strong>Nome:</strong> {{ $servico->tecnico->name }}</p>
                    <p style="margin-bottom: 0.75rem;"><strong>Email:</strong> {{ $servico->tecnico->email }}</p>
                </div>
            </div>
        @endif
    </div>

    @if($servico->endereco_servico)
        <div style="margin-top: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #2563eb;">Endereço do Serviço</h2>
            <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                <p>{{ $servico->endereco_servico }}</p>
            </div>
        </div>
    @endif

    @if($servico->descricao_servico)
        <div style="margin-top: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #2563eb;">Descrição</h2>
            <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                <p>{{ $servico->descricao_servico }}</p>
            </div>
        </div>
    @endif

    @if($servico->laudos->count() > 0)
        <div style="margin-top: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #2563eb;">Laudos</h2>
            <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                @foreach($servico->laudos as $laudo)
                    <div style="padding: 1rem; background-color: white; border-radius: 0.5rem; margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <p><strong>Laudo #{{ $laudo->id }}</strong></p>
                            <p style="color: #6b7280; font-size: 0.875rem;">
                                Status: 
                                @php
                                    $statusLabels = [
                                        'rascunho' => 'Rascunho',
                                        'enviado' => 'Enviado',
                                        'assinado' => 'Assinado',
                                        'arquivado' => 'Arquivado'
                                    ];
                                @endphp
                                {{ $statusLabels[$laudo->status] ?? $laudo->status }}
                            </p>
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('laudos.show', $laudo) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Ver</a>
                            <a href="{{ route('laudos.download', $laudo) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Baixar</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @elseif($servico->status === 'concluido' && auth()->user()->isAdmin())
        <div style="margin-top: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #2563eb;">Gerar Laudo</h2>
            <form method="POST" action="{{ route('laudos.gerar', $servico) }}" style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                @csrf
                @php
                    $templates = \App\Models\LaudoTemplate::where('empresa_id', auth()->user()->empresa_id)
                        ->where('tipo_servico', $servico->tipo_servico)
                        ->where('ativo', true)
                        ->get();
                @endphp
                @if($templates->count() > 0)
                    <div class="form-group">
                        <label class="form-label">Selecione um Template (opcional)</label>
                        <select name="template_id" class="form-input">
                            <option value="">Usar template padrão</option>
                            @foreach($templates as $template)
                                <option value="{{ $template->id }}">{{ $template->nome_template }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <button type="submit" class="btn btn-primary">Gerar Laudo</button>
            </form>
        </div>
    @endif

    @if($servico->execucao)
        <div style="margin-top: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #2563eb;">Execução</h2>
            <div style="background-color: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                @if($servico->execucao->problemas_encontrados)
                    <p style="margin-bottom: 1rem;"><strong>Problemas Encontrados:</strong></p>
                    <p style="margin-bottom: 1rem;">{{ $servico->execucao->problemas_encontrados }}</p>
                @endif
                @if($servico->execucao->recomendacoes)
                    <p style="margin-bottom: 1rem;"><strong>Recomendações:</strong></p>
                    <p>{{ $servico->execucao->recomendacoes }}</p>
                @endif
                @if($servico->execucao->fotos && count($servico->execucao->fotos) > 0)
                    <div style="margin-top: 1rem;">
                        <p style="margin-bottom: 1rem;"><strong>Fotos:</strong></p>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem;">
                            @foreach($servico->execucao->fotos as $foto)
                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto" style="width: 100%; border-radius: 0.5rem;">
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection

